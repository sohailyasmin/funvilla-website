<x-app-layout>
    <div>
        {{--Breadcrumb start--}}
        <div class="mb-6">
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{--Breadcrumb end--}}

        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6   m-auto max-w-none mx-auto xl:w-full lg:max-w-none ">

            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4  lg:px-10 xl:px-12">
                <div class="input-group">
                    {{--Name input start--}}
                    <label for="name" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Name') }}
                    </label>
                    <input name="name" type="text" id="name" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                            value="{{ $user->name }}" disabled>
                </div>
                {{--Name input end--}}
                {{--Email input start--}}
                <div class="input-group">
                    <label for="email" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Email') }}
                    </label>
                    <input name="email" type="email" id="email" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                           value="{{ $user->email }}" required disabled>
                </div>
                {{--Email input end--}}

                {{--Address input end--}}
                <div class="input-group">
                    <label for="address" class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Address') }}
                    </label>
                    <textarea name="address" id="address" class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed" required disabled>{{ $user->address }}</textarea>
                </div>
                {{--Email input end--}}
            </div>
        </div>

    </div>
</x-app-layout>
