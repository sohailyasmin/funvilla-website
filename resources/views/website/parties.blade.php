<x-app-layout>
    <!-- START::PAGE HEADER -->
    @php
    $smallText = 'Find Party Tickets';
    $largeText = 'Birthday Party Packages';
    @endphp
    <x-page-header :smallText="$smallText" :largeText="$largeText"></x-page-header>
    <!-- END::PAGE HEADER -->

    <section class="content-section mt-4" style="background:#F6FAFB">
        <span class="section-bg" data-scroll data-scroll-speed="2"
            style="background:url('images/section-bg05.png')"></span>
        <!-- end section-bg -->
        {{-- <div class="col-12">
            <div data-scroll data-scroll-speed="0.5">
                <div class="section-title text-center" style="    margin-bottom: 20px;
                        ">
                    <h6>Online bookings available only between 7-45 days in advance

                    </h6>
                    <h2>Birthday Party Packages
                    </h2>
                </div>
                <!-- end section-title -->
            </div>
            <div data-scroll data-scroll-speed="0.5">
                <div class="row  mt-4">
                    <div class="col-md-2 ">
                    </div>
                    <div class="col-md-8 search-block p-3">

                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                                    <label for="vehicle"
                                        class="label-style text-capitalize form-label text-secondary lable-search">Location</label>
                                    <div class="input-group date ">
                                        <select class="form-select form-control " id="location"
                                            aria-label="Default select example" required>
                                            <option selected="">Select Location</option>
                                            <option value="1">London</option>

                                        </select>

                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                                    <label for="pick-up-date"
                                        class="label-style text-capitalize form-label text-secondary lable-search">Booking
                                        Date</label>
                                    <div class="input-group date" id="datepicker1">
                                        <input type="date" class="form-control" id="pick-up-date" required>



                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                                    <label for="return-date"
                                        class="label-style text-capitalize form-label text-secondary lable-search">Booking
                                        Time</label>
                                    <div class="input-group date" id="datepicker2">
                                        <input type="time" class="form-control" id="return-date">


                                    </div>
                                </div>

                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0 ">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">

                                    <a href="javascript:void(0)" class="custom-button"><span class="circle"
                                            aria-hidden="true"><i class="fa fa-search" aria-hidden="true"></i>
                                        </span> <span class="button-text">Find Party Tickets</span></a>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 mt-4 mt-lg-0">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                    </div>
                </div>
                <div class="section-title text-center">

                </div>
                <!-- end section-title -->
            </div>
            <!-- end data-scroll -->
        </div> --}}

        <div class="container mt-4">
            <booking-parties :slots="{{json_encode($slots)}}"></booking-parties>
        </div>
        <!-- end container -->
    </section>
    <section class="content-section mt-4">
        <span class="section-bg" style="background:url('images/section-bg01.png')" data-scroll
            data-scroll-speed="1"></span>
        <!-- end section-bg -->
        <div class="container mt-4">
            <div class="row align-items-center mt-4">
                <div class="col-lg-6">
                    <div data-scroll data-scroll-speed="-0.5">
                        <div class="side-content left">
                            <h6>We take the stress away!
                            </h6>
                            <h2>Birthday Parties
                            </h2>
                            <p>Birthday parties at Funvilla are hassle-free experiences. Your fun starts right from the
                                door. Our funvilla staff will welcome you at the reception and direct you to your
                                private party room which will be setup and ready with drinks (coffee, water and juice
                                boxes). You will be served with food and drinks as per your package followed
                                by our luscious happy birthday cake. Your party host will start cleaning up at the end
                                of the 2 hours (30 minutes before the official end of your party). </p>
                            <a href="#" class="custom-button"> <span class="circle" aria-hidden="true"> <span
                                        class="icon arrow"></span> </span> <span class="button-text">DISCOVER
                                    NOW</span></a>
                        </div>
                        <!-- end side-content -->
                    </div>
                    <!-- end data-scroll -->
                </div>
                <!-- end col-6 -->
                <div class="col-lg-6">
                    <div data-scroll data-scroll-speed="0.5">
                        <figure class="side-image"> <img src="images/side-image01.png" alt="Image"> </figure>
                        <!-- end side-image -->
                    </div>
                    <!-- end data-scroll -->
                </div>
                <!-- end col-6 -->
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