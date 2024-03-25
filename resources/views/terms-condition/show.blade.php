<x-app-layout>
    <div>
        {{-- Breadcrumb start --}}
        <div class="mb-6">
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{-- Breadcrumb end --}}

        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6 m-auto max-w-[calc(100%-2rem)] xl:w-full lg:max-w-[calc(100%-4rem)] lg:px-10 xl:px-12">

            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4">

                {{-- Default input --}}
                <div class="input-group">
                    <label for="is_default"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Default') }}
                    </label>
                    <input name="is_default" type="text" id="is_default"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your Default') }}" value="{{ $termsAndCondition->is_default ? 'Yes' : 'Now' }}" disabled>
                </div>

                {{-- Location input --}}
                <div class="input-group">
                    <label for="location_id"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Location') }}
                    </label>
                    <select name="location_id" id="location_id"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        disabled>
                        <option value="{{ $termsAndCondition->location_id }}">{{ $termsAndCondition->location->name }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
