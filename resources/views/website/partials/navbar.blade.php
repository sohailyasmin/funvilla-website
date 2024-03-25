<!-- end search-box -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0 navbar-small ">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto  mb-lg-0">
                {{-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li> --}}
            </ul>
            <span class="navbar-text">
                <ul class="navbar-nav me-auto mb-lg-0">
                    {{-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li> --}}

                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                </ul>
            </span>
        </div>
    </div>
</nav>
<nav class="navbar navbar-main fixed-top" id="navbar">
    <div class="container">
        <div class="logo"> <a href="/"> <img src="images/funvilla-logo-removebg-preview.png" alt="Image"> </a>
        </div>
        <!-- end logo -->
        <div class="site-menu">
            <ul>
                <li><a href="{{ route('tickets.index') }}">Tickets</a></li>
                <li><a href="{{ route('signup-waiver') }}">Waiver</a></li>
                <li><a href="{{ route('parties.index') }}">Parties</a></li>
                <li><a href="{{ route('groups.index') }}">Groups</a></li>
                <li><a href="{{ route('memberships.index') }}">Memberships</a></li>
                <li><a href="{{ route('events.index') }}">Events</a></li>
                {{-- <li><a href="contact.html">Contact</a></li> --}}
            </ul>
        </div>
        <!-- end site-menu -->
        <div class="search-button"><i class="fas fa-search"></i> </div>
        <!-- end search-button -->
        <div class="more-button"><a href="{{ route('checkout.index') }}"> <i class="fas fa-shopping-cart"></i></a>
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
        <div class="navbar-button"> <a href="{{ route('booking-camp') }}">
                <figure><i class="fas fa-ticket" style="rotate: 30deg !important;"></i></figure>
                Book Camp
            </a> </div>
        <!-- end navbar-button -->
    </div>
    <!-- end container -->
</nav>