<x-app-layout>
    <header class="page-header">
        <div class="container">
            <div class="inner text-center">
                <h6>Camper Health Form</h6>
                <p>Health Concerns - diet/allergies/chronic conditions/considerations we should be aware of as we
                    prepare for your camper </p>

            </div>
            <!-- end inner -->
        </div>
        <!-- end container -->
    </header>
    <!-- end page-header -->

    @php
    $submit_via = request()->input('submit_via') ? request()->input('submit_via') : 'online';
    @endphp
    <div class="container">
        <booking-camp :months="{{json_encode($months)}}" :submit-via={{json_encode($submit_via)}}
            :years="{{json_encode($years)}}" :locations="{{json_encode($locations)}}"
            :account-types="{{json_encode($account_types)}}"
            :default-terms-and-conditions="{{json_encode($terms_and_condition)}}" :is-edit="false">
        </booking-camp>
    </div>
</x-app-layout>