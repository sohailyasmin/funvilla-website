<x-app-layout>
    <div>
        {{-- Breadcrumb start --}}
        <div class="mb-6">
            {{-- BreadCrumb --}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{-- Breadcrumb end --}}

        <div class="max-w-screen-sm mx-auto xl:w-full lg:max-w-none px-2 lg:px-12 xl:px-14">

        {{-- Create user form start --}}

        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6 ">
            <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">

                {{-- Name  --}}
                <div class="input-area">
                    <label for="name" class="form-label font-bold">{{ __('Name') }}</label>
                    <input name="name" type="text" id="name" class="form-control"
                           value="{{ $ticket->name }}" disabled>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- slug --}}
                <div class="input-area">
                    <label for="location" class="form-label font-bold">{{ __('Location') }}</label>
                    <input name="location" type="text" id="location" class="form-control"
                           value="{{ $ticket->location->name }}" disabled>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- created at --}}
                <div class="input-area">
                    <label for="created_at" class="form-label font-bold">{{ __('Created At') }}</label>
                    <input name="created_at" type="text" id="created_at" class="form-control"
                           value="{{ $ticket->created_at->format('Y-m-d h:i:s A') }}" disabled>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
