<x-app-layout>
    <div>
        {{--Breadcrumb start--}}
        <div class="mb-6">
            {{--BreadCrumb--}}
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{--Breadcrumb end--}}

        {{--Create user form start--}}
        <form method="POST" action="{{ route('users.store') }}" class="max-w-none mx-auto xl:w-full lg:max-w-none px-2 lg:px-10 xl:px-12">

            @csrf
            <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6">

                <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">


                    {{--Name input end--}}
                    <div class="input-area">
                        <label class="form-label" for="name">
                            <span>{{ __('Name') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="name" type="text" id="name" class="form-control"
                               placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    {{--Email input start--}}
                    <div class="input-area">
                        <label class="form-label" for="email">
                            <span>{{ __('Email') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="email" type="email" id="email" class="form-control"
                               placeholder="{{ __('Enter email') }}" value="{{ old('email') }}" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    {{--City input start--}}
                    <div class="input-area">
                        <label class="form-label" for="city">
                            <span>{{ __('City') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="city" type="text" id="city" class="form-control"
                               placeholder="{{ __('Enter city') }}" value="{{ old('city') }}" required>
                        <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                    </div>

                    {{--Phone input start--}}
                    <div class="input-area">
                        <label class="form-label" for="phone">
                            <span>{{ __('Phone') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="phone" type="text" id="phone" class="form-control"
                               placeholder="{{ __('Enter phone') }}" value="{{ old('phone') }}" maxlength="15" minlength="11" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>

                    {{--address input start--}}
                    <div class="input-area">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea name="address" type="text" id="address" class="form-control" placeholder="{{__('Enter Address')}}" value="{{ old('address') }}" rows="4" cols="50"></textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                    </div>

                    {{--Email input start--}}
                    <div class="input-area">
                        <label class="form-label" for="password">
                            <span>{{ __('Password') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="password" type="password" id="password" class="form-control" placeholder="{{ __('Enter Password') }}" >
                        <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                    </div>

                    {{--Password input end--}}
                    {{--Role input start--}}
                    <div class="input-area">
                        <label class="form-label" for="role">
                            <span>{{ __('Role') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <select name="role" class="form-control">
                            <option value="" selected disabled>
                                {{ __('Select Role') }}
                            </option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                      icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                    </div>
                    {{--Role input end--}}

{{-- Location input start (for admin creating employee) --}}
                    @if (auth()->user()->hasRole('admin'))
                        <div class="input-area">
                            <label for="location_id" class="form-label">{{ __('Location') }}</label>

                            <select name="location_id" class="form-control" disabled>
                                <option value="{{ auth()->user()->location_id }}" >
                                    {{ auth()->user()->location->name }}
                                </option>
                            </select>
                            <input type="hidden" name="location_id" value="{{ auth()->user()->location_id }}">
                            <x-input-error :messages="$errors->get('location_id')" class="mt-2"/>
                        </div>
                        {{-- Location input end (for admin creating employee) --}}
                    @elseif (auth()->user()->hasRole('super-admin'))
                        {{-- Location input start for superadmin creating employee or admin) --}}

                        <div class="input-area">
                            <label for="location_id"  class="form-label">{{ __('Location') }}</label>
                            <select name="location_id" class="form-control" >
                                <option value="" selected disabled>
                                    {{ __('Select Location') }}
                                </option>
                                @if(count($locations) > 0)
                                    <option value=" ">{{ __('None') }}</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}">{{ __($location->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <x-input-error :messages="$errors->get('location_id')" class="mt-2"/>
                            <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                          icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                        </div>
                    @endif
                    {{-- Location input end for superadmin creating employee or admin) --}}
                    @if(count($locations) > 0 && auth()->user()->hasRole('super-admin'))
                        <div class="input-area">
                            <label for="access_locations"  class="form-label">{{ __('Access Location') }}</label>
                            @foreach($locations as $location)
                                <input id="{{$location->id}}" name="access_locations[]" type="checkbox" value="{{$location->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="{{$location->id}}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{__($location->name)}}</label>
                                <br/>
                            @endforeach
                            <x-input-error :messages="$errors->get('access_locations')" class="mt-2"/>
                            <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                          icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                        </div>
                    @endif

                    <div class="input-area">
                        <label class="form-label" for="">
                            <span>{{ __('Status') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <div>              
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-input-01" value="1" checked>
                                <label class="form-check-label" for="status-input-01">
                                    Activate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-input-02" value="0">
                                <label class="form-check-label" for="status-input-02">
                                    Deactivate
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>

                </div>
                <button type="submit" class="btn inline-flex justify-center btn-dark mt-4 w-full">
                    {{ __('Save') }}
                </button>
            </div>

        </form>
        {{--Create user form end--}}
    </div>
</x-app-layout>
