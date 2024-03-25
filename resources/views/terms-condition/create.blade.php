<x-app-layout>
   
    <div class="mb-4 md:mb-6">
        {{-- BreadCrumb --}}
        <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
    </div>
    <div class="px-4 md:px-6 lg:px-8">
        {{-- Create Terms And Condition form start --}}

    <div id='app'>
        <terms-and-condition-form :path="{{json_encode($tinyMcePath)}}" :tc-title="{{json_encode('')}}" :tc-description="{{json_encode('')}}" :tc-text="{{json_encode('')}}" :tc-is-default="false" :locations="{{json_encode($locations)}}" :location-id="{{json_encode('')}}"></terms-and-condition-form>
    </div>
    </div>

</x-app-layout>
