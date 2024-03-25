<x-app-layout>
    <div>
        {{--Breadcrumb start--}}
        <div class="mb-6">
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{--Breadcrumb end--}}

        {{--Create user form start--}}
        <form method="POST" action="{{ route('users.update', $user) }}" class="max-w-none mx-auto xl:w-full lg:max-w-none px-2 lg:px-10 xl:px-12">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6">

                <div class="grid sm:grid-cols-1 gap-x-8 gap-y-4">

                    {{--Name input end--}}
                    <div class="input-area">
                        <label class="form-label" for="name">
                            <span>{{ __('Name') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="name" type="text" id="name" class="form-control"
                               placeholder="{{ __('Enter your name') }}" value="{{ $user->name }}" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    {{--Email input start--}}
                    <div class="input-area">
                        <label class="form-label" for="email">
                            <span>{{ __('Email') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="email" type="email" id="email" class="form-control"
                               placeholder="{{ __('Enter your email') }}" value="{{ $user->email }}" required @if(!empty($user->email)) readonly @endif>
                        <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                    </div>

                    @if(auth()->user()->hasRole('super-admin'))
                        <div class="input-area">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input name="password" type="password" id="password" class="form-control" placeholder="{{ __('Update Password') }}" >
                            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                        </div>
                    @endif

                    <div class="input-area">
                        <label class="form-label" for="city">
                            <span>{{ __('City') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="city" type="text" id="city" class="form-control"
                               placeholder="{{ __('Enter city') }}" value="{{ $user->city }}" required>
                        <x-input-error :messages="$errors->get('city')" class="mt-2"/>
                    </div>


                    <div class="input-area">
                        <label class="form-label" for="phone">
                            <span>{{ __('Phone') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <input name="phone" type="text" id="phone" class="form-control"
                               placeholder="{{ __('Enter phone') }}" value="{{ $user->phone }}" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>

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
                                <option value="{{ $role->id }}" @selected($user->hasRole($role->name))>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                      icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                    </div>
                    {{--Role input end--}}
                    <div class="input-area">
                        <label for="address" class="form-label">{{ __('Address') }}</label>
                        <textarea name="address" type="text" id="address" class="form-control"
                                  placeholder="{{ __('Enter Address') }}" rows="4"
                                  cols="50">{{ $user->address }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2"/>
                    </div>

                    {{--Role input start--}}
                    <div class="input-area">
                        <label for="role" class="form-label">{{ __('Role') }}</label>
                        <select name="role" class="form-control">
                            <option value="" selected disabled>
                                {{ __('Select Role') }}
                            </option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected($user->hasRole($role->name))>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                      icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                    </div>

                    @if(count($locations) > 0)
                            <div class="input-area">
                                <label for="location_id"  class="form-label">{{ __('Location') }}</label>
                                <select name="location_id" class="form-control" >
                                    <option value="" selected disabled>
                                        {{ __('Select Location') }}
                                    </option>
                                    @if(count($locations) > 0)
                                        <option value=" ">{{ __('None') }}</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{$user->location_id == $location->id? "selected" : ''}}>{{ __($location->name) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('location_id')" class="mt-2"/>
                                <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                              icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>
                            </div>

                        </div>
                    @endif

                    @if(count($locations) > 0)
                        @php $access_locations = explode(",", $user->access_locations) @endphp
                        <div class="input-area mt-4">
                            <label for="access_locations" class="form-label">{{ __('Access Location') }}</label>
                                @foreach($locations as $location)
                                    <input id="{{$location->id}}" name="access_locations[]" type="checkbox" @checked(in_array($location->id, $access_locations)) value="{{$location->id}}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="{{$location->id}}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{__($location->name)}}</label>
                                    <br/>
                                @endforeach
                            <x-input-error :messages="$errors->get('access_locations')" class="mt-2"/>
                            <iconify-icon class="absolute right-3 bottom-3 text-xl dark:text-white z-10"
                                          icon="material-symbols:keyboard-arrow-down-rounded"></iconify-icon>

                        </div>
                    @endif
                    {{--Role input end--}}
                    <div class="input-area">
                        <label class="form-label" for="">
                            <span>{{ __('Status') }}</span>
                            <span class="text-red-600"> * </span>
                        </label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-input-01"
                                       value="1" {{$user->status == '1' ? 'checked=checked' : ''}}>
                                <label class="form-check-label" for="status-input-01">
                                    Activate
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="status-input-02"
                                       value="0" {{$user->status == '0' ? 'checked=checked' : ''}}>
                                <label class="form-check-label" for="status-input-02">
                                    Deactivate
                                </label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
                    </div>
                </div>
                <button type="submit" class="btn inline-flex justify-center btn-dark mt-4 w-full">
                    {{ __('Save Changes') }}
                </button>
        </form>
        {{--Create user form end--}}

    {{--Create user form end--}}
    </div>
</x-app-layout>