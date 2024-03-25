<template>
  <div>
    <div class="row" v-for="(ticket, index) in tickets" :key="index">
      <div class="col-md-3">
        <img :src="'images/' + ticket.id + '.png'" alt="WEEKDAY" />
      </div>
      <!-- end event-time -->
      <div class="col-md-9">
        <h4>{{ ticket.display_name }}</h4>
        <p>
          {{ ticket.description }}
        </p>
        <div class="row">
          <div class="col-md-4">
            <SelectInput
              v-model="selectedOption"
              :dynamic-attrs="{ required: true }"
              :options="selectOptions"
            />
          </div>
          <div class="col-md-4">
            <button
              class="btn inline-flex justify-center btn-dark"
              @click="addToCart(ticket)"
            >
              add to cart
            </button>
          </div>
        </div>

        <!-- end event-description -->
      </div>

      <!-- end wrapper -->
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import SelectInput from "@/components/inputs/SelectInput.vue";

export default {
  props: ["tickets", "category"],
  components: {
    SelectInput,
  },
  data() {
    return {
      cart: [],
      selectedOption: "",

      selectOptions: [
        { value: 1, label: "1" },
        { value: 2, label: "2" },
        { value: 3, label: "3" },
      ],
      qty: 0,
      storageName: "funvilla-cart",
    };
  },
  created() {},
  methods: {
    setQty(val) {
      this.qty = val;
    },
    addToCart(ticket) {
      const existingItem = this.cart.find(
        (item) => item.ticket.id === ticket.id
      );

      if (existingItem) {
        existingItem.quantity++;
      } else {
        this.cart.push({ ticket, quantity: 1 });
      }

      this.saveCart();
    },
    removeFromCart(ticket) {
      const index = this.cart.findIndex((item) => item.ticket.id === ticket.id);

      if (index !== -1) {
        const item = this.cart[index];

        if (item.quantity > 1) {
          item.quantity--;
        } else {
          this.cart.splice(index, 1);
        }

        this.saveCart();
      }
    },
    saveCart() {
      // Save cart data to local storage
      localStorage.setItem(this.storageName, JSON.stringify(this.cart));
    },
  },
  mounted() {
    const storedCart = localStorage.getItem(this.storageName);
    if (storedCart) {
      this.cart = JSON.parse(storedCart);
    }
  },
};
</script>

<style>
.schedule-box .tab-content .timeline .event-time img {
  height: 150px;
  display: inline-block;
  margin-right: 10px;
}
.schedule-box .tab-content {
  width: calc(85% - 300px);
  display: flex;
  flex-wrap: wrap;
  background: #fff;
  padding: 30px;
  position: relative;
  z-index: 1;
}
.schedule-box .nav div {
  height: 80px;
}
</style>
