<?php

namespace App\Http\Controllers;

use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;

class AccountTypeController extends Controller
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
                'name' => 'Account Type',
                'url' => route('locations.index'),
                'active' => true
            ],
        ];

        $q = $request->get('q');
        $perPage = $request->get('per_page', 10);
        $sort = $request->get('sort');

        $locations = QueryBuilder::for(AccountType::class)
            ->allowedSorts(['name', 'slug'])
            ->where('name', 'like', "%$q%")
            ->orWhere('name', 'like', "%$q%")
            ->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'q' => $q, 'sort' => $sort]);

        return view('locations.index', [
            'breadcrumbItems' => $breadcrumbsItems,
            'locations' => $locations,
            'pageTitle' => 'Account Type'
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
                'name' => 'Account Type',
                'url' => route('locations.index'),
                'active' => true
            ],
        ];

        return view('locations.create', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Account Type',
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

        AccountType::create($data);

        return to_route('locations.index')->with('message', 'Account Type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AccountType $accountType)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Account Type',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('locations.show', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Account Type',
            'accountType' => $accountType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountType $accountType)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Account Type',
                'url' => '#',
                'active' => true
            ],
        ];
        
        return view('locations.edit', [
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Account Type',
            'accountType' => $accountType,
        ]);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountType $accountType)
    {
        $data = $request->validate([
            'name' => 'required|unique:locations,name,' . $accountType->id,
        ]);

        $data['slug'] = Str::slug($data['name'],'_', true);

        $accountType->update($data);

        return to_route('locations.index')->with('message', 'Account Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountType $accountType)
    {
        $accountType->delete();

        return to_route('locations.index')->with('message', 'Account Type deleted successfully.');
    }
}
