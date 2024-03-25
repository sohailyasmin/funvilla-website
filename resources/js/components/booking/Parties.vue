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
      <form class="space-y-4 card" style="padding: 3rem 3rem">
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
                <label
                  for="booking_date"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
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
                <label
                  for="last_name"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
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
                <label
                  for="month_dob"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Room</span><span class="text-danger"> * </span></label
                >
                <div>
                  <select class="form-select" name="month_dob" id="month_dob">
                    <option disabled="" value="">Select Room</option>
                    <option :value="slot.room.id" v-for="slot in slotRooms">
                      {{ slot.room.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="mt-3">
                <h6 class="section-title-h6">
                  Who gets to enjoy the lucky birthday bash
                </h6>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-area relative">
                <label
                  for="phone"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Name of the birthday child.</span
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
                <label
                  for="turning"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Turning To (reaching the age of)</span>
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
                <label
                  for="city"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Parent/Guardian's Name</span>
                </label>
                <div>
                  <input
                    type="text"
                    name="guardian"
                    id="guardian"
                    class="form-control"
                    placeholder=""
                  />
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <div class="mt-3">
                <h6 class="section-title-h6">some text here</h6>
              </div>
            </div>
            <div class="col-md-3">
              <div class="input-area relative">
                <label
                  for="account_type_id"
                  class="form-label mt-3"
                  style="font-size: 13px; font-weight: 500"
                  ><span>Socks tab?</span>
                </label>
                <div>
                  <select
                    class="form-select"
                    name="account_type_id"
                    id="account_type_id"
                  >
                    <option disabled="" value="">Select</option>
                    <option value="1">Yes</option>
                    <option value="2">No</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-9">
              <div class="input-area relative"></div>
              <div class="col-md-9">
                <div class="input-area relative">
                  <label for="account_type_id" class="form-label mt-3"
                    ><span></span>
                  </label>
                  <div>
                    <p
                      style="
                        font-size: 13px;
                        font-weight: 500;
                        margin-top: 20px;
                      "
                    >
                      Will you (Party Host) pay for the grip socks cost for your
                      party guests? $2.50 + HST per pair.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="mt-3">
                <h6 class="section-title-h6">
                  options included in the selected package
                </h6>
              </div>
            </div>
            <package-options></package-options>
          </div>

          <button
            type="submit"
            class="btn inline-flex justify-center btn-dark mt-4 w-full"
          >
            Submit
          </button>
          <button
            @click="() => (selectedTicket = null)"
            type="button"
            class="btn justify-center btn-dark mt-4 ms-4 w-full"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import PackageOptions from "@/components/booking/PackageOptions.vue";
import BookingPlans from "@/components/booking/Plans.vue";

export default {
  props: ["slots"],
  components: {
    PackageOptions,
    BookingPlans,
  },
  data() {
    return {
      invalidSevenDays: false,
      selectedDate: null,
      selectedTicket: null,
      bookingSlot: null,
      slotRooms: [],
      packages: [
        {
          title: "10 CHILDREN PARTY",
          price: "449.99",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
        {
          title: "15 CHILDREN PARTY",
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
          title: "20 CHILDREN PARTY",
          price: "649.99",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: -0.5,
        },
        {
          title: "30 CHILDREN PARTY",
          price: "879.99",
          features: [
            "Full Conference (workshop, coffee etc)",
            "Live Videos (Can access online free)",
            "Meet Speaker (Ask questions privately)",
          ],
          speed: 0.5,
          featured: true,
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
</style>
