<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\BookingSlot;
use App\Models\LocationCategory;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\TermsAndCondition;
use App\Models\TicketGuest;
use Carbon\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class TicketController extends Controller
{

    use \App\Traits\Functions;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Ticket',
                'url' => route('tickets.index'),
                'active' => true
            ],
        ];

        // show all available location
        $user = auth()->user();
        $location_id = 1;

        //  $location_id = session('location_id');

        if ($location_id) {
            $locationCategoryIds = LocationCategory::where('location_id', $location_id)
                ->pluck('category_id')
                ->all();
            $categories = Category::whereIn('id', $locationCategoryIds)->get();

        } else {
            $locations = Location::all();
        }



        return response()->view('website.tickets', [
            'categories' => $categories,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Ticket',
            // 'locations' => $locations
        ]);


    }




    /**
     * Display the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function category_tickets($id)
    {
        try {
            $response = Ticket::select('id', 'name', 'display_name', 'description')->whereRaw("FIND_IN_SET(?, category_ids)", [$id])->where(['status' => 1])->get();

            if ($response->isEmpty()) {
                return response()->json(['data' => '']);
            }

            // $utf8EncodedData = $this->convertToUTF8($response);

            return response()->json(['data' => $response]);
        } catch (\Exception $e) {

            \Log::error($e);

            return response()->json(['message' => 'An error occurred while processing the request'], 500);
        }
    }

    private function convertToUTF8($data)
    {

        return $data->map(function ($item) {
            return array_map(function ($field) {
                return is_string($field) ? utf8_encode($field) : $field;
            }, $item->toArray());
        });
    }



    public function parties(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Ticket',
                'url' => route('tickets.index'),
                'active' => true
            ],
        ];

        // show all available location
        $user = auth()->user();
        $location_id = 1;

        //  $location_id = session('location_id');

        $locations = $this->locations();

        $parties = [

        ];

        //   [
        //      "id" => 1,
        //      "from" => "13:00:00",
        //      "to" => "14:30:00",
        //      "status" => 1,
        //      "location_id" => 1,
        //    ]


        $slots = BookingSlot::where(['location_id' => $location_id, 'status' => 1])->get();


        return response()->view('website.parties', [
            // 'categories' => $categories,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Ticket',
            'locations' => $locations,
            'slots' => $slots
        ]);


    }


    public function groups(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Ticket',
                'url' => route('groups.index'),
                'active' => true
            ],
        ];


        $user = auth()->user();
        $location_id = 1;

        $locations = $this->locations();

        return response()->view('website.groups', [
            'location_id' => $location_id,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Ticket',
            'locations' => $locations
        ]);


    }



    public function memberships(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Ticket',
                'url' => route('memberships.index'),
                'active' => true
            ],
        ];

        $user = auth()->user();
        $location_id = 1;
        $locations = $this->locations();
        $parties = [];

        $slots = BookingSlot::where(['location_id' => $location_id, 'status' => 1])->get();

        return response()->view('website.memberships', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Ticket',
            'locations' => $locations,
            'slots' => $slots
        ]);


    }

    public function events(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Ticket',
                'url' => route('memberships.index'),
                'active' => true
            ],
        ];

        $user = auth()->user();
        $location_id = 1;
        $locations = $this->locations();
        $parties = [];

        $slots = BookingSlot::where(['location_id' => $location_id, 'status' => 1])->get();

        return response()->view('website.events', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Ticket',
            'locations' => $locations,
            'slots' => $slots
        ]);


    }
}
