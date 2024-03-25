<x-app-layout>
   
    <div class="mb-4 md:mb-6">
        {{-- BreadCrumb --}}
        <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
    </div>
    <div class="px-4 md:px-6 lg:px-8">
        {{-- Create customers form start --}}

    <div id='app'>
        <customer-form :months="{{json_encode($months)}}" :years="{{json_encode($years)}}" :locations="{{json_encode($locations)}}" :account-types="{{json_encode($account_types)}}" :default-terms-and-conditions="{{json_encode($terms_and_condition)}}" :is-edit="false"></customer-form>
    </div>
    </div>

</x-app-layout>
