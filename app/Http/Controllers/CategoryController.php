<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Location;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
                'name' => 'Category',
                'url' => route('categories.index'),
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

        $query = QueryBuilder::for(Category::class)
                ->allowedSorts(['is_default', 'created_at'])
                ->with('location');
        
        if (!$user->hasRole('super-admin'))
            $query->whereIn('location_id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id]);

        // Apply location filter
        if ($selectedLocationId !== 'all') {
            $query->where('location_id', $selectedLocationId);
        }

        $categories = $query
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'q' => $q, 'sort' => $sort]);


        return view('categories.index', [
            'categories' => $categories,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Category',
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
                'url' => route('categories.create'),
                'active' => true
            ],
        ];

        $user = auth()->user();
        $locations = null;

        if(!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        return view('categories.create', [
            'locations' => $locations,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Create Categories'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $categoryRequestData = $request->only(['name', 'description', 'location_id']);
        $categoryRequestData['slug'] = Str::slug($categoryRequestData['name'],'_',true);
        Category::create($categoryRequestData);
        return to_route('categories.index')->with('message', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
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

        return view('categories.show', [
            'category' => $category,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Category'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => 'categories.edit',
                'active' => true
            ],
        ];

        $user = auth()->user();
        $locations = null;
        
        if(!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        return view('categories.edit', [
            'locations' => $locations,
            'category' => $category,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Category'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $categoryRequestData = $request->only(['name', 'description', 'location_id']);
        $categoryRequestData['slug'] = Str::slug($categoryRequestData['name'],'_',true);

        $category->update($categoryRequestData);

        return to_route('categories.index')->with('message', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Delete the Category
        $category->delete();

        return redirect()->route('categories.index')->with('message', 'Category Deleted successfully');

    }
}
