<template>
  <div>
    <div class="row justify-content-center g-0 mt-4" v-show="!selectedTicket">
      <booking-plans
        v-for="(pricing, index) in packages"
        :key="index"
        :pricing="pricing"
        @buyTicketForm="buyTicketForm"
      />
    </div>

    <div v-if="selectedTicket" class="animate__animated animate__fadeIn">
      <form
        class="space-y-4 card"
        style="padding: 3rem 3rem"
        @submit.prevent="submitForm"
      >
        >
        <h2 class="card-title">{{ selectedTicket.title }}</h2>
        <div class="card-body p-6">
          <div class="row">
            <div class="col-md-12">
              <div class="mt-3">
                <h6 class="section-title-h6">Booking Information</h6>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-area relative">
                <label for="name" class="form-label label-text"
                  ><span>Person Name</span>
                </label>
                <div>
                  <form-input
                    type="text"
                    v-model="formData['name']"
                    :dynamicAttrs="{ required: true }"
                  ></form-input>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-area relative">
                <label for="phone" class="form-label label-text"
                  ><span>Person Phone</span>
                </label>
                <div>
                  <form-input
                    type="text"
                    v-model="formData['phone']"
                    :dynamicAttrs="{ required: true }"
                  ></form-input>
                </div>
              </div>
            </div>
          </div>

          <button
            type="submit"
            class="btn btn-sm inline-flex justify-center btn-dark mt-4 w-full"
          >
            Save Information
          </button>
          <button
            @click="() => (selectedTicket = null)"
            type="button"
            class="btn btn-sm justify-center btn-dark mt-4 ms-4 w-full"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import BookingPlans from "@/components/booking/Plans.vue";
import FormInput from "@/components/inputs/FormInput.vue";

export default {
  components: {
    BookingPlans,
    FormInput,
  },
  props: ["slots"],

  data() {
    return {
      invalidSevenDays: false,
      selectedDate: null,
      selectedTicket: null,
      bookingSlot: null,
      slotRooms: [],
      formData: [],

      packages: [
        {
          title: "Valentine's day deal 1",
          price: "449.99",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
        {
          title: "Valentine's day deal 2",
          price: "90",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: 0.5,
          featured: true,
        },
        {
          title: "Valentine's day deal 3",
          price: "649.99",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
      ],
    };
  },
  methods: {
    buyTicketForm(ticket) {
      this.selectedTicket = ticket;
    },
    formatTime(time) {
      const [hours, minutes] = time.split(":");
      return `${hours}:${minutes}`;
    },
    submitForm() {
      const cartItem = {
        ...this.selectedTicket,
        otherinfo: { ...this.formData },
      };

      this.$cart.addItem(cartItem);
      this.selectedTicket = null;
      this.formData = [];
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "successfully added to cart",
        showConfirmButton: false,
        timer: 1500,
      });
    },
  },
};
</script>

<style scoped>
.animate__fadeIn {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.label-text {
  font-size: 13px;
  font-weight: 500;
}
</style>
