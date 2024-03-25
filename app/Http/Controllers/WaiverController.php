<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerFMRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\AccountType;
use App\Models\Country;
use App\Models\FamilyMember;
use App\Models\User;
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
use Illuminate\Support\Facades\Hash;

class WaiverController extends Controller
{


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




        $locations = Location::all();

        $account_types = AccountType::all();
        $termsAndCondition = TermsAndCondition::defaultTermsAndCondition()->get();

        $months = [];

        for ($m = 1; $m <= 12; $m++)
            array_push($months, ['id' => $m, 'name' => date('F', mktime(0, 0, 0, $m, 1, date('Y')))]);

        $years = [];

        for ($y = (int) Carbon::now()->format('Y') - 17; $y >= 1930; $y--)
            array_push($years, ['id' => $y, 'name' => $y]);

        // $userRole = auth()->user()->roles;

        return view('customers.signup-wavier', [
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
            'news_subscription',
            'waiver_via'
        ]);



        $user = User::create([
            'name' => 'Customer',
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $customerRequestData['country_code'] = $this->getCountryCode($request->location_id);
        $customerRequestData['user_id'] = $user->id;

        if ($customerRequestData['account_type_id'] == '1')
            unset($customerRequestData['organisation_name']);

        $mainCustomer = Customer::create($customerRequestData);

        //store wavier remarks
        $remarks = $request->input('customer_remarks', '');

        if (!empty($remarks)) {
            $customerRemarksRequestData = ['remarks' => $remarks, 'customer_id' => $mainCustomer->id];
            CustomerRemark::create($customerRemarksRequestData);
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

    private function getCountryCode($locationId)
    {
        if ($locationId == 1) {
            return Country::where('iso', 'GB')->first()->phonecode;
        } else if ($locationId == 2) {
            return Country::where('iso', 'CA')->first()->phonecode;
        }
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



    public function myWaivers(Request $request)
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

        $customers = Customer::all();



        return response()->view('customers.index', [

            'breadcrumbItems' => $breadcrumbsItems,
            'pageTitle' => 'Ticket',
            'customers' => $customers

        ]);


    }


}
