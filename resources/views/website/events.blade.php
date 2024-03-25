<x-app-layout>
    <!-- START::PAGE HEADER -->
    @php
    $buttonText = 'Find Group Tickets';
    @endphp
    <x-page-header :buttonTitle="$buttonText"></x-page-header>
    <!-- END::PAGE HEADER -->

    <section class="content-section mt-4" style="background:#F6FAFB">
        <span class="section-bg" data-scroll data-scroll-speed="2"
            style="background:url('images/section-bg05.png')"></span>
        <!-- end section-bg -->

        <div class="container mt-4">

            <booking-events :slots="{{json_encode($slots)}}"></booking-events>
        </div>
        <!-- end container -->
    </section>
    <section class="content-section no-spacing top-half-white-bg " style="#F6FAFB">
        <span class="section-bg" style="background:url('images/section-bg01.png')" data-scroll
            data-scroll-speed="2"></span>
        <!-- end section-bg -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div data-scroll data-scroll-speed="0.5">
                        <div class="section-title text-center">
                            <h6 class="text-white">Online bookings available only between 7-45 days in advance

                            </h6>
                            <h2 class="text-white">Birthday Party Packages
                            </h2>
                        </div>
                        <!-- end section-title -->
                    </div>
                </div>
                <div class="col-lg-7">
                    <div data-scroll data-scroll-speed="-1">
                        <div class="side-content left">
                            <h6>LET'S HAVE FUN</h6>
                            <h2>Funvilla Group Discounts</h2>
                            <p>Minimum group of 10 required belief that we can achieve
                                more by working together than we can alone. As a member of
                                the IAB, your company can make its voice.</p>
                            <a href="#" class="custom-button"> <span class="circle" aria-hidden="true"> <span
                                        class="icon arrow"></span> </span> <span class="button-text">DISCOVER
                                    NOW</span></a>
                        </div>
                        <!-- end side-content -->
                    </div>
                    <!-- end data-scroll -->
                </div>
                <!-- end col-7 -->
                <div class="col-xl-3 col-lg-4 offset-xl-2 offset-lg-1">
                    <div data-scroll data-scroll-speed="-0.5">
                        <div class="color-icon-box" style="background:#388B7C">
                            <div class="inner-bg" style="background:url('images/icon-color-box-bg03.svg')"></div>
                            <!-- end inner-bg -->
                            <figure> <img src="/images/icon-color-box01.png" alt="Image"> </figure>
                            <h5>CAMP BOOKINGS</h5>
                            <p>We offer members free and
                                discounted access to all our
                                events, either virtually.</p>
                        </div>
                        <!-- end color-icon-box -->
                    </div>
                    <!-- end data-scroll -->
                    <div data-scroll data-scroll-speed="0.5">
                        <div class="color-icon-box" style="background:#151517">
                            <div class="inner-bg" style="background:url('images/icon-color-box-bg02.svg')"></div>
                            <!-- end inner-bg -->
                            <figure> <img src="/images/icon-color-box02.png" alt="Image"> </figure>
                            <h5>SCHOOL TRIPS</h5>
                            <p>We offer members free and
                                discounted access to all our
                                events, either virtually.</p>
                        </div>
                        <!-- end color-icon-box -->
                    </div>
                    <!-- end data-scroll -->
                </div>
                <!-- end col-4 -->
                <div class="col-xl-3 col-lg-4 offset-xl-6 offset-lg-4">
                    <div data-scroll data-scroll-speed="-0.5">
                        <div class="color-icon-box" style="background:#334AC1">
                            <div class="inner-bg" style="background:url('images/icon-color-box-bg01.svg')"></div>
                            <!-- end inner-bg -->
                            <figure> <img src="images/icon-color-box03.png" alt="Image"> </figure>
                            <h5>DAYCARE BOOKINGS</h5>
                            <p>We offer members free and
                                discounted access to all our
                                events, either virtually.</p>
                        </div>
                        <!-- end color-icon-box -->
                    </div>
                    <!-- end data-scroll -->
                </div>
                <!-- end col-3 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>


    <section class="content-section">

        <span class="section-bg" data-background="images/section-bg06.png" data-scroll data-scroll-speed="2"></span>
        <!-- end section-bg -->

        <div class="container">
            <div class="slide-container row">
                <div class="col-12">
                    {{-- <div data-scroll data-scroll-speed="-0.5">
                        <div class="section-title text-center">
                            <figure><img src="images/title-shape.png" alt="Image"></figure>
                            <h6>EVENT CONFERENCE SPEAKERS</h6>

                        </div>
                        <!-- end section-title -->
                    </div>
                    <!-- end data-scroll -->
                </div> --}}




            </div> <!-- end container -->

            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end content-section -->


</x-app-layout>