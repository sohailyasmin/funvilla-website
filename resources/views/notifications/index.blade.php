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
{{--                    @can('user create')--}}
                    @if (auth()->user()->hasRole('super-admin'))
                        <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2 !px-3"
                           href="{{ route('notifications.create') }}">
                            <iconify-icon icon="ic:round-plus" class="text-lg mr-1"></iconify-icon>
                            {{ __('New') }}
                        </a>
{{--                    @endcan--}}
                    @endif

                    <a class="btn inline-flex justify-center btn-dark rounded-[25px] items-center !p-2.5"
                       href="{{ route('notifications.index') }}">
                        <iconify-icon icon="mdi:refresh" class="text-xl"></iconify-icon>
                    </a>
                </div>
            </div>
            <div class="card-body px-6 pb-6">
                <div class="overflow-x-auto -mx-6">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700">
                                <thead class="bg-slate-200 dark:bg-slate-700">
                                    <tr>
                                        <th scope="col" class="table-th ">{{ __('Sl No') }}</th>
                                        <th scope="col" class="table-th ">{{ __('User Name') }}</th>
                                        <th scope="col" class="table-th ">{{ __('Notification') }}</th>
                                        <th scope="col" class="table-th ">{{ __('Created at') }}</th>
                                    </tr>
                                </thead>

                                <tbody
                                    class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                    @forelse ($notifications as $notification)
                                        <tr>
                                            <td class="table-td"># {{$loop->index + 1}}</td>
                                            <td class="table-td">{{$notification->user_name}}</td>
                                            <td class="table-td">{{Str::limit(json_decode($notification->data)->message, 50)}}</td>
                                            <td class="table-td">{{$notification->created_at}}</td>
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
</x-app-layout>
