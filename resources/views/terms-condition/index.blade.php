<x-app-layout>
    <div>
        <div class=" mb-6">
            {{-- Breadcrumb start --}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />

        </div>

        {{-- Alert start --}}
        @if (session('message'))
            <x-alert :message="session('message')" :type="'success'" />
        @endif
        {{-- Alert end --}}


        <div class="card">
            <div class="flex justify-between p-3">
                <div>
                    @can('user create')
                        <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3"
                           href="{{ route('terms-condition.create') }}">
                            <iconify-icon icon="ic:round-plus" class="text-lg mr-1"></iconify-icon>
                            {{ __('New') }}
                        </a>
                    @endcan

                    <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2.5"
                       href="{{ route('terms-condition.index') }}">
                        <iconify-icon icon="mdi:refresh" class="text-xl"></iconify-icon>
                    </a>
                </div>
                <div class="flex">
                    @if (count($locations) > 0)
                        <label for="location" class="form-label mr-2 mt-2">{{ __('Location') }}</label>
                    <div class="relative mr-2">
                        {{-- Filter Dropdown --}}
                        <select id="locationDropdown"
                                class="inputField pl-5 p-2 border border-slate-200 dark:border-slate-700 rounded-md dark:bg-slate-900">
                            <option value="all">All</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                            {{ request()->query('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                        </select>

                        <iconify-icon class="absolute text-textColor left-2 dark:text-white"
                                      icon="heroicons:selector"></iconify-icon>
                    </div>
                    @endif
                    <div class="relative w-full sm:w-auto">
                        <form id="searchForm" method="get" action="{{ route('terms-condition.index') }}">
                            <div class="relative">
                                <input name="q" type="text"
                                       class="inputField pl-8 p-2 border border-slate-200 dark:border-slate-700 rounded-md dark:bg-slate-900 pr-8"
                                       placeholder="Search" value="{{ request()->q }}">
                                <iconify-icon
                                        class="absolute text-textColor left-2 dark:text-white top-1/2 transform -translate-y-1/2"
                                        icon="quill:search-alt"></iconify-icon>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                <thead class="bg-slate-200 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class="table-th ">
                                            {{ __('Sl No') }}
                                        </th>

                                         <th scope="col" class="table-th ">
                                            {{ __('Title') }}
                                        </th>

                                        <th scope="col" class="table-th ">
                                            {{ __('Description') }}
                                        </th>

                                        <th scope="col" class="table-th ">
                                            {{ __('Default') }}
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('Location') }}
                                        </th>
                                        <th scope="col" class="table-th flex items-center">
                                            <div>{{ __('Date')}}</div>
                                            <div class="m-1">
                                                <a href="javascript:;" id="sortingDropdown" 
                                                    data-column="{{(isset(request()->sort) && !empty(request()->sort) && !str_starts_with(request()->sort, '-')) ? '-created_at' : 'created_at'}}">
                                                    <iconify-icon icon="ri:arrow-up-down-line"></iconify-icon>
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($termsAndConditions as $termsCondition)
                                        <tr>
                                            <td class="table-td">
                                                # {{ $termsCondition->id }}
                                            </td>
                                             <td class="table-td">
                                                {{ $termsCondition->title }}
                                            </td>

                                            <td class="table-td" style="width: 100px; text-overflow: ellipsis; overflow: hidden; display: block">
                                                {{ $termsCondition->description }}
                                            </td>

                                            <td class="table-td">
                                                {{ $termsCondition->is_default == '1' ? 'Yes' : 'No' }}
                                            </td>
                                            <td class="table-td">
                                                {{ $termsCondition->location->name }}
                                            </td>
                                            <td class="table-td">
                                                {{ $termsCondition->created_at->format('d-m-Y h:i A') }}
                                            </td>

                                            <td class="table-td">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    {{-- view --}}
                                                    {{-- @can('user show')
                                                        <a class="action-btn"
                                                            href="{{ route('terms-condition.show', $termsCondition) }}">
                                                            <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                        </a>
                                                    @endcan --}}
                                                    {{-- Edit --}}
                                                    @can('user update')
                                                        <a class="action-btn"
                                                            href="{{ route('terms-condition.edit', ['terms_condition' => $termsCondition]) }}">
                                                            <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                        </a>
                                                    @endcan
                                                    {{-- delete --}}
                                                    @can('user delete')
                                                        <form id="deleteForm{{ $termsCondition->id }}" method="POST"
                                                            action="{{ route('terms-condition.destroy', $termsCondition) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="action-btn cursor-pointer"
                                                                onclick="sweetAlertDelete(event, 'deleteForm{{ $termsCondition->id }}')"
                                                                type="submit">
                                                                <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                            </a>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="border border-slate-100 dark:border-slate-900 relative">
                                            <td class="table-cell text-center" colspan="5">
                                                <img src="images/result-not-found.svg" alt="page not found"
                                                    class="w-64 m-auto" />
                                                <h2 class="text-xl text-slate-700 mb-8 -mt-4">
                                                    {{ __('No results found.') }}</h2>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <x-table-footer :per-page-route-name="'terms-condition.index'" :data="$termsAndConditions" :filter="null" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        {{-- for filter user on location based --}}
        <script>
            // Function to update URL query parameters
            function updateUrlParameter(key, value) {
                const url = new URL(window.location);
                url.searchParams.set(key, value);
                window.location.href = url;
            }

            // Function to handle location dropdown change
            function handleLocationChange(event) {
                const selectedLocationId = event.target.value;
                updateUrlParameter('location_id', selectedLocationId);
            }

            function handleSorting(event) {
                const sortTarget = event.target.parentNode
                if(sortTarget){
                    const column = sortTarget.getAttribute('data-column')
                    updateUrlParameter('sort', column);
                }
            }

            // Attach event listener to the location dropdown
            const locationDropdown = document.getElementById('locationDropdown');
            locationDropdown.addEventListener('change', handleLocationChange);

            const sortingDropdown = document.getElementById('sortingDropdown');
            sortingDropdown.addEventListener('click', handleSorting);
        </script>

        {{--  delete confirmation message --}}
        <script>
            function sweetAlertDelete(event, formId) {
                event.preventDefault();
                let form = document.getElementById(formId);
                Swal.fire({
                    title: '@lang('Are you sure ? ')',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonText: '@lang('Delete ')',
                    denyButtonText: '@lang('Cancel ')',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            }
        </script>
    @endpush
</x-app-layout>
