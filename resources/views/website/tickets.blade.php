<x-app-layout>
    <header class="page-header" style="background-image: url('images/page-header-bg.png');">
        <div class="container">
            <div class="inner">
                <div class="mb-3 p-4">
                    <h6 class="text-center">BOOK FOR FUNVILLA ATTRACTIONS</h6>
                    <p class="text-center mb-3 p-3">Attraction may vary from location to location. Please check your
                        nearest locations for more details.</p>
                </div>
                <div class="row">
                    <div class="col-md-2 ">
                    </div>
                    <div class="col-md-8 search-block p-3">

                        <form action="" method="">
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
                                <div class="col-12 col-md-6 col-lg-3 mt-4 mt-lg-0">
                                    <label for="return-date"
                                        class="label-style text-capitalize form-label text-secondary lable-search">Booking
                                        Time</label>
                                    <div class="input-group date" id="datepicker2">
                                        <input type="time" class="form-control" id="return-date">


                                    </div>
                                </div>
                                <div class="d-grid gap-2 mt-4">
                                    <button class="" type="submit">Find Your Tickets</button>
                                </div>
                            </div>
                        </form>



                    </div>
                    <div class="col-md-2 ">
                    </div>
                </div>

                <!-- end inner -->
            </div>
            <!-- end container -->
    </header>

    <!-- end page-header -->

    <!-- START::PAGE HEADER -->

    <section class="content-section" style=" margin-top: 130px;">
        <span class="section-bg" data-scroll data-scroll-speed="2"></span>
        <location-categories :categories="{{json_encode($categories)}}"></location-categories>

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
    {{--
    <location-categories :categories="{{json_encode($categories)}}"></location-categories>

    --}}

</x-app-layout>