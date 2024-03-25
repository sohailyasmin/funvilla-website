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

        <form action="{{ route('categories.update', $category ) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6">
                <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">

                    {{-- Name  --}}
                    <div class="input-area">
                        <label for="name" class="form-label font-bold">{{ __('Name') }}</label>
                        <input name="name" type="text" id="name" class="form-control"
                            value="{{ $category->name }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    {{-- Description  --}}
                    <div class="input-area">
                        <label for="description" class="form-label font-bold">{{ __('Description') }}</label>
                        <textarea rows="4" name="description" id="description" class="form-control resize-none"
                            placeholder="{{ __('Enter Category Description') }}" value="{{ $category->description }}" required>
                        </textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    {{--Location input end--}}
                    <div class="input-area">
                        <label for="location_id" class="form-label">{{ __('Location') }}</label>
                        <select name="location_id" id="location_id" class="form-control" required>
                            <option value="" selected disabled>
                                Select Location
                            </option>
                            @foreach($locations as $location)
                            <option value="{{$location->id}}" @selected($category->location_id == $location->id)>
                                {{$location->name}}
                            </option>
                            @endforeach
                        </select>
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
