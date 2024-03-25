<x-app-layout>
    <div>
        {{-- Breadcrumb start --}}
        <div class="mb-6">
            {{-- BreadCrumb --}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{-- Breadcrumb end --}}

        {{-- Create customers form start --}}
        <div class="px-4 md:px-6 lg:px-8">
            <div id='app'>
                <customer-form :months="{{json_encode($months)}}" :years="{{json_encode($years)}}" :main-customer="{{json_encode($customer)}}" :locations="{{json_encode($locations)}}" :account-types="{{json_encode($account_types)}}" :is-edit="true"></customer-form>
            </div>
        </div>


    </div>

</x-app-layout>
