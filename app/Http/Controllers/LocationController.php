<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class LocationController extends Controller
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
                'name' => 'Location',
                'url' => route('locations.index'),
                'active' => true
            ],
        ];

        $q = $request->get('q');
        $perPage = $request->get('per_page', 10);
        $sort = $request->get('sort');

        $locations = QueryBuilder::for(Location::class)
            ->allowedSorts(['name', 'slug'])
            ->where('name', 'like', "%$q%")
            ->orWhere('name', 'like', "%$q%")
            ->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'q' => $q, 'sort' => $sort]);

        return view('locations.index', [
            'breadcrumbItems' => $breadcrumbsItems,
            'locations' => $locations,
            'pageTitle' => 'Location'
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
                'name' => 'Location',
                'url' => route('locations.index'),
                'active' => true
            ],
        ];

        return view('locations.create', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Location',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:locations,name',
        ]);

        $data['slug'] = Str::slug($data['name'],'_',true);

        Location::create($data);

        return to_route('locations.index')->with('message', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Location',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('locations.show', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Location',
            'location' => $location,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Location',
                'url' => '#',
                'active' => true
            ],
        ];
        
        return view('locations.edit', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Location',
            'location' => $location,
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $data = $request->validate([
            'name' => 'required|unique:locations,name,' . $location->id,
        ]);

        $data['slug'] = Str::slug($data['name'],'_', true);

        $location->update($data);

        return to_route('locations.index')->with('message', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return to_route('locations.index')->with('message', 'Location deleted successfully.');
    }
}
