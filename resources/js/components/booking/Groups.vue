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
                <label for="booking_date" class="form-label label-text"
                  ><span>Date</span><span class="text-danger"> * </span></label
                >
                <div>
                  <input
                    type="date"
                    name="booking_date"
                    id="booking_date"
                    class="form-control"
                    @input="checkDateValidity"
                    v-model="selectedDate"
                  />
                </div>
              </div>
              <div
                v-if="invalidSevenDays"
                class="text-danger"
                style="font-size: 12px"
              >
                Please select a date at least 7 days ahead.
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-area relative">
                <label for="time" class="form-label label-text"
                  ><span>Time</span><span class="text-danger"> * </span></label
                >
                <div>
                  <select
                    class="form-select"
                    name="booking_slot"
                    v-model="bookingSlot"
                    id="booking_slot"
                    @change="getRooms"
                  >
                    <option disabled="" value="">Select Slot</option>
                    <option :value="slot.id" v-for="slot in slots">
                      {{ formatTime(slot.from) }} - {{ formatTime(slot.to) }}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-area relative">
                <label for="room" class="form-label label-text"
                  ><span>Room</span><span class="text-danger"> * </span></label
                >
                <div>
                  <select class="form-select" name="room_id" id="room_id">
                    <option disabled="" value="">Select Room</option>
                    <option :value="slot.room.id" v-for="slot in slotRooms">
                      {{ slot.room.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-12 mt-3">
              <div class="mt-3">
                <h6 class="section-title-h6">some text here</h6>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-area relative">
                <label
                  for="phone"
                  class="form-label"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Supervisors</span
                  ><span class="text-danger"> * </span></label
                >
                <div>
                  <select
                    class="form-select"
                    name="supervisor_id"
                    id="supervisor_id"
                  >
                    <option disabled="" value="">Supervisors</option>
                    <option value="1">1 for $0</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-area relative">
                <label
                  for="turning"
                  class="form-label"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Category</span>
                </label>
                <div>
                  <select
                    class="form-select"
                    name="category_id"
                    id="category_id"
                  >
                    <option disabled="" value="">Select</option>
                    <option value="1">School</option>
                    <option value="2">Daycare</option>
                    <option value="2">Camp</option>
                    <option value="2">Academy</option>
                    <option value="2">Coporate</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-area relative">
                <label for="city" class="form-label label-text"
                  ><span>Booking</span>
                </label>
                <div>
                  <select
                    class="form-select"
                    name="account_type_id"
                    id="account_type_id"
                  >
                    <option disabled="" value="">Select</option>
                    <option value="1">Group</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-3">
              <div class="mt-3">
                <h6 class="section-title-h6">some text here</h6>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-area relative">
                <label
                  for="phone"
                  class="form-label"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Organization Name</span
                  ><span class="text-danger"> * </span></label
                >
                <div>
                  <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    placeholder=""
                  />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="input-area relative">
                <label for="turning" class="form-label label-text"
                  ><span>Contact Person Name</span>
                </label>
                <div>
                  <input
                    type="number"
                    name="turning"
                    id="staturningte"
                    class="form-control"
                    placeholder=""
                  />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-area relative">
                <label for="turning" class="form-label label-text"
                  ><span>Contact Person Phone</span>
                </label>
                <div>
                  <input
                    type="number"
                    name="turning"
                    id="staturningte"
                    class="form-control"
                    placeholder=""
                  />
                </div>
              </div>
            </div>
          </div>

          <button
            type="submit"
            class="btn btn-sm inline-flex justify-center btn-dark mt-4 w-full"
          >
            Submit
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

export default {
  components: {
    BookingPlans,
  },
  props: ["slots"],

  data() {
    return {
      invalidSevenDays: false,
      selectedDate: null,
      selectedTicket: null,
      bookingSlot: null,
      slotRooms: [],
      formInputs: [
        {
          label: "Date",
          name: "booking_date",
          id: "booking_date",
          type: "date",
          value: null,
          required: true,
          onInput: this.checkDateValidity,
        },
        {
          label: "Time",
          name: "booking_slot",
          id: "booking_slot",
          type: "select",
          value: null,
          required: true,
          options: [],
        },
        {
          label: "Room",
          name: "room_id",
          id: "room_id",
          type: "select",
          value: null,
          required: true,
          options: [],
        },
        {
          label: "Supervisors",
          name: "account_type_id",
          id: "account_type_id",
          type: "select",
          value: null,
          required: true,
          options: [{ value: "1", label: "1 for $0" }],
        },
        {
          label: "Category",
          name: "account_type_id",
          id: "account_type_id",
          type: "select",
          value: null,
          options: [
            { value: "1", label: "School" },
            { value: "2", label: "Daycare" },
            { value: "3", label: "Camp" },
            { value: "4", label: "Academy" },
            { value: "5", label: "Corporate" },
          ],
        },
        {
          label: "Booking",
          name: "account_type_id",
          id: "account_type_id",
          type: "select",
          value: null,
          options: [{ value: "1", label: "Group" }],
        },
        {
          label: "Organization Name",
          name: "name",
          id: "name",
          type: "text",
          value: null,
          required: true,
        },
        {
          label: "Contact Person Name",
          name: "turning",
          id: "staturningte",
          type: "number",
          value: null,
        },
        {
          label: "Contact Person Phone",
          name: "turning",
          id: "staturningte",
          type: "number",
          value: null,
        },
      ],
      packages: [
        {
          title: "Entry",
          price: "449.99",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
        {
          title: "Entry + Sock",
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
          title: "Entry + Sock + Arcade",
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
    checkDateValidity() {
      const selectedDate = new Date(this.selectedDate);
      const today = new Date();
      today.setDate(today.getDate() + 7); // Add 7 days to today's date

      if (selectedDate < today) {
        this.invalidSevenDays = true;
      } else {
        this.invalidSevenDays = false;
      }
      console.log(this.invalidSevenDays);
    },
    getRooms() {
      this.getSlotRooms();
    },
    async getSlotRooms() {
      try {
        let imageUrl = window.location.origin + "/images/funvilla.png";
        $.LoadingOverlay("show", {
          image: imageUrl,
          imageAnimation: "1.5s fadein",
        });
        const response = await axios.get(
          `/api/slot-rooms-parties/${this.bookingSlot}`
        );
        this.slotRooms = response.data.data;
        $.LoadingOverlay("hide");
      } catch (error) {
        console.log(error);
      }
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
