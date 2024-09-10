<?php

namespace Modules\Location\Services;

use GuzzleHttp\Client;
use App\Services\BaseService;
use Modules\Location\Models\Location;
use Illuminate\Support\Str;

class ImportLocationService extends BaseService
{    

    public function importLocations()
    {
        $locations = (new BaseService('hotel'))->getCities();
        foreach ($locations as $location){
            $row = new Location;
            $row->name        = ucwords(strtolower($location['countryName'])).' - '.ucwords(strtolower($location['cityName']));
            // $row->city_name   = ucwords(strtolower($location['cityName']));
            $row->code        = $location['id'];
            $row->slug        = Str::slug($location['cityName']);
            $row->map_zoom    = 12;
            $row->create_user = 1;
            $row->is_api      = 1;
            $row->status      = 'publish';

            $row->save();

        }
    }

}