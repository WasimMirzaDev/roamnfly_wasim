<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\CustomApiLog;
use Modules\Location\Models\Location;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;


class BaseService
{    

    protected $apiToken = '81204443785835-a773-4c38-9fc3-f99bdef05ab1';
    protected $tripJackUrl = 'https://apitest.tripjack.com';
    protected $version     = '/v1/';
    protected $customApiLogClass;
    protected $client;
    protected $apiType;

    public function __construct($apiType = 'hotel')
    {
        $this->apiType           = $apiType;
        $this->customApiLogClass = CustomApiLog::class;
    }

    protected function getEndpoint($endpoint, $apiType = null)
    {
        if($apiType)
        {
            $this->apiType           = $apiType;
        }
        return $this->tripJackUrl . $this->getApiType($this->apiType). $this->version. $endpoint;
    }

    protected function getApiType($apiType)
    {
        if($apiType == 'hotel')
        {
            return '/hms';
        }else if($apiType == 'flight')
        {
            return '/flight';
        }else
        {
            return '/'.$apiType;
        }
    }


    public function getCities()
    {
        try {
            $response = Http::withHeaders(['apikey' => $this->apiToken])->get($this->getEndpoint('static-cities/'));
            if ($response->successful()) {
                return $response->json()['response']['cil'];
            } else {
                // Log error and return empty array
                $this->generateEmailLog('static-cities', $this->apiType, $response->status(), $response->body());
                return [];
            }
        } catch (\Exception $e) {
            $this->generateEmailLog('static-cities', $this->apiType, $e->getCode(), $e->getMessage());
            return [];
        }
    }

    public function getLocationCode($id)
    {
        return Location::where('id',$id)->first('code')->code;
    }

    public static function paginate(Request $request, $items, $perPage = 15)
    {
        $page = $request->input('page', 1); // Get the current page number, default to 1
        $collection = collect($items); // Convert the array to a collection
        $currentPageItems = $collection->forPage($page, $perPage);

        return new LengthAwarePaginator(
            $currentPageItems, // Items for the current page
            $collection->count(), // Total number of items
            $perPage, // Number of items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // For generating pagination links
        );
    }

    public function generateEmailLog($api, $type, $status, $message)
    {
        $row = new $this->customApiLogClass();
        $row->api = $api;
        $row->type = $type;
        $row->status = $status;
        $row->message = $message;
        $row->save();
        
        return true;
    }
}