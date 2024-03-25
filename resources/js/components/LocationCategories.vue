<template>
  <div>
    <div class="container">
      <div class="row">
        <!-- end col-12 -->
        <div class="col-12">
          <div data-scroll data-scroll-speed="0.5">
            <div class="schedule-box">
              <div class="nav">
                <div
                  v-for="(category, index) in categories"
                  :key="index"
                  :class="index === 0 ? 'active' : ''"
                  data-bs-toggle="tab"
                  :data-bs-target="'#tab-content0' + category.id"
                  @click="selectCategory(category)"
                >
                  <span class="day">{{ category.name }}</span>

                  <small class="date"></small>
                </div>

                <!-- tab-nav -->
              </div>
              <!-- end nav -->
              <div class="tab-content">
                <div :class="'tab-pane fade show active'">
                  <category-tickets
                    :tickets="categoryTickets"
                    :category="selectedCategory"
                  />
                </div>
                <!-- end tab-pane -->

                <!-- end tab-pane -->
              </div>
              <!-- end tab-content -->
            </div>
            <!-- end schedule-box -->
          </div>
          <!-- end data-scroll -->
        </div>
        <!-- end col-12 -->
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
</template>

<script>
import axios from "axios";
import CategoryTickets from "@/components/CategoryTickets.vue";

export default {
  props: ["categories"],
  components: {
    CategoryTickets,
  },
  data() {
    return {
      selectedCategory: this.categories ? this.categories[0] : null,
      categoryTickets: [],
      results: [],
    };
  },
  created() {
    this.getCategoryTickets();
  },
  methods: {
    async selectCategory(category) {
      this.selectedCategory = category;
      await this.getCategoryTickets();
    },
    async getCategoryTickets() {
      try {
        let imageUrl = window.location.origin + "/images/funvilla.png";
        $.LoadingOverlay("show", {
          image: imageUrl,
          imageAnimation: "1.5s fadein",
        });
        const response = await axios.get(
          `/category-tickets/${this.selectedCategory.id}`
        );
        this.categoryTickets = response.data.data;
        $.LoadingOverlay("hide");
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
.content-section {
  width: 100%;
  display: block;
  flex-wrap: wrap;
  padding: 15px 0 !important;
  position: relative;
  background-size: cover !important;
  background-position: center !important;
}

.schedule-box .nav div .day {
  width: 100%;
  display: block;
  font-size: 28px;
  font-weight: 600;
  /* margin-top: auto; */
  line-height: 1;
  text-align: center;
}
</style>
