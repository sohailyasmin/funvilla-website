<x-app-layout>
    <div>
        {{-- Breadcrumb start --}}
        <div class="mb-6">
            <x-breadcrumb :breadcrumb-items="$breadcrumbItems" :page-title="$pageTitle" />
        </div>
        {{-- Breadcrumb end --}}

        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6 m-auto max-w-[calc(100%-2rem)] xl:w-full lg:max-w-[calc(100%-4rem)] lg:px-10 xl:px-12">

            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4">
                {{-- First Name input --}}
                <div class="input-group">
                    <label for="first_name"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('First Name') }}
                    </label>
                    <input name="first_name" type="text" id="first_name"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your first name') }}" value="{{ $customer->first_name }}" disabled>
                </div>

                {{-- Last Name input --}}
                <div class="input-group">
                    <label for="last_name"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Last Name') }}
                    </label>
                    <input name="last_name" type="text" id="last_name"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your last name') }}" value="{{ $customer->last_name }}" disabled>
                </div>

                {{-- Date of Birth input --}}
                <div class="input-group">
                    <label for="dob"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Date of Birth') }}
                    </label>
                    <input name="dob" type="date" id="dob"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        value="{{ $customer->dob }}" disabled>
                </div>

                {{-- Phone input --}}
                <div class="input-group">
                    <label for="phone"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Phone') }}
                    </label>
                    <input name="phone" type="text" id="phone"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your phone number') }}" value="{{ $customer->phone }}" required
                        disabled>
                </div>

                {{-- Email input --}}
                <div class="input-group">
                    <label for="email"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Email') }}
                    </label>
                    <input name="email" type="email" id="email"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your email') }}" value="{{ $customer->email }}" required disabled>
                </div>

                {{-- City input --}}
                <div class="input-group">
                    <label for="city"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('City') }}
                    </label>
                    <input name="city" type="text" id="city"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your city') }}" value="{{ $customer->city }}" disabled>
                </div>

                {{-- State input --}}
                <div class="input-group">
                    <label for="state"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('State') }}
                    </label>
                    <input name="state" type="text" id="state"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your state') }}" value="{{ $customer->state }}" disabled>
                </div>

                {{-- Postal Code input --}}
                <div class="input-group">
                    <label for="postal_code"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Postal Code') }}
                    </label>
                    <input name="postal_code" type="text" id="postal_code"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your postal code') }}" value="{{ $customer->postal_code }}"
                        disabled>
                </div>

                {{-- Address input --}}
                <div class="input-group">
                    <label for="address"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('Address') }}
                    </label>
                    <textarea name="address" id="address"
                        class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                        placeholder="{{ __('Enter your address') }}" rows="4" disabled>{{ $customer->address }}</textarea>
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
                        <option value="{{ $customer->location_id }}">{{ $customer->location->name }}</option>
                    </select>
                </div>

                {{-- News subscription input --}}
                <div class="input-group">
                    <input type="checkbox" name="news_subscription" checked="{{$customer->news_subscription === true? 'checked' : ''}}" disabled>
                    <label for="news_subscription"
                        class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                        {{ __('I want to receive emails and newsletter') }}
                    </label>

                </div>

            </div>
        </div>

        {{-- show family members If customer have family members --}}
        <div class="bg-white dark:bg-slate-800 rounded-md p-5 pb-6 m-auto max-w-[calc(100%-2rem)] xl:w-full lg:max-w-[calc(100%-4rem)] lg:px-10 xl:px-12">

            <h6 class="text-left mb-3 mt-2">Family Members</h6>

            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-4">
                @if (count($family_members) > 0)
                    @foreach ($family_members as $index => $family_member)
                        <div class="mb-4">
                            {{-- First Name input --}}
                            <div class="input-group">
                                <label for="first_name_{{ $index }}"
                                    class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                                    {{ __('First Name') }}
                                </label>
                                <input name="family_first_name_{{ $index }}" type="text"
                                    id="first_name_{{ $index }}"
                                    class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                                    placeholder="{{ __('Enter first name') }}"
                                    value="{{ $family_member->first_name }}" disabled>
                            </div>

                            {{-- Last Name input --}}
                            <div class="input-group">
                                <label for="last_name_{{ $index }}"
                                    class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                                    {{ __('Last Name') }}
                                </label>
                                <input name="family_last_name_{{ $index }}" type="text"
                                    id="last_name_{{ $index }}"
                                    class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                                    placeholder="{{ __('Enter last name') }}"
                                    value="{{ $family_member->last_name }}" disabled>
                            </div>

                            {{-- Date of Birth input --}}
                            <div class="input-group">
                                <label for="dob_{{ $index }}"
                                    class="font-Inter font-medium text-sm text-textColor dark:text-white pb-2 inline-block">
                                    {{ __('Date of Birth') }}
                                </label>
                                <input name="family_dob_{{ $index }}" type="date"
                                    id="dob_{{ $index }}"
                                    class="p-3 py-2 rounded bg-slate-200 dark:bg-slate-900 dark:text-slate-300 w-full cursor-not-allowed"
                                    value="{{ $family_member->dob }}" disabled>
                            </div>
                        </div>
                    @endforeach
                    @else 
                    <div class="">
                        <p class="text-left font-bold">No Family Members</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
