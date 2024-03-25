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

                <div class="input-area">
                    <label for="id" class="form-label font-bold">{{ __('ID') }}</label>
                    <input name="id" type="text" id="id" class="form-control"
                           value="{{ $location->id }}" disabled>
                    <x-input-error :messages="$errors->get('id')" class="mt-2" />
                </div>

                {{-- Name  --}}
                <div class="input-area">
                    <label for="name" class="form-label font-bold">{{ __('Name') }}</label>
                    <input name="name" type="text" id="name" class="form-control"
                           value="{{ $location->name }}" disabled>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- slug --}}
                <div class="input-area">
                    <label for="slug" class="form-label font-bold">{{ __('Slug') }}</label>
                    <input name="slug" type="text" id="slug" class="form-control"
                           value="{{ $location->slug }}" disabled>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- created at --}}
                <div class="input-area">
                    <label for="created_at" class="form-label font-bold">{{ __('Created At') }}</label>
                    <input name="created_at" type="text" id="created_at" class="form-control"
                           value="{{ $location->created_at->format('Y-m-d h:i:s A') }}" disabled>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
