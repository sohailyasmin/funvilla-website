<template>
  <div class="col-xl-3 col-lg-4 col-md-6">
    <div class="price-box" :class="{ featured: pricing.featured }">
      <h5>{{ pricing.title }}</h5>
      <div class="price">
        <span class="currency">$</span>
        <span class="value">{{ pricing.price }}</span>
      </div>
      <ul>
        <li
          v-for="(feature, featureIndex) in pricing.features"
          :key="featureIndex"
          :class="{ active: pricing.featured || featureIndex < 3 }"
        >
          <i
            class="far"
            :class="{
              'fa-check-circle': pricing.featured || featureIndex < 3,
              'fa-times-circle': !pricing.featured && featureIndex >= 3,
            }"
          ></i>
          {{ feature }}
        </li>
      </ul>

      <a href="javascript:void(0)" class="custom-button" @click="buyTicket">
        <span class="circle" aria-hidden="true">
          <span class="icon arrow"></span>
        </span>
        <span class="button-text">BUY A TICKET</span>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    pricing: Object,
  },
  methods: {
    buyTicket() {
      this.$emit("buyTicketForm", this.pricing);
    },
  },
};
</script>
