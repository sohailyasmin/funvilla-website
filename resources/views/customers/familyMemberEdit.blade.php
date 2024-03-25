<x-app-layout>
    <div>
        {{-- Breadcrumb start --}}
        <div class="mb-6">
            {{-- BreadCrumb --}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{-- Breadcrumb end --}}

        {{-- Create customers form start --}}
        <div id='app'>
            <div class="card md:col-span-2">
                <div class="card-body flex flex-col p-4 md:p-6 lg:p-8">
                    <header class="flex mb-2 items-center border-b border-slate-100 dark:border-slate-700 pb-2 -mx-4 px-4">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Signing Person</div>
                            <span class="text-xs text-gray-500">You can only add new family member, can change existing one's</span>
                        </div>
                    </header>
                    <div class="card-text">
                        <family-member-form :months="{{json_encode($months)}}" :years="{{json_encode($years)}}" :customer-family-members="{{json_encode($familyMembers)}}" :total-member="{{json_encode($familMemberCount)}}" :errors="{{json_encode([])}}" :is-edit="true" :customer="{{$customer}}" :terms-and-condition="{{json_encode($terms_and_condition->text ?? 'I agree with <a href="javascript:;">terms and condition.</a>')}}" :cust-wavier-remarks="{{json_encode($cust_wavier_remarks ?? [])}}"></family-member-form>
                    </div>
                </div>    
            </div>
        </div>
    </div>

</x-app-layout>