<x-app-layout>

    <section class="content-section ">
        <span class="section-bg" style="background:url('images/section-bg04.png')" data-scroll
            data-scroll-speed="2"></span>
        <!-- end section-bg -->
        <div class="container ">
            <div class="row">

                <!-- end col-12 -->
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                    <div data-scroll data-scroll-speed="-0.5">
                        <div class="speaker-detail">
                            <figure class="image" style="width: 300px;"> <img
                                    src="{{ auth()->user()->getFirstMediaUrl('profile-image') ?:
                                Avatar::create(auth()->user()->name)->setDimension(400)->setFontSize(240)->toBase64() }}" alt="Image">
                            </figure>
                            <!-- end image -->
                            <div class="content-box">
                                <h4>Mike Harper</h4>
                                <small>Head of Degital <br>
                                    Platform Engineering</small>
                                <ul>
                                    <li><strong>Phone:</strong>1-800-555-1234</li>
                                    <li><strong>Email:</strong> mike@aventer.co.uk</li>
                                    <li><strong>Website:</strong> https://mike.aventer.co.uk</li>
                                </ul>

                            </div>
                            <!-- end content-box -->
                        </div>
                        <!-- end speaker-detail -->
                    </div>
                    <!-- end data-scroll -->
                </div>
                <!-- end col-12 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>



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