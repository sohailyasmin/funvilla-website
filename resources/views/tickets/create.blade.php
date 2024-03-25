<x-app-layout>
    <div>
        <div class="mb-4 md:mb-6">
            {{-- BreadCrumb --}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        <div class="px-4 md:px-6 lg:px-8">
            {{-- Create tickets form start --}}
    
            <div id='app'>
                <ticket-form :types="{{json_encode($types)}}" :guest-conditions="{{json_encode($guestConditions)}}" :locations="{{json_encode($locations)}}" :categories="{{json_encode($categories)}}" :terms-and-conditions="{{json_encode($termsAndConditions)}}" :is-edit="false"></ticket-form>
            </div>
        </div>
    </div>
</x-app-layout>
