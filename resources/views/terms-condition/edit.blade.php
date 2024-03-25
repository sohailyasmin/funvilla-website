<x-app-layout>
    <div>
        {{-- Breadcrumb start --}}
        <div class="mb-6">
            {{-- BreadCrumb --}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{-- Breadcrumb end --}}

        {{-- Create Terms and condition form start --}}
        <div id='app'>
            <terms-and-condition-form :path="{{json_encode($tinyMcePath)}}" :tc-title="{{json_encode($termsAndCondition->title ?? '')}}" :tc-description="{{json_encode($termsAndCondition->description ?? '')}}" :tc-text="{{json_encode($termsAndCondition->text ?? '')}}" :tc-is-default="{{$termsAndCondition->is_default}}" :terms-and-condition-id="{{$termsAndCondition->id}}" :locations="{{json_encode($locations)}}"  :location-id="{{json_encode($termsAndCondition->location_id)}}"></terms-and-condition-form>
        </div>
    </div>

</x-app-layout>
