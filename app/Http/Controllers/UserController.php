<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Location;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\QueryBuilder;


class UserController extends Controller
{
    /**
     * Handle permission of this resource controller.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     *
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
                'name' => 'Employee',
                'url' => route('users.index'),
                'active' => true
            ],
        ];

        // Get selected location ID from query parameter  for filter
        $selectedLocationId = $request->get('location_id', 'all');

        $selectedStatusId = $request->get('status_id', 'all');

        $q = $request->get('q');
        $perPage = $request->get('per_page', 10);
        $sort = $request->get('sort');

        $user = auth()->user();
        $query = QueryBuilder::for(User::class)
            ->allowedSorts(['name', 'email', 'phone', 'post_code', 'city', 'country'])
            ->where('name', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")
            ->withoutAuthUser()
            ->withoutSuperAdmin();

        // show all available location

        $locations = null;

        // show all user statuses
        $statuses = [
            0 => [
                'name' => 'Inactive',
                'value' => 0
            ],
            1 => [
                'name' => 'Active',
                'value' => 1
            ]
        ];

        if(!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        if (!$user->hasRole('super-admin'))
            $query->whereIn('location_id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id]);

        // Apply location filter
        if ($selectedLocationId !== 'all')
            $query->where('location_id', $selectedLocationId);

        if ($selectedStatusId !== 'all')
            $query->where('status', $selectedStatusId);



        $users = $query->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'q' => $q, 'sort' => $sort]);


        return view('users.index', [
            'users' => $users,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Employee',
            'locations' => $locations,
            'selectedLocationId' => $selectedLocationId,
            'statuses' => $statuses,
            'selectedStatusId' => $selectedStatusId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     *
     */
    public function create()
    {
        $breadcrumbsItems = [
            [
                'name' => 'Employee',
                'url' => route('users.index'),
                'active' => false
            ],
            [
                'name' => 'Create',
                'url' => route('users.create'),
                'active' => true
            ],
        ];
        $locations = Location::all();
        $roles = Role::all();
        return view('users.create', [
            'roles' => $roles,
            'locations' => $locations,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Create Employee'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return RedirectResponse
     *
     */
    public function store(StoreUserRequest $request)
    {
        $userData = $request->safe(['name', 'email', 'city', 'phone', 'status', 'access_locations', 'address', 'location_id'])
            + [
                'password' => bcrypt($request->validated('password')),
                'email_verified_at' => now(),
            ];

        if(isset($userData['access_locations']) && is_array($userData))
            $userData['access_locations'] = implode(',', $userData['access_locations']);
        else
            $userData['access_locations'] = null;

        $user = User::create($userData);
        $user->assignRole([$request->validated('role')]);

        return redirect()->route('users.index')->with('message', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return Application|Factory|View
     *
     */
    public function show(User $user)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Employee',
                'url' => route('users.index'),
                'active' => false
            ],
            [
                'name' => 'Show',
                'url' => '#',
                'active' => true
            ],
        ];

        return view('users.show', [
            'user' => $user,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Employee',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return Application|Factory|View
     *
     */
    public function edit(User $user)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Employee',
                'url' => route('users.index'),
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => '#',
                'active' => true
            ],
        ];


        $roles = Role::all();
        $locations = Location::all();
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'locations' => $locations,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Employee',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return RedirectResponse
     *
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $userData = $request->safe(['name', 'email', 'phone', 'city', 'status', 'access_locations', 'address', 'location_id']);

        if($request->has('password') && isset($request->password) && auth()->user()->hasRole('super-admin'))
            $userData['password'] = bcrypt($request->validated(['password']));

        if(isset($userData['access_locations']) && is_array($userData))
            $userData['access_locations'] = implode(',', $userData['access_locations']);
        else
            $userData['access_locations'] = null;

        $user->update($userData);

        $user->syncRoles([$request->validated(['role'])]);

        return redirect()->route('users.index')->with('message', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return RedirectResponse
     *
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index')->with('message', 'Employee deleted successfully');
    }
}
