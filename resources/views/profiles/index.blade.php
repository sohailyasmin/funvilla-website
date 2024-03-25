<x-app-layout>
    <div class="space-y-5 profile-page">
        <div class="profiel-wrap px-[35px] pb-10 md:pt-[84px] pt-10 rounded-lg bg-white dark:bg-slate-800 lg:flex lg:space-y-0
                space-y-6 justify-between items-end relative z-[1]">
            <div
                class="bg-slate-900 dark:bg-slate-700 absolute left-0 top-0 md:h-1/2 h-[150px] w-full z-[-1] rounded-t-lg">
            </div>
            <div class="profile-box flex-none md:text-start text-center">
                <div class="md:flex items-end md:space-x-6 rtl:space-x-reverse">
                    <div class="flex-none">
                        <div class="md:h-[186px] md:w-[186px] h-[140px] w-[140px] md:ml-0 md:mr-0 ml-auto mr-auto md:mb-0 mb-4 rounded-full ring-4
                                ring-slate-100 relative">
                            <img src="{{ auth()->user()->getFirstMediaUrl('profile-image') ?:
                            Avatar::create(auth()->user()->name)->setDimension(400)->setFontSize(240)->toBase64() }}"
                                alt="" class="w-full h-full object-cover rounded-full">

                        </div>
                    </div>

                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf

                <a href="{{ route('logout') }}" class="btn btn-primary " onclick="event.preventDefault();
                                    this.closest('form').submit();" class="nav-link">
                    {{ __('Log Out') }}
                </a>
            </form>
            <br><br>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card h-full">
                    <header class="card-header">
                        <h4 class="card-title">Info</h4>
                    </header>
                    <div class="card-body p-6">
                        <ul class="list space-y-8">
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:envelope"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div
                                        class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        EMAIL
                                    </div>
                                    <a href="mailto:{{ auth()->user()->email ?: 'N/A' }}"
                                        class="text-base text-slate-600 dark:text-slate-50">
                                        {{ auth()->user()->email ?: 'N/A' }}
                                    </a>
                                </div>
                            </li>
                            <!-- end single list -->
                            <li class="flex space-x-3 rtl:space-x-reverse">
                                <div class="flex-none text-2xl text-slate-600 dark:text-slate-300">
                                    <iconify-icon icon="heroicons:phone-arrow-up-right"></iconify-icon>
                                </div>
                                <div class="flex-1">
                                    <div
                                        class="uppercase text-xs text-slate-500 dark:text-slate-300 mb-1 leading-[12px]">
                                        PHONE
                                    </div>
                                    <a href="{{ auth()->user()->phone }}"
                                        class="text-base text-slate-600 dark:text-slate-50">
                                        {{ auth()->user()->phone ?: 'N/A' }}
                                    </a>
                                </div>
                            </li>
                            <!-- end single list -->

                            <!-- end single list -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <header class="card-header">
                        <h4 class="card-title">Edit Profile
                        </h4>
                    </header>
                    <div class="card-body px-5 py-6">

                        {{-- Alert start --}}
                        @if (session('message'))
                        <x-alert :message="session('message')" :type="'success'" />
                        <br />
                        @endif
                        {{-- Alert end --}}


                        <form action="{{ route('my-profile.update', auth()->user()) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div class="input-area">
                                    <label for="name" class="form-label">
                                        {{ __('Name') }}
                                    </label>
                                    <input id="name" class="form-control" placeholder="{{ __('Enter Your Name') }}"
                                        readonly value="{{ auth()->user()->name }}">
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="input-area">
                                    <label for="email" class="form-label">
                                        {{ __('Email') }}
                                    </label>
                                    <input name="email" type="email" id="email" class="form-control"
                                        placeholder="{{ __('Enter Your Email') }}" required
                                        value="{{ auth()->user()->email }}">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>


                                <div class="input-area">
                                    <label for="country" class="form-label">
                                        {{ __('Photo') }}
                                    </label>
                                    <input onchange="imagePreview(event, 'profilePagePreviewId')" name="photo"
                                        type="file" placeholder="Default input" class="form-control
                                    p-[0.565rem] pl-2">
                                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn btn-dark mt-3">
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let imagePreview = function(event, id) {
                let output = document.getElementById(id);
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            };
    </script>
    @endpush
</x-app-layout>