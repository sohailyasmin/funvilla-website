<?php

namespace App\Http\Controllers;

use App\Models\TermsAndCondition;
use App\Http\Requests\StoreTermsAndConditionRequest;
use App\Http\Requests\UpdateTermsAndConditionRequest;
use App\Models\FamilyMember;
use App\Models\Location;
use App\Models\WavierSignatureSnapshot;
use App\Models\WavierSnapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Spatie\QueryBuilder\QueryBuilder;

class TermsAndConditionController extends Controller
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
                'name' => 'Terms And Condition',
                'url' => route('terms-condition.index'),
                'active' => true
            ],
        ];

        // show all available location
        $user = auth()->user();
        $locations = null;

        if(!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        // Get selected location ID from query parameter  for filter
        $selectedLocationId = $request->get('location_id', 'all');

        $q = $request->get('q');
        $perPage = $request->get('per_page', 10);
        $sort = $request->get('sort');

        $query = QueryBuilder::for(TermsAndCondition::class)
                ->defaultSort('-created_at')
                ->allowedSorts(['is_default', 'created_at'])
                ->with('location')                
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%$q%");
                });
        
        if (!$user->hasRole('super-admin'))
            $query->whereIn('location_id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id]);

        // Apply location filter
        if ($selectedLocationId !== 'all') {
            $query->where('location_id', $selectedLocationId);
        }

        $termsAndConditions = $query
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'q' => $q, 'sort' => $sort]);


        return view('terms-condition.index', [
            'termsAndConditions' => $termsAndConditions,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Terms and Condition',
            'locations' => $locations,
            'selectedLocationId' => $selectedLocationId, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Create',
                'url' => route('terms-condition.create'),
                'active' => true
            ],
        ];

        $user = auth()->user();
        $locations = null;
        $tinyMcePath = '/js/tinymce/tinymce.min.js';

        if(!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        return view('terms-condition.create', [
            'locations' => $locations->toArray(),
            'tinyMcePath' => $tinyMcePath,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Create Terms And Conditions'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTermsAndConditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermsAndConditionRequest $request)
    {
//        dd($request->all());
        $termsAndConditionRequestData = $request->only(['text', 'is_default', 'location_id', 'title', 'description']);
        if(isset($termsAndConditionRequestData['is_default']) && $termsAndConditionRequestData['is_default']){
            QueryBuilder::for(TermsAndCondition::class)->defaultTermsAndCondition()->where('location_id', '=', $termsAndConditionRequestData['location_id'])
                ->update(['is_default' => false]);
            QueryBuilder::for(FamilyMember::class)->whereHas('customer', function($q) use($termsAndConditionRequestData) {
                    $q->where('location_id', '=', $termsAndConditionRequestData['location_id']);
            })->update(['wavier_status' => false]);
            QueryBuilder::for(WavierSnapshot::class)->whereHas('customer', function($q) use($termsAndConditionRequestData) {
                    $q->where('location_id', '=', $termsAndConditionRequestData['location_id']);
            })->update(['status' => false]);
            QueryBuilder::for(WavierSignatureSnapshot::class)->whereHas('customer', function($q) use($termsAndConditionRequestData) {
                    $q->where('location_id', '=', $termsAndConditionRequestData['location_id']);
            })->update(['status' => false]);
        }

        TermsAndCondition::create($termsAndConditionRequestData);

        $response = [
            'href' => 'terms-condition',
            'status' => true,
            'message' => 'Terms and Condition created successfully'
        ];

        Session::flash('message', 'Terms and Condition created successfully');

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermsAndCondition  $termsCondition
     * @return \Illuminate\Http\Response
     */
    public function show(TermsAndCondition $termsCondition)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Show',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('terms-condition.show', [
            'termsAndCondition' => $termsCondition,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Terms and Condition'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermsAndCondition  $termsCondition
     * @return \Illuminate\Http\Response
     */
    public function edit(TermsAndCondition $terms_condition)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => 'terms-condition.edit',
                'active' => true
            ],
        ];

        $user = auth()->user();
        $locations = null;
        $tinyMcePath = '/js/tinymce/tinymce.min.js';

        if(!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        return view('terms-condition.edit', [
            'locations' => $locations->toArray(),
            'tinyMcePath' => $tinyMcePath,
            'termsAndCondition' => $terms_condition,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Terms and Condition'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTermsAndConditionRequest  $request
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTermsAndConditionRequest $request, TermsAndCondition $terms_condition)
    {
        if($request->has('is_default') && $request->input('is_default')){
            QueryBuilder::for(TermsAndCondition::class)->defaultTermsAndCondition()->where('location_id', '=', $request['location_id'])
                ->update(['is_default' => false]);
            QueryBuilder::for(FamilyMember::class)->whereHas('customer', function($q) use($request) {
                    $q->where('location_id', '=', $request['location_id']);
            })->update(['wavier_status' => false]);
            QueryBuilder::for(WavierSnapshot::class)->whereHas('customer', function($q) use($request) {
                    $q->where('location_id', '=', $request['location_id']);
            })->update(['status' => false]);
            QueryBuilder::for(WavierSignatureSnapshot::class)->whereHas('customer', function($q) use($request) {
                    $q->where('location_id', '=', $request['location_id']);
            })->update(['status' => false]);
        }

        // Update Terms and Condition details
        $terms_condition->update($request->only(['text', 'is_default', 'location_id', 'title', 'description']));

        $response = [
            'href' => 'terms-condition',
            'status' => true,
            'message' => 'Terms and Condition Updated successfully'
        ];

        Session::flash('message', 'Terms and Condition Updated successfully');

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermsAndCondition  $termsAndCondition
     * @return \Illuminate\Http\Response
     */
    public function destroy(TermsAndCondition $termsCondition)
    {
        // Delete the Terms and Condition
        $termsCondition->delete();

        return redirect()->route('terms-condition.index')->with('message', 'Terms and Condition Deleted successfully');

    }
}
