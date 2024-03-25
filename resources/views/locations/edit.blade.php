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

        <form action="{{ route('locations.update', $location ) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6">
                <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">

                    {{-- Name  --}}
                    <div class="input-area">
                        <label for="name" class="form-label font-bold">{{ __('Name') }}</label>
                        <input name="name" type="text" id="name" class="form-control"
                            value="{{ $location->name }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                </div>
                <button type="submit" class="btn inline-flex justify-center btn-dark mt-4 w-full">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>
        </div>
    </div>

</x-app-layout>
