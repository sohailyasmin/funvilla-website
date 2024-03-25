<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
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

class CheckoutController extends Controller
{
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





        return response()->view('website.checkout', [

            'pageTitle' => 'Ticket',
            // 'locations' => $locations
        ]);


    }






}
