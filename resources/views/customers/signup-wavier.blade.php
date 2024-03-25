<x-app-layout>
    <header class="page-header">
        <div class="container">
            <div class="inner text-center">
                <h6>Sign online and beat the queue at check-in! </h6>
                <p>Adults and children of all ages are required to sign a waiver form before entering the facility. You
                    can
                    sign a waiver in advance online to avoid time in our line-ups or can sign it in person on the day
                    you
                    visit! </p>

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
        <customer-form :months="{{json_encode($months)}}" :submit-via={{json_encode($submit_via)}}
            :years="{{json_encode($years)}}" :locations="{{json_encode($locations)}}"
            :account-types="{{json_encode($account_types)}}"
            :default-terms-and-conditions="{{json_encode($terms_and_condition)}}" :is-edit="false">
        </customer-form>
    </div>
</x-app-layout>