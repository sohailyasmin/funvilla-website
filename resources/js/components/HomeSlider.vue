<template>
  <section class="slider">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="events-slider-content">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div
                  class="swiper-slide"
                  v-for="(event, index) in events"
                  :key="index"
                >
                  <div class="inner">
                    <div class="date">
                      <figure>
                        <img src="images/icon-date.svg" alt="Image" />
                      </figure>
                      <span>{{ event.date }}</span>
                    </div>
                    <!-- end date -->
                    <h2>{{ event.title }}</h2>
                    <a href="#" class="slider-button">
                      <span class="circle" aria-hidden="true">
                        <span class="icon arrow"></span>
                      </span>
                      <span class="button-text">BUY TICKET</span>
                    </a>
                    <div class="location">
                      <div class="icon">
                        <img src="images/icon-location.svg" alt="Image" />
                      </div>
                      <span>{{ event.location }}</span>
                    </div>
                    <!-- end location -->
                  </div>
                  <!-- end inner -->
                </div>
                <!-- end swiper-slide -->
              </div>
              <!-- end swiper-wrapper -->
              <div class="swiper-pagination"></div>
            </div>
            <!-- end swiper-container -->
          </div>
          <!-- end events-slider-content -->
        </div>
        <!-- end col-6 -->
        <div class="col-lg-6">
          <div class="events-slider-images">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                <div
                  class="swiper-slide"
                  v-for="(event, index) in events"
                  :key="index"
                >
                  <div class="slide-image" :data-background="event.image"></div>
                </div>
                <!-- end swiper-slide -->
              </div>
              <!-- end swiper-wrapper -->
              <div class="swiper-button-prev">prev</div>
              <div class="swiper-button-next">next</div>
            </div>
            <!-- end swiper-container -->
          </div>
          <!-- end events-slider-content -->
        </div>
        <!-- end col-6 -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </section>
</template>

<script>
import Swiper from "swiper";

export default {
  data() {
    return {
      events: [
        {
          date: "May 22, 2021 - 9:00 PM (ET)",
          title: "Envato International Author Summit",
          location: "London - UK",
          image: "images/slide-image01.jpg",
        },
        {
          date: "May 22, 2021 - 9:00 PM (ET)",
          title: "The 17th EU-Ukraine Summit",
          location: "Kiev - UKRAINE",
          image: "images/slide-image02.jpg",
        },
        {
          date: "May 22, 2021 - 9:00 PM (ET)",
          title: "The 28th Africa France Summit 2021",
          location: "Paris - FRANCE",
          image: "images/slide-image03.jpg",
        },
      ],
    };
  },
  methods: {
    initializeSwipers() {
      new Swiper(".events-slider-content .swiper-container", {
        pagination: {
          el: ".events-slider-content .swiper-pagination",
          clickable: true,
        },
      });

      new Swiper(".events-slider-images .swiper-container", {
        navigation: {
          nextEl: ".events-slider-images .swiper-button-next",
          prevEl: ".events-slider-images .swiper-button-prev",
        },
      });
    },
  },
  mounted() {
    this.initializeSwipers();
  },
};
</script>

<style>
/* Add your styles here */
</style>
