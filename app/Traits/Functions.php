<?php

namespace App\Traits;

use Auth;
use DB;

trait Functions
{


    public function locations($locationId = null)
    {
        $locationsQuery = DB::table('locations');

        if ($locationId !== null) {
            $locationsQuery->where('id', $locationId);
        }
        // $locationsQuery->where('status', 1);
        $allLocations = $locationsQuery->get();
        return $allLocations;
    }




}