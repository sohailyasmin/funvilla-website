<template>
  <div class="row">
    <!-- cart -->
    <div class="col-lg-8">
      <div class="card border shadow-0">
        <div class="m-4">
          <div
            class="row gy-3 mb-4"
            v-for="(item, index) in cartItems"
            :key="index"
          >
            <div class="col-lg-8">
              <div class="me-lg-5">
                <div class="d-flex checkout-cart">
                  <!-- <img
                    src="/images/1.png"
                    class="border checkout-cart-img rounded me-3"
                    style="width: 96px; height: 96px"
                  /> -->
                  <div class="">
                    <h5 class="checkout-cart-title">
                      {{ item.title }}
                    </h5>
                    <p class="checkout-cart-description">
                      <span v-for="(featured, findex) in item.features">{{
                        featured
                      }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="">
                <input type="number" max="20" value="1" />
              </div>
              <div class="">
                <text class="h6">${{ item.price }}</text> <br />
                <small class="text-muted text-nowrap">
                  $460.00 / per ticket
                </small>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="float-md-end">
                <a
                  href="#!"
                  class="btn btn-light border btn-sm icon-hover-primary"
                  ><i class="fas fa-trash text-secondary"></i
                ></a>
              </div>
            </div>
          </div>
        </div>

        <div class="border-top pt-4 mx-4 mb-4">
          <p>Note</p>
          <p class="text-muted">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip
          </p>
        </div>
      </div>
    </div>
    <!-- cart -->
    <!-- summary -->
    <div class="col-lg-4">
      <div class="card mb-3 border shadow-0">
        <div class="card-body">
          <form>
            <div class="form-group">
              <label class="form-label">Have coupon?</label>
              <div class="input-group">
                <input
                  type="text"
                  class="form-control border"
                  name=""
                  placeholder="Coupon code"
                />
                <button class="btn btn-light border">Apply</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="card shadow-0 border">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <p class="mb-2">Total price:</p>
            <p class="mb-2">$329.00</p>
          </div>
          <div class="d-flex justify-content-between">
            <p class="mb-2">Discount:</p>
            <p class="mb-2 text-success">-$60.00</p>
          </div>
          <div class="d-flex justify-content-between">
            <p class="mb-2">TAX:</p>
            <p class="mb-2">$14.00</p>
          </div>
          <hr />
          <div class="d-flex justify-content-between">
            <p class="mb-2">Total price:</p>
            <p class="mb-2 fw-bold">$283.00</p>
          </div>

          <div class="mt-3">
            <a href="#" class="custom-button"
              ><span class="circle" aria-hidden="true"
                ><span class="icon arrow"></span
              ></span>
              <span class="button-text">PAY NOW</span></a
            >
          </div>
        </div>
      </div>
    </div>
    <!-- summary -->
  </div>
</template>

<script>
import BookingPlans from "@/components/booking/Plans.vue";

export default {
  components: {},
  props: [],
  created() {
    this.fetchCartItems();
  },
  data() {
    return {
      cartItems: [],
    };
  },
  methods: {
    fetchCartItems() {
      const items = this.$cart.getItems();
      this.cartItems = items;
    },
  },
};
</script>

<style scoped></style>
