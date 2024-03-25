<x-app-layout>
    <div>

        {{-- Alert start --}}
        @if (session('message'))
        <x-alert :message="session('message')" :type="'success'" />
        @endif
        {{-- Alert end --}}


        <div class="card">


            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class=" table table-striped">
                                <thead class="bg-slate-200 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col">
                                            {{ __('Sl No') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('First Name') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Last Name') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Date of Birth') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Email') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Phone') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Address') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Postal Code') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('City') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('State') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Location') }}
                                        </th>

                                        <th scope="col">
                                            {{ __('Member Since') }}
                                        </th>

                                        <th scope="col" class="table-th w-20">
                                            {{ __('Action') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($customers as $customer)
                                    <tr>
                                        <td class="table-td">
                                            # {{ $customer->id }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->first_name }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->last_name }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->dob }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->email }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->phone }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->address }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->postal_code }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->city }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->state }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->state }}
                                        </td>
                                        <td class="table-td">
                                            {{ $customer->created_at->diffForHumans() }}
                                        </td>

                                        <td class="table-td">
                                            <div class="flex space-x-3 rtl:space-x-reverse">
                                                {{-- view --}}
                                                @can('user show')
                                                <a class="action-btn" href="{{ route('customers.show', $customer) }}">
                                                    <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                </a>
                                                @endcan
                                                {{-- Edit --}}
                                                @can('user update')
                                                <a class="action-btn"
                                                    href="{{ route('customers.edit', ['customer' => $customer]) }}">
                                                    <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                </a>
                                                <a class="action-btn"
                                                    href="{{ route('customers.family-member.edit', ['customer' => $customer]) }}">
                                                    <iconify-icon icon="tdesign:member"></iconify-icon>
                                                </a>
                                                @endcan
                                                {{-- delete --}}
                                                @can('user delete')
                                                <form id="deleteForm{{ $customer->id }}" method="POST"
                                                    action="{{ route('customers.destroy', $customer) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a class="action-btn cursor-pointer"
                                                        onclick="sweetAlertDelete(event, 'deleteForm{{ $customer->id }}')"
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

            // Attach event listener to the location dropdown
            const locationDropdown = document.getElementById('locationDropdown');
            locationDropdown.addEventListener('change', handleLocationChange);
    </script>

    {{-- delete confirmation message --}}
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