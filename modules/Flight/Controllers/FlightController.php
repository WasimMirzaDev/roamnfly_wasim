<?php
namespace Modules\Flight\Controllers;

use App\Http\Controllers\Controller;
use Modules\Flight\Models\SeatType;
use Modules\Location\Models\LocationCategory;
use Modules\Flight\Services\FlightService;
use Modules\Flight\Models\Flight;
use Illuminate\Http\Request;
use Modules\Location\Models\Location;
use Modules\Review\Models\Review;
use Modules\Core\Models\Attributes;
use Auth;
use DB;
use Illuminate\Support\Facades\Cookie;
class FlightController extends Controller
{
    protected $flightClass;
    protected $locationClass;
    /**
     * @var string
     */
    private $locationCategoryClass;

    public function __construct(Flight $flightClass, Location $locationClass, protected FlightService $flightService)
    {
        $this->flightClass = $flightClass;
        $this->locationClass = $locationClass;
    }

    public function callAction($method, $parameters)
    {
        if(!Flight::isEnable())
        {
            return redirect('/');
        }
        return parent::callAction($method, $parameters);
    }


    public function indexC(Request $request)
    {
        $layout = setting_item("flight_layout_search", 'normal');
        if ($request->query('_layout')) {
            $layout = $request->query('_layout');
        }

        $is_ajax = $request->query('_ajax');
        $for_map = $request->query('_map',$layout === 'map');

        if(!empty($request->query('limit'))){
            $limit = $request->query('limit');
        }else{
            $limit = !empty(setting_item("flight_page_limit_item"))? setting_item("flight_page_limit_item") : 9;
        }

        $query = $this->flightService->searchFlight($request->input());

        $view  ='Flight::frontend.search';
        if($request->travel_type == 'Round Trip'){
            if(isset($query['ONWARD'])){
                $list    = $this->flightService->paginate($request, $query['ONWARD'] ?? $query, $limit);
                $return  = $this->flightService->paginate($request, $query['RETURN'] ?? $query, $limit);
                $list    = $this->flightService->pairFlights($list,$return);
            }
            if(isset($query['COMBO'])){
                $list   = $this->flightService->pairComboFlights($query['COMBO']);
            }
            $list    = $this->flightService->paginate($request, $list ?? [], $limit);
            $view    ='Flight::frontend.returnSearch';
        }else{
            $list = $this->flightService->paginate($request, $query['ONWARD'] ?? $query, $limit);
        }
        
        $markers = [];
        if (!empty($list) and $for_map) {
            foreach ($list as $row) {
                $markers[] = [
                    "id"      => $row->id,
                    "title"   => $row->title,
                    "lat"     => (float)$row->map_lat,
                    "lng"     => (float)$row->map_lng,
                    "gallery" => $row->getGallery(true),
                    "infobox" => view('Flight::frontend.layouts.search.loop-grid', ['row' => $row,'disable_lazyload'=>1,'wrap_class'=>'infobox-item'])->render(),
                    'marker' => get_file_url(setting_item("flight_icon_marker_map"),'full') ?? url('images/icons/png/pin.png'),
                ];
            }
        }
        $limit_location = 15;
        if( empty(setting_item("flight_location_search_style")) or setting_item("flight_location_search_style") == "normal" ){
            $limit_location = 1000;
        }
        $data = [
            'rows' => $list,
            'layout'=>$layout
        ];
        if ($is_ajax) {
            return $this->sendSuccess([
                "markers" => $markers,
                'fragments'=>[
                    '.ajax-search-result'=>view('Flight::frontend.ajax.search-result'.($for_map ? '-map' : ''), $data)->render(),
                    '.result-count'=>$list->total() ? ($list->total() > 1 ? __(":count flights found",['count'=>$list->total()]) : __(":count flight found",['count'=>$list->total()])) : '',
                    '.count-string'=> $list->total() ? __("Showing :from - :to of :total Flights",["from"=>$list->firstItem(),"to"=>$list->lastItem(),"total"=>$list->total()]) : ''
                ]
            ]);
        }
        $data = [
            'rows'               => $list,
            'list_location'      => $this->locationClass::where('status', 'publish')->limit($limit_location)->with(['translation'])->get()->toTree(),
            'seatType'           => SeatType::get(),
            'flight_min_max_price' => $this->flightClass::getMinMaxPrice(),
            'markers'            => $markers,
            "blank" => setting_item('search_open_tab') == "current_tab" ? 0 : 1 ,
            "seo_meta"           => $this->flightClass::getSeoMetaForPageList(),
            'layout'=>$layout
        ];
        $data['attributes'] = Attributes::where('service', 'flight')->orderBy("position","desc")->with(['terms'=>function($query){
            $query->withCount('flight');
        },'translation'])->get();

        if ($layout == "map") {
            $data['body_class'] = 'has-search-map';
            $data['html_class'] = 'full-page';
            return view('Flight::frontend.search-map', $data);
        }
        return view($view, $data);
    }

    public function index(Request $request)
    {
        $layout = setting_item("flight_layout_search", 'normal');
        if ($request->query('_layout')) {
            $layout = $request->query('_layout');
        }

        $is_ajax = $request->query('_ajax');
        $for_map = $request->query('_map',$layout === 'map');

        if(!empty($request->query('limit'))){
            $limit = $request->query('limit');
        }else{
            $limit = !empty(setting_item("flight_page_limit_item"))? setting_item("flight_page_limit_item") : 9;
        }
        // dd($request->input());
        if($request->travel_type == 'Multicity'){
            $query = $this->flightService->searchMultiFlights($request->input());
            // dd($query);
        }
        else{
            $query = $this->flightService->searchFlight($request->input());
        }

        $view  ='Flight::frontend.search';

        // dd($query);
        if($request->travel_type == 'Round Trip'){
            if(isset($query['ONWARD'])){
                if (count($query) === 2) {
                    $count1 = count($query['ONWARD']);
                    $count2 = count($query['RETURN']);
                
                    $minCount = min($count1, $count2);
                
                    $query['ONWARD'] = array_slice($query['ONWARD'], -$minCount);
                    $query['RETURN'] = array_slice($query['RETURN'], -$minCount);
                }
                $list    = $this->flightService->paginate($request, $query['ONWARD'] ?? $query, $limit);
                $return  = $this->flightService->paginate($request, $query['RETURN'] ?? $query, $limit);
                $list    = $this->flightService->pairFlights($list,$return);
            }
            if(isset($query['COMBO'])){
                $list   = $this->flightService->pairComboFlights($query['COMBO']);
            }
            $list    = $this->flightService->paginate($request, $list ?? [], $limit);
            $view    ='Flight::frontend.returnSearch';

        }
        else if($request->travel_type == 'Multicity'){
            // dd($query);
        // if(isset($query[0]['ONWARD'])){
            $list   = $query;
        // }
        
        $list    = $this->flightService->paginate($request, $list ?? [], $limit);
        $view    ='Flight::frontend.returnMultiSearch';
        }
        else{
            $list = $this->flightService->paginate($request, $query['ONWARD'] ?? $query, $limit);
        }
        
        $markers = [];
        if (!empty($list) and $for_map) {
            foreach ($list as $row) {
                $markers[] = [
                    "id"      => $row->id,
                    "title"   => $row->title,
                    "lat"     => (float)$row->map_lat,
                    "lng"     => (float)$row->map_lng,
                    "gallery" => $row->getGallery(true),
                    "infobox" => view('Flight::frontend.layouts.search.loop-grid', ['row' => $row,'disable_lazyload'=>1,'wrap_class'=>'infobox-item'])->render(),
                    'marker' => get_file_url(setting_item("flight_icon_marker_map"),'full') ?? url('images/icons/png/pin.png'),
                ];
            }
        }
        $limit_location = 15;
        if( empty(setting_item("flight_location_search_style")) or setting_item("flight_location_search_style") == "normal" ){
            $limit_location = 1000;
        }
        $data = [
            'rows' => $list,
            'layout'=>$layout
        ];
        // dd($data);
        if ($is_ajax) {
            return $this->sendSuccess([
                "markers" => $markers,
                'fragments'=>[
                    '.ajax-search-result'=>view('Flight::frontend.ajax.search-result'.($for_map ? '-map' : ''), $data)->render(),
                    '.result-count'=>$list->total() ? ($list->total() > 1 ? __(":count flights found",['count'=>$list->total()]) : __(":count flight found",['count'=>$list->total()])) : '',
                    '.count-string'=> $list->total() ? __("Showing :from - :to of :total Flights",["from"=>$list->firstItem(),"to"=>$list->lastItem(),"total"=>$list->total()]) : ''
                ]
            ]);
        }
        $data = [
            'rows'               => $list,
            'list_location'      => $this->locationClass::where('status', 'publish')->limit($limit_location)->with(['translation'])->get()->toTree(),
            'seatType'           => SeatType::get(),
            'flight_min_max_price' => $this->flightClass::getMinMaxPrice(),
            'markers'            => $markers,
            "blank" => setting_item('search_open_tab') == "current_tab" ? 0 : 1 ,
            "seo_meta"           => $this->flightClass::getSeoMetaForPageList(),
            'layout'=>$layout
        ];
        $data['attributes'] = Attributes::where('service', 'flight')->orderBy("position","desc")->with(['terms'=>function($query){
            $query->withCount('flight');
        },'translation'])->get();

        if ($layout == "map") {
            $data['body_class'] = 'has-search-map';
            $data['html_class'] = 'full-page';
            return view('Flight::frontend.search-map', $data);
        }
        return view($view, $data);
    }

    public function getData(Request $request,$id){
        $row = $this->flightService->reviewSelectedFlight($id);
        // dd($row);

        if ( empty($row)) {
            return $this->sendError(__("Please try other flight."));
        }else{
            $data = $this->flightService->formatApiData($row);
            // dd($data);
            return $this->sendSuccess(['data' => $data],'founded');
        }
    }

    public function getMultiData(Request $request,$id){
        $row = $this->flightService->reviewSelectedMultiFlight($id);
        if ( empty($row)) {
            return $this->sendError(__("Please try other flight."));
        }else{
            $data = $this->flightService->formatApiData($row);
            
            return $this->sendSuccess(['data' => $data],'founded');
        }
    }

    public function addToCart(Request $request)
    {
        if (!is_enable_guest_checkout() and !Auth::check()) {
            return $this->sendError(__("You have to login in to do this"))->setStatusCode(401);
        }
        if (auth()->user() && !auth()->user()->hasVerifiedEmail() && setting_item('enable_verify_email_register_user') == 1) {
            return $this->sendError(__("You have to verify email first"), ['url' => url('/email/verify')]);
        }
        $validator = \Validator::make($request->all(), [
            'service_id'   => 'required',
            'service_type' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }
        $service_type = $request->input('service_type');
        $service_id = $request->input('service_id');
        $allServices = get_bookable_services();
        if (empty($allServices[$service_type])) {
            return $this->sendError(__('Service type not found'));
        }
        if(count(value: $request->flight ?? []) == 2){
            $booked = $this->flightService->returnAddToCart($request);
        }else{
            $booked = $this->flightService->addToCart($request);
        }
        return $this->sendSuccess($booked);
    }
    public function MultiaddToCart(Request $request)
    {
        if (!is_enable_guest_checkout() and !Auth::check()) {
            return $this->sendError(__("You have to login in to do this"))->setStatusCode(401);
        }
        if (auth()->user() && !auth()->user()->hasVerifiedEmail() && setting_item('enable_verify_email_register_user') == 1) {
            return $this->sendError(__("You have to verify email first"), ['url' => url('/email/verify')]);
        }
        $validator = \Validator::make($request->all(), [
            'service_id'   => 'required',
            'service_type' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }
        $service_type = $request->input('service_type');
        $service_id = $request->input('service_id');
        $allServices = get_bookable_services();
        if (empty($allServices[$service_type])) {
            return $this->sendError(__('Service type not found'));
        }
            $booked = $this->flightService->MultiAddToCart($request);

        return $this->sendSuccess($booked);
    }
}