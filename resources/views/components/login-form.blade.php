<form method="POST" action="{{ route('login') }}" class="space-y-4" style="display: none">
    @csrf

    {{-- Email --}}
    <div class="fromGroup">
        <label for="email" class="block capitalize form-label">{{ __('Email') }}</label>
        <div class="relative ">
            <input type="email" name="email" id="email"
                class="form-control py-2 @error('email') !border !border-red-500 @enderror"
                placeholder="{{ __('Type your email') }}" autofocus value="{{ old('email') }}">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
    </div>

    {{-- Password --}}
    <div class="fromGroup">
        <label for="password" class="block capitalize form-label">{{ __('Password') }}</label>
        <div class="relative ">
            <input type="password" name="password"
                class="form-control py-2 @error('password') !border !border-red-500 @enderror"
                placeholder="{{ __('Password') }}" id="password" autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
    </div>


    {{-- Remember Me checkbox --}}
    <div class="flex justify-between">
        <div class="checkbox-area">
            <label class="inline-flex items-center cursor-pointer" for="remember_me">
                <input type="checkbox" class="hidden" name="remember" id="remember_me">
                <span
                    class="h-4 w-4 border flex-none border-slate-100 dark:border-slate-800 rounded inline-flex ltr:mr-3 rtl:ml-3 relative transition-all duration-150 bg-slate-100 dark:bg-slate-900">
                    <img src="images/icon/ck-white.svg" alt="" class="h-[10px] w-[10px] block m-auto opacity-0"></span>
                <span class="text-slate-500 dark:text-slate-400 text-sm leading-6">{{ __('Keep me signed in') }}</span>
            </label>
        </div>

    </div>

    <button type="submit" class="btn btn-dark block w-full text-center">
        {{ __('Sign In') }}
    </button>

</form>

<section class="ftco-section content-section">
    <div class="container ">

        <div class="row ">
            <div class="col-md-12 col-lg-10">
                <div class="row">
                    <div class="col-md-6">
                        <img src="images/auth/play8.jpg" />
                    </div>
                    <div class="col-md-6 p-4 p-md-5">
                        <div class="">
                            <div class="section-title text-center" style="margin-bottom: 0px;">

                                <h6>EVENT CONFERENCE ORGANISATION</h6>
                                <h2>Login</h2>
                            </div>

                            <form method="POST" action="{{ route('login') }}" class="signin-form">
                                @csrf
                                <div class="form-group mb-3 ">
                                    <label class="label" for="name">Email</label>

                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') !border !border-red-500 @enderror"
                                        placeholder="{{ __('Type your email') }}" autofocus value="{{ old('email') }}">
                                    <x-input-error :messages="$errors->get('email')" class="text-danger" />
                                </div>
                                <div class="form-group mb-3 ">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') !border !border-red-500 @enderror"
                                        placeholder="{{ __('Password') }}" id="password"
                                        autocomplete="current-password">
                                    <x-input-error :messages="$errors->get('password')" class="text-danger" />
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign
                                        In</button>
                                </div>
                                <div class="form-group d-md-flex mt-4">
                                    <div class="w-50 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" checked="" name="remember">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="{{ route('password.request') }}" class="">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    </div>

                                </div>
                            </form>
                            <p class="mt-4 ">Not a member? <a href="/signup-waiver">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>