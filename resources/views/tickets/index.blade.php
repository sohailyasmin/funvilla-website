<x-app-layout>
    <div>
        <div class=" mb-6">
            {{-- Breadcrumb --}}
            <x-breadcrumb :pageTitle="$pageTitle" :breadcrumbItems="$breadcrumbItems" />
        </div>

        {{-- Alert start --}}
        @if (session('message'))
        <x-alert :message="session('message')" :type="'success'" />
        @endif
        {{-- Alert end --}}

        <div class="card">
            <header class=" card-header noborder">
                <div class="justify-end flex gap-3 items-center flex-wrap">
                    {{-- Create Button start--}}
                    {{-- @can('ticket create') --}}
                    <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3" href="{{ route('tickets.create') }}">
                        <iconify-icon icon="ic:round-plus" class="text-lg mr-1">
                        </iconify-icon>
                        {{ __('New') }}
                    </a>
                    {{-- @endcan --}}
                    {{--Refresh Button start--}}
                    <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2.5" href="{{ route('tickets.index') }}">
                        <iconify-icon icon="mdi:refresh" class="text-xl "></iconify-icon>
                    </a>
                </div>
                <div class="justify-center flex flex-wrap sm:flex items-center lg:justify-end gap-3">
                    @if (count($locations) > 0)
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
                    <div class="relative w-full sm:w-auto flex items-center">
                        <form id="searchForm" method="get" action="{{ route('tickets.index') }}">
                            <input name="q" type="text" class="inputField pl-8 p-2 border border-slate-200 dark:border-slate-700 rounded-md dark:bg-slate-900" placeholder="Search" value="{{ request()->q }}">
                        </form>
                        <iconify-icon class="absolute text-textColor left-2 dark:text-white" icon="quill:search-alt"></iconify-icon>
                    </div>
                </div>
            </header>
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
                                            {{ __('Name') }}
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('Status') }}
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('Start Date Time') }}
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('End Date Time') }}
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('Location') }}
                                        </th>
                                        <th scope="col" class="table-th ">
                                            {{ __('Created At') }}
                                        </th>
                                        <th scope="col" class="table-th w-20">
                                            {{ __('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($tickets as $ticket)
                                    <tr class="border border-slate-100 dark:border-slate-900 relative">
                                        <td class="table-td sticky left-0"># {{ $ticket->id }}</td>
                                        <td class="table-td">
                                            <span>{{ $ticket->name }}</span>
                                        </td>
                                        <td class="table-td">
                                            <span>{{ $ticket->status ? 'Active' : 'In-Active' }}</span>
                                        </td>
                                        <td class="table-td">
                                            <span>{{ \Carbon\Carbon::parse($ticket->start_date_time)->toDayDateTimeString() }}</span>
                                        </td>
                                        <td class="table-td">
                                            <span>{{ \Carbon\Carbon::parse($ticket->end_date_time)->toDayDateTimeString() }}</span>
                                        </td>
                                        <td class="table-td">
                                            <span>{{ $ticket->location->name }}</span>
                                        </td>
                                        <td class="table-td">{{ $ticket->created_at ? $ticket->created_at->diffForHumans() : '' }}</td>
                                        
                                        <td class="table-td">
                                            <div class="action-btns space-x-2 flex">
                                                {{-- show --}}
                                                {{-- @can('ticket show') --}}
                                                {{-- <a class="action-btn" href="{{ route('tickets.show', $ticket) }}" x-data="{ tooltip: 'View' }" x-tooltip="tooltip">
                                                    <iconify-icon icon="ph:eye-light"></iconify-icon>
                                                </a> --}}
                                                {{-- @endcan --}}
                                                
                                                {{-- Edit --}}
                                                {{-- @can('ticket update') --}}
                                                <a class="action-btn" href="{{ route('tickets.edit', ['ticket' => $ticket]) }}">
                                                    <iconify-icon icon="uil:edit"></iconify-icon>
                                                </a>
                                                {{-- @endcan --}}
                                                {{-- delete --}}
                                                {{-- @can('ticket delete') --}}
                                                <form id="deleteForm{{ $ticket->id }}" method="POST" action="{{ route('tickets.destroy', $ticket) }}" class="cursor-pointer">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="action-btn" onclick="sweetAlertDelete(event, 'deleteForm{{ $ticket->id }}')" type="submit">
                                                        <iconify-icon icon="fluent:delete-24-regular"></iconify-icon>
                                                    </a>
                                                </form>
                                                {{-- @endcan --}}
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="border border-slate-100 dark:border-slate-900 relative">
                                        <td class="table-cell text-center" colspan="10">
                                            <img src="images/result-not-found.svg" alt="page not found" class="w-64 m-auto" />
                                            <h2 class="text-xl text-slate-700 mb-8 -mt-4">{{ __('No results found.') }}</h2>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <x-table-footer :per-page-route-name="'tickets.index'" :data="$tickets"  :filter="null" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
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

        // Attach event listener to the location dropdown
        const locationDropdown = document.getElementById('locationDropdown');
        locationDropdown.addEventListener('change', handleLocationChange);
    </script>
    <script>
        function sweetAlertDelete(event, formId) {
            event.preventDefault();
            let form = document.getElementById(formId);
            Swal.fire({
                title: '@lang('Are you sure ? ')',
                icon : 'question',
                showDenyButton: true,
                confirmButtonText: '@lang('Delete ')',
                // denyButtonText: '@lang(' Cancel ')',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
    </script>
    @endpush
</x-app-layout>