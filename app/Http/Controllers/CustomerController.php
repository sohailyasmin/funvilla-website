<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerFMRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\AccountType;
use App\Models\Country;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Customer;
use App\Models\Location;
use App\Models\TermsAndCondition;
use App\Models\CustomerRemark;
use App\Models\WavierSignatureSnapshot;
use App\Models\WavierSnapshot;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function website()
    {
        return view('website.index');
    }
    public function index(Request $request)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Customer',
                'url' => route('customers.index'),
                'active' => true
            ],
        ];

        // show all available location
        $user = auth()->user();
        $locations = null;

        if (!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        // Get selected location ID from query parameter  for filter
        $selectedLocationId = $request->get('location_id', 'all');

        $q = $request->get('q');
        $perPage = $request->get('per_page', 10);
        $sort = $request->get('sort');


        $query = QueryBuilder::for(Customer::class)
            ->allowedSorts(['first_name', 'last_name', 'dob', 'email', 'phone', 'postal_code', 'city', 'state'])
            ->with('location')
            ->where('user_id', auth()->user()->id)
            ->where(function ($query) use ($q) {
                $query->where('first_name', 'like', "%$q%")
                    ->orWhere('last_name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('city', 'like', "%$q%")
                    ->orWhere('state', 'like', "%$q%");
            });

        if (!$user->hasRole('super-admin'))
            $query->whereIn('location_id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id]);

        // Apply location filter
        if ($selectedLocationId !== 'all') {
            $query->where('location_id', $selectedLocationId);
        }

        $customers = $query->latest()
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'q' => $q, 'sort' => $sort]);


        return view('customers.index', [
            'customers' => $customers,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Customers',
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
                'url' => route('customers.create'),
                'active' => true
            ],
        ];

        $user = auth()->user();
        $locations = null;

        if (!$user->hasRole('super-admin'))
            $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
        else
            $locations = Location::all();

        $account_types = AccountType::all();
        $termsAndCondition = TermsAndCondition::defaultTermsAndCondition()->get();

        $months = [];

        for ($m = 1; $m <= 12; $m++)
            array_push($months, ['id' => $m, 'name' => date('F', mktime(0, 0, 0, $m, 1, date('Y')))]);

        $years = [];

        for ($y = (int) Carbon::now()->format('Y'); $y >= 1970; $y--)
            array_push($years, ['id' => $y, 'name' => $y]);

        // $userRole = auth()->user()->roles;

        return view('customers.create', [
            'months' => $months,
            'years' => $years,
            'locations' => $locations->toArray(),
            'account_types' => $account_types,
            'terms_and_condition' => $termsAndCondition,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'SIGNING A WAIVER'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $customerRequestData = $request->only([
            'first_name',
            'last_name',
            'password',
            'dob',
            'email',
            'country_code',
            'phone',
            'postal_code',
            'city',
            'state',
            'address',
            'location_id',
            'account_type_id',
            'organisation_name',
            'heard_about_us',
            'news_subscription'
        ]);



        $customerRequestData['country_code'] = $this->getCountryCode($request->location_id);

        if ($customerRequestData['account_type_id'] == '1')
            unset($customerRequestData['organisation_name']);

        $mainCustomer = Customer::create($customerRequestData);

        //store wavier remarks
        $remarks = $request->input('customer_remarks', '');

        if (!empty($remarks)) {
            //  $customerRemarksRequestData = ['remarks' => $remarks, 'customer_id' => $mainCustomer->id];
            // CustomerRemark::create($customerRemarksRequestData);
        }

        // Create family members if provided
        $familyMembers = $request->input('family_members', []);

        $custFamilyMember = Arr::first($familyMembers, function ($value, $key) {
            return isset($value["signature"]) && !empty($value["signature"]) && $value['type'] == 'customer';
        }) ?? [];

        foreach ($familyMembers as $i => $familyMember) {
            $familyMemberData = [
                'first_name' => $familyMember["family_first_name"],
                'last_name' => $familyMember["family_last_name"],
                'dob' => $familyMember["family_dob"],
                'type' => $familyMember["type"],
                'wavier_status' => true,
                'terms_and_conditions' => $request->input("terms_and_conditions"),
                'customer_id' => $mainCustomer->id, // Associate with the main customer
            ];

            if ($familyMember["type"] == 'infants' && !empty($custFamilyMember))
                $familyMemberData['signature'] = $custFamilyMember["signature"];
            else if (isset($familyMember["signature"]) && !empty($familyMember["signature"]))
                $familyMemberData['signature'] = $familyMember["signature"];

            FamilyMember::create($familyMemberData);
        }

        if (count($familyMembers) > 0)
            $this->storeWavierSnapShot($mainCustomer, $request->input("terms_and_conditions"));

        $response = [
            'href' => 'customers',
            'status' => true,
            'message' => 'Customer created successfully'
        ];

        Session::flash('message', 'Customer created successfully');

        return response()->json($response);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
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

        $family_members = FamilyMember::where('customer_id', $customer->id)->get();

        return view('customers.show', [
            'customer' => $customer,
            'family_members' => $family_members,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Show Customer',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Edit',
                'url' => 'customers.edit',
                'active' => true
            ],
        ];
        $locations = null;
        if (!empty($customer->location_id))
            $locations = Location::where('id', $customer->location_id)->get();
        else {
            $user = auth()->user();
            if (!$user->hasRole('super-admin'))
                $locations = Location::whereIn('id', $user->access_locations ? explode(',', $user->access_locations) : [$user->location_id])->get();
            else
                $locations = Location::all();
        }

        $account_types = AccountType::where('id', $customer->account_type_id)->get();
        $termsAndCondition = TermsAndCondition::defaultTermsAndCondition()->where('location_id', $customer->location_id)->first();
        $months = [];
        for ($m = 1; $m <= 12; $m++)
            array_push($months, ['id' => $m, 'name' => date('F', mktime(0, 0, 0, $m, 1, date('Y')))]);

        $years = [];
        for ($y = (int) Carbon::now()->format('Y'); $y >= 1970; $y--)
            array_push($years, ['id' => $y, 'name' => $y]);


        if (isset($customer->dob) && !empty($customer->dob)) {
            $customer->month_dob = Carbon::createFromFormat('Y-m-d', $customer->dob)->month;
            $customer->year_dob = Carbon::createFromFormat('Y-m-d', $customer->dob)->year;
        }

        return view('customers.edit', [
            'customer' => $customer,
            'months' => $months,
            'years' => $years,
            'locations' => $locations->toArray(),
            'account_types' => $account_types,
            'terms_and_condition' => $termsAndCondition,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Customer',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editCustomerFamilyMember(Customer $customer)
    {
        $breadcrumbsItems = [
            [
                'name' => 'Settings',
                'url' => '/general-settings',
                'active' => false
            ],
            [
                'name' => 'Edit Waiver',
                'url' => 'customers.family-member.edit',
                'active' => true
            ],
        ];
        $family_members = FamilyMember::where('customer_id', $customer->id)
            ->select('id as family_id', 'first_name as family_first_name', 'last_name as family_last_name', \DB::raw('YEAR(dob) as family_year_dob'), \DB::raw('MONTH(dob) as family_month_dob'), 'dob as family_dob', 'type', 'wavier_status as readOnly')->get()->toArray();
        $family_member_count = count($family_members);
        $termsAndCondition = TermsAndCondition::defaultTermsAndCondition()->where('location_id', $customer->location_id)->first();
        $custWavierRemarks = $customer->remarks()->latest()->take(10)->get()->toArray();
        $months = [];
        for ($m = 1; $m <= 12; $m++)
            array_push($months, ['id' => $m, 'name' => date('F', mktime(0, 0, 0, $m, 1, date('Y')))]);

        $years = [];
        for ($y = (int) Carbon::now()->format('Y'); $y >= 1970; $y--)
            array_push($years, ['id' => $y, 'name' => $y]);

        // parse month and year from dob and append into customer attribute
        $customer->month_dob = Carbon::parse($customer->dob)->format('m');
        $customer->year_dob = Carbon::parse($customer->dob)->format('Y');

        return view('customers.familyMemberEdit', [
            'customer' => $customer,
            'familyMembers' => $family_members,
            'familMemberCount' => $family_member_count,
            'months' => $months,
            'years' => $years,
            'terms_and_condition' => $termsAndCondition,
            'cust_wavier_remarks' => $custWavierRemarks,
            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Edit Waiver',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateCustomerFM(UpdateCustomerFMRequest $request, Customer $customer)
    {
        //store wavier remarks
        $remarks = $request->input('customer_remarks', '');

        if (!empty($remarks)) {
            $customerRemarksRequestData = ['remarks' => $remarks, 'customer_id' => $customer->id];
            CustomerRemark::create($customerRemarksRequestData);
        }

        // Create family members if provided
        $familyMembers = $request->input('family_members', []);
        $custFamilyMember = Arr::first($familyMembers, function ($value, $key) {
            return isset($value["signature"]) && !empty($value["signature"]) && $value['type'] == 'customer';
        }) ?? [];

        $isWavierSigned = false;

        foreach ($familyMembers as $i => $familyMember) {
            if (!isset($familyMember["readOnly"]) || !$familyMember["readOnly"]) {
                if (
                    isset($familyMember["isDeleted"]) && $familyMember["isDeleted"] == 1
                    && isset($familyMember["family_id"]) && !empty($familyMember["family_id"])
                ) {
                    QueryBuilder::for(FamilyMember::class)->find($familyMember["family_id"])->delete();
                    $isWavierSigned = true;
                    continue;
                }
                $familyMemberData = [
                    'first_name' => $familyMember["family_first_name"],
                    'last_name' => $familyMember["family_last_name"],
                    'dob' => $familyMember["family_dob"],
                    'type' => $familyMember["type"],
                    'wavier_status' => true,
                    'terms_and_conditions' => $request->input("terms_and_conditions"),
                    'customer_id' => $customer->id, // Associate with the main customer
                ];

                if (isset($familyMember["signature"]) && !empty($familyMember["signature"]))
                    $familyMemberData['signature'] = $familyMember["signature"];
                else if ($familyMember["type"] == 'infants' && !empty($custFamilyMember))
                    $familyMemberData['signature'] = $custFamilyMember["signature"];

                $familyMemberQuery = QueryBuilder::for(FamilyMember::class);

                if (isset($familyMember["family_id"]) && !empty($familyMember["family_id"]))
                    $familyMemberQuery->find($familyMember["family_id"])->update($familyMemberData);
                else
                    $familyMemberQuery->create($familyMemberData);

                if (!$isWavierSigned)
                    $isWavierSigned = true;
            }
        }

        if ($isWavierSigned && count($familyMembers) > 0)
            $this->storeWavierSnapShot($customer, $request->input("terms_and_conditions"));

        $response = [
            'href' => 'customers',
            'status' => true,
            'message' => 'Family Member Updated successfully'
        ];

        Session::flash('message', 'Family Member Updated successfully');

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $request['country_code'] = $this->getCountryCode($request->location_id);
        // Update customer details
        $customer->update($request->only([
            'first_name',
            'last_name',
            'dob',
            'phone',
            'city',
            'state',
            'postal_code',
            'address',
            'location_id',
            'country_code',
            'news_subscription'
        ]));

        $customer->familyMembers()->update(['wavier_status' => false]);

        if ($customer->wavierSnapshots->isNotEmpty())
            $customer->wavierSnapshots()->update(['status' => false]);

        if ($customer->wavierSignatureSnapshots->isNotEmpty())
            $customer->wavierSignatureSnapshots()->update(['status' => false]);

        // Update family members
        // $familyMemberData = $request->input('family_member_data', []);

        // foreach ($familyMemberData as $index => $data) {
        //     $familyMember = FamilyMember::find($data['id']);
        //     //  if ($familyMember) {
        //     $familyMember->update([
        //         'first_name' => $data['first_name'],
        //         'last_name' => $data['last_name'],
        //         'dob' => $data['dob'],
        //     ]);
        // }
        //  }

        $response = [
            'href' => 'customers',
            'status' => true,
            'message' => 'Family Member Updated successfully'
        ];

        $response = [
            'href' => 'customers',
            'status' => true,
            'message' => 'Customer updated successfully'
        ];

        Session::flash('message', 'Customer updated successfully');

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        // Delete associated family members
        $customer->familyMembers()->delete();

        // Delete the customer
        $customer->delete();

        return redirect()->route('customers.index')->with('message', 'Customer Deleted successfully');
    }

    private function storeWavierSnapShot($customer, $termsAndCondition)
    {
        $wavierSnapShotReqData = [];
        $wavierCustomer = QueryBuilder::for(Customer::class)->where('id', $customer->id)
            ->excludeForSnapshot(['password', 'heard_about_us'])
            ->first()->toArray();
        $wavierTermsAndCondition = ['text' => $termsAndCondition];

        $familyMembers = $customer->familyMembers()->excludeForSnapshot(['customer_id', 'terms_and_condition', 'signature'])
            ->oldest()->get()->toArray();

        $wavierSnapShotData = [
            'customer' => $wavierCustomer,
            'tc' => $wavierTermsAndCondition,
            'family_member' => $familyMembers,
        ];

        foreach ($wavierSnapShotData as $snapShotKey => $snapShotValue) {
            foreach ($snapShotValue as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $subKey => $subValue)
                        $wavierSnapShotReqData[$snapShotKey][$key][$subKey] = $subValue;
                } else
                    $wavierSnapShotReqData[$snapShotKey . '_' . $key] = $value;
            }
        }

        if ($customer->wavierSnapshots->isNotEmpty())
            $customer->wavierSnapshots()->update(['status' => false]);

        $wavierSnapshot = QueryBuilder::for(WavierSnapshot::class)->create(['snapshot' => $wavierSnapShotReqData, 'customer_id' => $customer->id, 'status' => true]);

        if ($customer->wavierSignatureSnapshots->isNotEmpty())
            $customer->wavierSignatureSnapshots()->update(['status' => false]); //store signature in local storage or create wavier signature snapshot
        foreach ($customer->familyMembers as $familyMember) {
            if (isset($familyMember->signature) && !empty($familyMember->signature))
                QueryBuilder::for(WavierSignatureSnapshot::class)->create(['signature_snapshot' => $familyMember->signature, 'status' => true, 'customer_id' => $customer->id, 'family_member_id' => $familyMember->id, 'wavier_snapshot_id' => $wavierSnapshot->id]);
        }
    }

    public function custWavierSnapshot(Request $request)
    {
        $q = $request->get('q');

        $query = QueryBuilder::for(Customer::class)
            ->with('wavierSnapshots');

        if ($request->has('id') && $request->get('id'))
            $query->where('id', $request->get('id'));
        else {
            $query->where(function ($query) use ($q) {
                $query->where('id', 'like', "%$q%")
                    ->orWhere('first_name', 'like', "%$q%")
                    ->orWhere('last_name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%");
            })->latest();
        }

        $customer = $query->first();

        $custWavierSnapshots = $customer ? $customer->wavierSnapshots->take(10) : collect();

        $html = '';

        $html .= '<div class="overflow-y-auto" style="max-height: 36rem"><div class="inline-block min-w-full align-middle">';

        // table
        $html .= '<table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700">';

        // table header
        $html .= '<thead class="bg-slate-200 dark:bg-slate-700">
                <tr>
                    <th scope="col" class="table-th">
                        Title
                    </th>
                    <th scope="col" class="table-th ">
                        Status
                    </th>
                    <th scope="col" class="table-th">
                        Date
                    </th>
                    <th scope="col" class="table-th w-20">
                        Action
                    </th>
                </tr>
            </thead>';

        // table body
        $html .= '<tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700" id="custWavierModal">';

        if ($custWavierSnapshots->count() > 0) {
            foreach ($custWavierSnapshots as $wavierSnapshot) {
                $html .= '<tr>
                    <td class="table-td">
                        ' . $wavierSnapshot->title . '
                    </td>
                    <td class="table-td">
                        ' . ($wavierSnapshot->status ? 'Active' : 'Expire') . '
                    </td>
                    <td class="table-td">
                        ' . ($wavierSnapshot->created_at ? $wavierSnapshot->created_at->diffForHumans() : '') . '
                    </td>
                    <td class="table-td">
                        <div class="flex space-x-3 rtl:space-x-reverse">
                            <button class="btn inline-flex justify-center btn-dark w-full" onclick="window.open(\'' . route('cust-wavier.snapshot.pdf', ['wavierSnapshot' => $wavierSnapshot]) . '\')">
                                Pdf
                            </button>
                        </div>
                    </td>
                </tr>';
            }
        } else {
            $html .= '<tr class="border border-slate-100 dark:border-slate-900 relative">
                <td class="table-cell text-center" colspan="5">
                    <img src="images/result-not-found.svg" alt="page not found"
                        class="w-64 m-auto" />
                    <h2 class="text-xl text-slate-700 mb-8 -mt-4">No results found.</h2>
                </td>
            </tr>';
        }

        $html .= ' </tbody>';

        $html .= '</table>';

        $html .= '</div></div>';

        return response()->json([
            'status' => true,
            'data' => $html
        ]);
    }

    public function generateCustWavierSnapshotPdf(WavierSnapshot $wavierSnapshot)
    {
        $wavierSnapshotSignature = QueryBuilder::for(WavierSignatureSnapshot::class)
            ->select('family_member_id', \DB::raw('(select type from family_members where id = family_member_id) as family_member_type'), 'signature_snapshot')
            ->where('wavier_snapshot_id', $wavierSnapshot->id)->get()->toArray();

        $wavierSnapshotSignature = is_array($wavierSnapshotSignature) && !empty($wavierSnapshotSignature) ? array_combine(Arr::pluck($wavierSnapshotSignature, 'family_member_id'), $wavierSnapshotSignature) : [];

        $pdf = Pdf::loadView('customers.wavierPdfTemplate', ['data' => $wavierSnapshot->toArray(), 'signature_data' => $wavierSnapshotSignature]);
        return $pdf->download('wavier-snapshot-' . ($wavierSnapshot->title ?? generateUniqueCode()) . '.pdf');
    }

    public function globalSearch(Request $request)
    {
        $q = $request->get('search');

        $searchResult = QueryBuilder::for(Customer::class)
            ->select([
                'customers.id as id',
                \DB::raw('CONCAT(customers.first_name, " ", customers.last_name) as value'),
                'customers.email as additional_value',
                \DB::raw("'Customer' as type"),
                \DB::raw('null as parent_first_name'),
                \DB::raw('null as parent_last_name'),
                \DB::raw('null as parent_email'),
            ])
            ->whereHas('familyMembers', function ($query) use ($q) {
                $query->where('family_members.first_name', 'like', "%$q%")
                    ->orWhere('family_members.last_name', 'like', "%$q%");
            })
            ->orWhere(function ($query) use ($q) {
                $query->where('customers.id', 'like', "%$q%")
                    ->orWhere('customers.first_name', 'like', "%$q%")
                    ->orWhere('customers.last_name', 'like', "%$q%")
                    ->orWhere('customers.email', 'like', "%$q%")
                    ->orWhere('customers.phone', 'like', "%$q%");
            })->orderBy('id')->take(5)->get();

        return response()->json($searchResult);
    }

    private function getCountryCode($locationId)
    {
        if ($locationId == 1) {
            return Country::where('iso', 'GB')->first()->phonecode;
        } else if ($locationId == 2) {
            return Country::where('iso', 'CA')->first()->phonecode;
        }
    }

    public function userEmailExists(Request $request)
    {
        if (Customer::emailExists($request->input('email'))) {
            return response()->json('exists');

        }

        return response()->json('not exists');

    }

}
