<x-app-layout>
    <div class="space-y-8">
        <div>
            <x-breadcrumb :page-title="$pageTitle" :breadcrumb-items="$breadcrumbItems" />
        </div>



        {{--Alert--}}
        @if (session('message') && session('type'))
            <x-alert :message="session('message')" :type="session('type')"/>
        @endif


        <div class="space-y-8">
            <div class="overflow-hidden rounded-md">
                <form class="bg-white dark:bg-slate-800 px-7 py-7 "
                action="{{ route('general-settings.logo') }}"
                method="POST"
                enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-7 sm:grid-cols-2 lg:grid-cols-3 ">
                        <div class="imageUploadCard">
                            <div class="imageUploadCardHeader">
                                <h3 class="">{{ __('Logo') }}</h3>
                            </div>
                            <div class="cardBody">
                                <img id="logoPreview"
                                    class="mx-auto h-36 w-36 rounded-md"
                                    src="{{ $logoDetails['logoSrc'] }}"
                                    alt="logo">
                                <div class="relative">
                                    <input type="file"
                                        name="logo"
                                        class="defaultButton absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="imagePreview(event, 'logoPreview')"/>
                                    <label class="btn btn-dark !static defaultButton inline-block">
                                        {{ __('Choose') }}
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('logo')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="imageUploadCard">
                            <div class="imageUploadCardHeader">
                                <h3>{{ __('Favicon') }}</h3>
                            </div>
                            <div class="cardBody">
                                <div class="h-36 w-36 mx-auto rounded-md flex items-center justify-center">
                                    <img id="faviconPreview"
                                        src="{{ $logoDetails['faviconSrc'] }}"
                                        alt="dark_logo">
                                </div>
                                <div class="relative">
                                    <input type="file"
                                        name="favicon"
                                        class="defaultButton absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="imagePreview(event, 'faviconPreview')"/>
                                    <label class="btn btn-dark !static defaultButton inline-block">
                                        {{ __('Choose') }}
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('favicon')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="imageUploadCard">
                            <div class="imageUploadCardHeader">
                                <h3>{{ __('Dark Logo') }}</h3>
                            </div>
                            <div class="cardBody">
                                <img id="darkLogoPreview"
                                    class="mx-auto h-36 w-36 rounded-md"
                                    src="{{ $logoDetails['darkLogoSrc'] }}"
                                    alt="dark_logo">
                                <div class="relative">
                                    <input type="file"
                                        name="dark_logo"
                                        class="defaultButton absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="imagePreview(event, 'darkLogoPreview')"/>
                                    <label class="btn btn-dark !static defaultButton inline-block">
                                        {{ __('Choose') }}
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('dark_logo')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="imageUploadCard">
                            <div class="imageUploadCardHeader">
                                <h3>{{ __('Guest Logo') }}</h3>
                            </div>
                            <div class="cardBody">
                                <img id="guestLogoPreview"
                                    class="mx-auto h-36 w-36 rounded-md"
                                    src="{{ $logoDetails['guestLogoSrc'] }}"
                                    alt="guest_logo">
                                <div class="relative">
                                    <input type="file"
                                        name="guest_logo"
                                        class="defaultButton absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="imagePreview(event, 'guestLogoPreview')"/>
                                    <label class="btn btn-dark !static defaultButton inline-block">
                                        {{ __('Choose') }}
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('guest_logo')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="imageUploadCard">
                            <div class="imageUploadCardHeader">
                                <h3>{{ __('Guest Background') }}</h3>
                            </div>
                            <div class="cardBody">
                                <img id="guestBackgroundPreview"
                                    class="mx-auto h-36 w-36 rounded-md"
                                    src="{{ $logoDetails['guestBackgroundSrc'] }}"
                                    alt="guest_background">
                                <div class="relative">
                                    <input type="file"
                                        name="guest_background"
                                        class="defaultButton absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
                                        onchange="imagePreview(event, 'guestBackgroundPreview')"/>
                                    <label class="btn btn-dark !static defaultButton inline-block">
                                        {{ __('Choose') }}
                                    </label>
                                </div>
                                <x-input-error :messages="$errors->get('guest_background')" class="mt-2"/>
                            </div>
                        </div>
                    </div>
                    <button class="defaultButton btn btn-dark submitButton ml-auto mt-8" type="submit">
                        {{ __('Save Changes') }}
                    </button>
                </form>
            </div>
            <!-- General Settings Card -->

        </div>
    </div>
    @push('scripts')
        <script>

            // IMAGE PREVIEW
            let imagePreview = function (event, id) {
                let output = document.getElementById(id);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function () {
                    URL.revokeObjectURL(output.src) // free memory
                }
            };

            // COLLPASED CARD
            function collapsedCard(key){
                $('#settingBox'+key).toggleClass('hideContent');
                $('.generalSettingsCardIcon'+key).toggleClass('rotate-icon');
            }

        </script>
    @endpush
</x-app-layout>
