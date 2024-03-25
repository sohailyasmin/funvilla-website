<nav class="navbar navbar-main" id="navbar" style="top: 0px;">
    <div class="container">
        <div class="logo"> <a href="/"> <img src="images/funvilla-logo-removebg-preview.png" alt="Image"> </a>
        </div>
        <!-- end logo -->
        <div class="site-menu">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/customers">My Waivers</a></li>
                <li><a href="#">My Bookings</a></li>


            </ul>
        </div>

        <!-- end more-button -->
        <div class="hamburger-menu">
            <button class="menu">
                <svg width="45" height="45" viewBox="0 0 100 100">
                    <path class="line line1"
                        d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                    <path class="line line2" d="M 20,50 H 80" />
                    <path class="line line3"
                        d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
                </svg>
            </button>
        </div>
        <!-- end hamburger-menu -->
        <div class="navbar-button"> <a href="{{ route('my-profile.index') }}">
                <figure><img src="{{ auth()->user()->getFirstMediaUrl('profile-image') ?:
                    Avatar::create(auth()->user()->name)->setDimension(400)->setFontSize(240)->toBase64() }}"
                        alt="Image"></figure>
                Profile
            </a> </div>
        <!-- end navbar-button -->
    </div>
    <!-- end container -->
</nav>