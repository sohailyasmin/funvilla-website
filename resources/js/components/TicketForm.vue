<template>
  <div id="create-ticket">
    <!-- Create tickets form start -->
    <div>
      <div class="card md:col-span-2">
        <div class="card-body flex flex-col p-4 md:p-6 lg:p-8">
          <div class="card-text">
            <form class="space-y-4">
              <div v-for="(items, itemsKey) in ticketFormItems" class="mb-10">
                <div
                  class="mb-6 items-center border-b border-slate-100 dark:border-slate-700 pb-2"
                >
                  <h6
                    class="text-slate-900 dark:text-white font-semibold text-left py-2"
                  >
                    <button
                      type="button"
                      v-if="itemsKey != 'Ticket Configuration'"
                      class="relative flex items-center w-full cursor-pointer text-slate-700 text-dark-500"
                      @click="
                        accordionToggle(
                          itemsKey
                            .toLowerCase()
                            .replaceAll('&', 'and')
                            .replaceAll(' ', '-')
                        )
                      "
                    >
                      <span>{{ itemsKey }}</span>
                      <iconify-icon
                        icon="il:arrow-down"
                        class="absolute right-0 pt-1 text-md"
                      ></iconify-icon>
                    </button>
                    <span v-else>{{ itemsKey }}</span>
                  </h6>
                </div>
                <div
                  :id="
                    itemsKey
                      .toLowerCase()
                      .replaceAll('&', 'and')
                      .replaceAll(' ', '-')
                  "
                  :class="
                    itemsKey != 'Ticket Configuration'
                      ? 'accordion-display'
                      : ''
                  "
                >
                  <div
                    v-if="
                      ticket['btn_img'] &&
                      itemsKey == 'Additional Configuration'
                    "
                    class="max-w-lg border-solid border-2 border-slate-600 rounded-lg mb-4 relative"
                  >
                    <button
                      class="absolute -right-2 -top-[11px] h-8 w-8 bg-red-500 text-sm font-semibold flex flex-col items-center justify-center rounded-full text-white z-auto"
                      @click="removeImage"
                    >
                      <iconify-icon icon="mdi:close"></iconify-icon>
                    </button>
                    <img class="p-2 w-full max-h-96" :src="ticket['btn_img']" />
                  </div>
                  <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-7 items-start mb-10"
                  >
                    <div
                      v-for="(item, index) in items"
                      :class="
                        item.html == 'input' && item.type == 'checkbox'
                          ? 'flex self-center'
                          : 'input-area relative'
                      "
                    >
                      <label
                        :for="item.name"
                        :class="
                          'block text-sm font-medium text-gray-900 dark:text-white' +
                          (item.html == 'input' && item.type == 'checkbox'
                            ? ' order-last mx-2'
                            : ' mb-2')
                        "
                      >
                        <span>{{ item.label }}</span>
                        <span v-if="item.required" class="text-red-600">
                          *
                        </span>
                      </label>
                      <select
                        v-if="item.html == 'select'"
                        :class="
                          item.readOnly
                            ? 'cursor-not-allowed border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                            : 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                        "
                        :name="item.name"
                        :id="item.name"
                        v-model="ticket[item.name]"
                        :readonly="item.readOnly"
                        :disabled="item.readOnly"
                      >
                        <option value="" selected disabled>
                          Select {{ item.label }}
                        </option>
                        <option
                          v-for="option in item.options"
                          :value="option.id"
                        >
                          {{ option.name ?? option.title }}
                        </option>
                      </select>
                      <VueMultiselect
                        v-else-if="item.html == 'multi-select'"
                        v-model="ticket[item.name]"
                        label="name"
                        track-by="name"
                        :options="item.options"
                        :multiple="true"
                        :close-on-select="true"
                        :placeholder="item.placeholder"
                        :id="item.name"
                      ></VueMultiselect>
                      <textarea
                        v-else-if="item.html == 'textarea'"
                        :name="item.name"
                        :id="item.name"
                        v-model="ticket[item.name]"
                        class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 resize-none"
                        :placeholder="item.placeholder"
                        rows="4"
                        :readonly="item.readOnly"
                      ></textarea>
                      <input
                        v-else-if="
                          item.html == 'input' && item.type == 'checkbox'
                        "
                        type="checkbox"
                        :id="item.name"
                        :name="item.name"
                        v-model="ticket[item.name]"
                        class="self-center w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                      />
                      <VueDatePicker
                        v-else-if="item.html == 'range-datepicker'"
                        :id="item.name"
                        v-model="ticket[item.name]"
                        :placeholder="item.placeholder"
                        range
                        multi-calendars
                      />
                      <VueDatePicker
                        v-else-if="item.html == 'time-picker'"
                        :id="item.name"
                        v-model="ticket[item.name]"
                        time-picker
                        disable-time-range-validation
                        :clearable="false"
                        :placeholder="item.placeholder"
                        :disabled="item.readOnly"
                        :readonly="item.readOnly"
                        :max-time="{ hours: 5, minutes: 59 }"
                        :min-time="{ hours: 0, minutes: 1 }"
                      />
                      <input
                        v-else-if="item.html == 'input' && item.type == 'image'"
                        type="file"
                        :name="item.name"
                        :id="item.name"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :placeholder="item.placeholder"
                        :readonly="item.readOnly"
                        @change="storeImage"
                        accept="image/x-png,image/gif,image/jpeg,image/jpg"
                      />
                      <input
                        v-else
                        :type="item.type"
                        :name="item.name"
                        :id="item.name"
                        v-model="ticket[item.name]"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :placeholder="item.placeholder"
                        :readonly="item.readOnly"
                      />
                      <div
                        v-if="Object.keys(errors).indexOf(item.name) != '-1'"
                      >
                        <span class="mt-4 text-red-600">{{
                          Array.isArray(errors[item.name])
                            ? errors[item.name][0]
                            : errors[item.name]
                        }}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="guests.length > 0"
                class="mb-6 items-center border-b border-slate-100 dark:border-slate-700 pb-2"
              >
                <h6
                  class="text-slate-900 dark:text-white font-semibold text-left py-2"
                >
                  <span>Guests Configuration</span>
                </h6>
              </div>
              <div
                v-for="(guestHtml, index) in guestsHtml"
                class="mt-4 mb-4 border-b border-slate-100 dark:border-slate-700 pb-6"
              >
                <div
                  :id="
                    'Guests Configuration'
                      .toLowerCase()
                      .replaceAll('&', 'and')
                      .replaceAll(' ', '-')
                  "
                >
                  <div
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-7 items-start mb-4"
                  >
                    <div
                      v-for="item in guestHtml.items"
                      class="input-area relative"
                    >
                      <label
                        :for="'guests_' + index + '_' + item.name"
                        class="block text-sm font-medium text-gray-900 dark:text-white mb-2"
                      >
                        <span>{{ item.label }}</span>
                        <span v-if="item.required" class="text-red-600">
                          *
                        </span>
                      </label>
                      <select
                        v-if="item.html == 'select'"
                        :class="
                          item.readOnly
                            ? 'cursor-not-allowed border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                            : 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                        "
                        :name="'guests_' + index + '_' + item.name"
                        :id="'guests_' + index + '_' + item.name"
                        v-model="guests[index][item.name]"
                        :readonly="item.readOnly"
                        :disabled="item.readOnly"
                      >
                        <option value="" selected disabled>
                          Select {{ item.label }}
                        </option>
                        <option
                          v-for="option in item.options"
                          :value="option.id"
                        >
                          {{ option.name ?? option.title }}
                        </option>
                      </select>
                      <input
                        v-else
                        :type="item.type"
                        :name="'guests_' + index + '_' + item.name"
                        :id="'guests_' + index + '_' + item.name"
                        v-model="guests[index][item.name]"
                        @keypress="isNumber($event)"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :placeholder="item.placeholder"
                        :readonly="item.readOnly"
                        :disabled="item.readOnly"
                      />
                      <div
                        v-if="
                          Object.keys(errors).indexOf(
                            'guests.' + index + '.' + item.name
                          ) != '-1'
                        "
                      >
                        <span class="mt-4 text-red-600">{{
                          Array.isArray(
                            errors["guests." + index + "." + item.name]
                          )
                            ? errors["guests." + index + "." + item.name][0]
                            : errors["guests." + index + "." + item.name]
                        }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="mr-4" v-if="isEdit && guests[index]['isDeleted']">
                    <button
                      type="button"
                      class="cursor-not-allowed btn btn-danger text-white px-4 py-2 rounded"
                      readonly
                      disabled
                    >
                      Removed
                    </button>
                  </div>
                  <div class="mr-4" v-else>
                    <button
                      type="button"
                      class="btn btn-danger text-white px-4 py-2 rounded remove-guest-member"
                      @click="removeGuest(index)"
                    >
                      Remove
                    </button>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-1 gap-7">
                <button
                  type="button"
                  id="addGuest"
                  @click="addGuest"
                  class="btn inline-flex justify-center btn-secondary my-4 w-min"
                >
                  Add Guest
                </button>
                <button
                  type="button"
                  class="btn inline-flex justify-center btn-dark mt-2 w-full"
                  @click="submitForm"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- </form> -->
  </div>
</template>
<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import VueMultiselect from "vue-multiselect";
export default {
  components: { VueDatePicker, VueMultiselect },
  props: [
    "mainTicket",
    "mainGuests",
    "types",
    "locations",
    "categories",
    "termsAndConditions",
    "guestConditions",
    "isEdit",
  ],
  data() {
    return {
      formItems: {
        "Ticket Configuration": [
          {
            html: "input",
            name: "name",
            label: "Name",
            type: "text",
            placeholder: "Name",
            required: true,
            readOnly: false,
          },
          {
            html: "input",
            name: "display_name",
            label: "Display Name",
            type: "text",
            placeholder: "Display Name",
            required: true,
            readOnly: false,
          },
          {
            html: "select",
            name: "status",
            label: "Status",
            options: [
              { id: 0, name: "In-Active" },
              { id: 1, name: "Active" },
            ],
            placeholder: "Select Status",
            required: true,
            readOnly: false,
          },
          {
            html: "select",
            name: "type",
            label: "Type",
            options: this.types,
            placeholder: "Select Type",
            required: true,
            readOnly: false,
          },
          {
            html: "select",
            name: "pass_type",
            label: "Pass Type",
            options: [
              { id: 1, name: "All Day" },
              { id: 2, name: "Time Base" },
            ],
            placeholder: "Select Pass Type",
            required: true,
            readOnly: false,
          },
          {
            html: "select",
            name: "location_id",
            label: "Location",
            options: this.locations,
            placeholder: "Select Location",
            required: true,
            readOnly: false,
          },
          {
            html: "multi-select",
            name: "category_ids",
            label: "Category",
            options: [],
            placeholder: "Select Category",
            required: true,
            readOnly: false,
          },
          {
            html: "range-datepicker",
            name: "ticket_pricing_range",
            label: "Ticket Expiry",
            type: "dateTime",
            placeholder: "Start Date - End Date",
            required: true,
            readOnly: false,
          },
          {
            html: "time-picker",
            name: "play_time",
            label: "Play Hours",
            type: "time",
            placeholder: "Time",
            required: true,
            readOnly: false,
          },
          {
            html: "input",
            name: "play_time_till_close",
            label: "Till Close",
            type: "checkbox",
            placeholder: "Till Close",
            required: false,
            readOnly: false,
          },
          {
            html: "textarea",
            name: "description",
            label: "Description",
            type: "text",
            placeholder: "Description",
            required: false,
            readOnly: false,
          },
          {
            html: "textarea",
            name: "display_description",
            label: "Display Description",
            type: "text",
            placeholder: "Description",
            required: false,
            readOnly: false,
          },
        ],
        "Pricing & Payments": [
          {
            html: "input",
            name: "weekend_price",
            label: "Weekend Price",
            type: "number",
            placeholder: "Price",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "weekday_price",
            label: "Weekday Price",
            type: "number",
            placeholder: "Price",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "advance_payment",
            label: "Advance Payment/Depsoit",
            type: "number",
            placeholder: "Amount",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "tax",
            label: "Tax %",
            type: "number",
            placeholder: "Tax Percentage",
            required: false,
            readOnly: false,
          },
        ],
        "Additional Configuration": [
          {
            html: "input",
            name: "btn_img",
            label: "Button Image",
            type: "image",
            placeholder: "Button Image",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "max_sale_per_order",
            label: "Max Sale Per Order",
            type: "number",
            placeholder: "Max",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "min_sale_per_order",
            label: "Min Sale Per Order",
            type: "number",
            placeholder: "Min",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "pos",
            label: "POS",
            type: "checkbox",
            placeholder: "POS",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "one_bill_per_item",
            label: "One Bill per Item",
            type: "checkbox",
            placeholder: "",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "sell_and_register_customer",
            label: "Sell & Register Customer",
            type: "checkbox",
            placeholder: "",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "order_locked",
            label: "Order Lock after Full Price",
            type: "checkbox",
            placeholder: "",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "custom_price",
            label: "Allow Custom Price",
            type: "checkbox",
            placeholder: "Custom Price",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "print_as_ticket",
            label: "Print as Ticket",
            type: "checkbox",
            placeholder: "Print as Ticket",
            required: false,
            readOnly: false,
          },
          {
            html: "input",
            name: "print_tc_on_ticket",
            label: "Print Terms & Condition on Ticket",
            type: "checkbox",
            placeholder: "Print Terms & Condition on Ticket",
            required: false,
            readOnly: false,
          },
          {
            html: "textarea",
            name: "tc_on_ticket_description",
            label: "Description on terms and condition for Ticket",
            type: "text",
            placeholder: "Description",
            required: false,
            readOnly: false,
          },
        ],
        "Terms & Conditions": [
          {
            html: "select",
            name: "term_and_condition_id",
            label: "Term And Condition",
            options: [],
            placeholder: "Select Term and Condition",
            required: false,
            readOnly: false,
          },
        ],
      },
      ticket: this.mainTicket ?? [],
      guestsHtml: [],
      guests: this.mainGuests ?? [],
      guestsCount: this.mainGuests ? this.mainGuests.length : 0,
      errors: {},
      // ... Other data properties ...
    };
  },
  mounted() {
    const startDate = this.ticket["start_date_time"]
      ? new Date(this.ticket["start_date_time"])
      : new Date();
    const endDate = this.ticket["end_date_time"]
      ? new Date(this.ticket["end_date_time"])
      : new Date(new Date().setDate(startDate.getDate() + 7));
    this.ticket["play_time"] = this.ticket["play_time"] ?? {
      hours: 5,
      minutes: 59,
      seconds: 0,
    };
    this.ticket["status"] = this.ticket["status"] ?? 1;
    this.ticket["pass_type"] =
      this.ticket["play_time"] &&
      this.ticket["play_time"]?.hours != 5 &&
      this.ticket["play_time"]?.minutes != 59
        ? 2
        : 1;
    this.ticket["ticket_pricing_range"] = [];
    this.ticket["ticket_pricing_range"].push(startDate, endDate);
    for (let [key, items] of Object.entries(this.formItems)) {
      for (let item of items) {
        if (
          item.html == "input" &&
          item.type == "checkbox" &&
          this.ticket[item.name]
        )
          this.ticket[item.name] =
            this.ticket[item.name] == 1 || this.ticket[item.name] == "1"
              ? true
              : false;
        if (item.html == "select" && this.ticket[item.name] == "undefined")
          this.ticket[item.name] = "";
        if (item.html == "select" && item.name == "type") {
          if (this.ticket["weekday_price"] && !this.ticket["weekend_price"])
            this.ticket[item.name] = 3;
          else if (
            this.ticket["weekend_price"] &&
            !this.ticket["weekday_price"]
          )
            this.ticket[item.name] = 2;
          else this.ticket[item.name] = 1;
        }
      }
    }
    if (this.guestsCount > 0) {
      for (let i = 0; i < this.guestsCount; i++) {
        let guest_count_html = i + 1;
        this.guests[i]["guest_index"] = guest_count_html;
        this.guestsHtml.push({
          items: [
            {
              html: "input",
              name: "guest_age_from",
              label: "Guest Age From",
              type: "number",
              placeholder: "Age",
              required: true,
              readOnly: false,
            },
            {
              html: "select",
              name: "guest_condition",
              label: "Guest Condition",
              options: this.guestConditions ?? [],
              placeholder: "Select Guest Condition",
              required: true,
              readOnly: false,
            },
            {
              html: "input",
              name: "guest_age_to",
              label: "Guest Age To",
              type: "number",
              placeholder: "Age",
              required: true,
              readOnly: false,
            },
            {
              html: "input",
              name: "allowed_guests",
              label: "Allowed Guests",
              type: "number",
              placeholder: "No. of Guests",
              required: true,
              readOnly: false,
            },
          ],
          guest_index: guest_count_html,
        });
      }
    }
  },
  computed: {
    ticketFormItems: function () {
      let pricingInputFields = ["weekend_price", "weekday_price"];

      // form pricing type and location base category or terms & condition
      let pricingType = this.ticket["type"]
        ? this.types.find((type) => {
            return type.id == this.ticket["type"];
          })
        : { id: 1, name: "Both" };
      let locationCategories = this.ticket["location_id"]
        ? this.categories.filter((category) => {
            return category.location_id == this.ticket["location_id"];
          })
        : [];
      let locationTc = this.ticket["location_id"]
        ? this.termsAndConditions.filter((termAndCondition) => {
            return termAndCondition.location_id == this.ticket["location_id"];
          })
        : [];

      let ticketFormItems = {};
      for (let [key, items] of Object.entries(this.formItems)) {
        let subTicketFormItems = [];
        for (let item of items) {
          if (item.name == "category_ids") item.options = locationCategories;
          if (item.name == "term_and_condition_id") item.options = locationTc;
          if (
            item.name == "tc_on_ticket_description" &&
            !this.ticket["print_tc_on_ticket"]
          )
            continue;
          if (item.name == "play_time" && this.ticket["play_time_till_close"])
            item.readOnly = true;
          else item.readOnly = false;
          if (
            item.name == "play_time_till_close" &&
            this.ticket["pass_type"] &&
            this.ticket["pass_type"] == 2
          )
            continue;
          if (
            pricingInputFields.includes(item.name) &&
            this.ticket["type"] &&
            pricingType.name.toLowerCase() != "both" &&
            !item.name.startsWith(pricingType.name.toLowerCase())
          )
            continue;
          // if(this.isEdit && (item.name == 'location_id' && this.ticket['location_id']))
          //     item.readOnly = true;

          subTicketFormItems.push(item);
        }
        ticketFormItems[key] = subTicketFormItems;
      }
      return ticketFormItems;
    },
  },
  methods: {
    accordionToggle(panel) {
      if (panel) $("#" + panel).slideToggle("slow");
    },
    isNumber: function (evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    addGuest() {
      this.guestsCount++;
      this.guests.push({ guest_index: this.guestsCount });
      this.guestsHtml.push({
        items: [
          {
            html: "input",
            name: "guest_age_from",
            label: "Guest Age From",
            type: "number",
            placeholder: "Age",
            required: true,
            readOnly: false,
          },
          {
            html: "select",
            name: "guest_condition",
            label: "Guest Condition",
            options: this.guestConditions ?? [],
            placeholder: "Select Guest Condition",
            required: true,
            readOnly: false,
          },
          {
            html: "input",
            name: "guest_age_to",
            label: "Guest Age To",
            type: "number",
            placeholder: "Age",
            required: true,
            readOnly: false,
          },
          {
            html: "input",
            name: "allowed_guests",
            label: "Allowed Guests",
            type: "number",
            placeholder: "No. of Guests",
            required: true,
            readOnly: false,
          },
        ],
        guest_index: this.guestsCount,
      });
    },
    removeGuest(index) {
      if (
        this.isEdit &&
        Object.keys(this.guests[index]).indexOf("guest_id") != "-1"
      ) {
        this.guests[index]["isDeleted"] = 1;
        this.guestsHtml[index]["items"] = this.guestsHtml[index]["items"].map(
          (item) => {
            item.readOnly = true;
            return item;
          }
        );
      } else {
        this.guests.splice(index, 1);
        this.guestsHtml.splice(index, 1);
      }
    },
    removeImage() {
      $("#btn_img").val("");
      this.ticket["btn_img"] = null;
    },
    storeImage(e) {
      try {
        var file = e.target.files[0];
        var reader = new FileReader();
        reader.addEventListener(
          "load",
          () => {
            this.ticket["btn_img"] = reader.result;
          },
          false
        );
        reader.readAsDataURL(file);
      } catch (e) {
        console.log(e);
      }
    },
    validateForm() {
      for (let [key, items] of Object.entries(this.ticketFormItems)) {
        for (let item of items) {
          if (
            item.required &&
            (!(item.name in this.ticket) ||
              this.ticket[item.name] == "undefined" ||
              this.ticket[item.name]?.length == 0)
          )
            this.errors[item.name] = "The " + item.label + " is required";
          else if (
            item.name != "btn_img" &&
            this.ticket[item.name]?.length > 255
          )
            this.errors[item.name] =
              item.label + " must not exceed than 255 character";
        }
      }

      for (let [index, guestHtml] of this.guestsHtml.entries()) {
        for (let item of guestHtml.items) {
          let errorId = "guests." + index + "." + item.name;
          if (
            item.required &&
            (!(item.name in this.guests[index]) ||
              this.guests[index][item.name] == "undefined" ||
              this.guests[index][item.name]?.length == 0)
          )
            this.errors[errorId] = "The " + item.label + " is required";
        }
        if (
          this.guests[index]["guest_age_to"] &&
          this.guests[index]["guest_age_from"] &&
          this.guests[index]["guest_condition"]
        ) {
          let condition = this.guestConditions
            ? this.guestConditions.find((condition) => {
                return condition.id == this.guests[index]["guest_condition"];
              })
            : ">=";
          if (
            eval(
              this.guests[index]["guest_age_from"] +
                " " +
                (condition ? condition.symbol : ">=") +
                " " +
                this.guests[index]["guest_age_to"]
            )
          )
            this.errors["guests." + index + ".guest_age_to"] =
              "Guest age to must be " +
              (condition ? condition.name : "greater than and equal to") +
              " " +
              this.guests[index]["guest_age_from"];
        }
      }

      if (Object.keys(this.errors).length > 0) return true;

      if (this.ticket["ticket_pricing_range"]) {
        this.ticket["start_date_time"] =
          this.ticket["ticket_pricing_range"][0].getFullYear() +
          "-" +
          (this.ticket["ticket_pricing_range"][0].getMonth() + 1) +
          "-" +
          this.ticket["ticket_pricing_range"][0].getDate() +
          " " +
          this.ticket["ticket_pricing_range"][0].toLocaleTimeString("it-IT");
        this.ticket["end_date_time"] =
          this.ticket["ticket_pricing_range"][1].getFullYear() +
          "-" +
          (this.ticket["ticket_pricing_range"][1].getMonth() + 1) +
          "-" +
          this.ticket["ticket_pricing_range"][1].getDate() +
          " " +
          this.ticket["ticket_pricing_range"][1].toLocaleTimeString("it-IT");
      }
      if (this.ticket["type"] && this.ticket["type"] != 1) {
        let pricingType = this.types.find((type) => {
          return type.id != this.ticket["type"] && type.id != 1;
        });
        if (!this.isEdit)
          delete this.ticket[pricingType.name.toLowerCase() + "_price"];
        else this.ticket[pricingType.name.toLowerCase() + "_price"] = null;
      }
      return false;
    },
    async submitForm() {
      let imageUrl = window.location.origin + "/images/funvilla.png";
      $.LoadingOverlay("show", {
        image: imageUrl,
        imageAnimation: "1.5s fadein",
      });
      this.errors = {};
      try {
        let validate = this.validateForm();
        this.ticket["add_guests"] = this.guests.length > 0 ? true : false;
        if (!validate) {
          let form = Object.assign({}, this.ticket);
          form["guests"] = this.guests;
          let method = "post";
          let url = `/tickets`;
          if (!this.isEdit) {
          } else {
            method = "put";
            url = `/tickets/${this.ticket["id"]}`;
          }
          await axios({ method: method, url: url, data: form })
            .then((response) => {
              if (response.data.status) {
                window.location.href = "/" + response.data.href;
              }
            })
            .catch((error) => {
              const statusCode = error.response?.status;
              const errorsList = error.response?.data?.errors;
              if (statusCode == 422 && errorsList) {
                this.errors = errorsList;
              }
              $.LoadingOverlay("hide");
            });
        }
        if (Object.keys(this.errors).length > 0) {
          let errorString = "#" + Object.keys(this.errors)[0];
          if (errorString.startsWith("guests", 1))
            errorString = errorString.replaceAll(".", "_");
          let position = $(errorString).offset()?.top - 105;
          $("html, body").animate(
            {
              scrollTop: position,
            },
            600
          );
        }
      } catch (e) {
        console.log(e);
      }

      $.LoadingOverlay("hide");
    },
  },
  watch: {
    "ticket.location_id"(val) {
      if (val) {
        let locationCategories = this.categories.filter((category) => {
          return category.location_id == val;
        });
        let locationTc = this.termsAndConditions.filter((termAndCondition) => {
          return termAndCondition.location_id == val;
        });

        if (
          !locationCategories.some((el) =>
            this.ticket["category_ids"]?.includes(el)
          )
        )
          this.ticket["category_ids"] = [];

        if (
          !locationTc.some(
            (el) => el.id === this.ticket["term_and_condition_id"]
          )
        )
          this.ticket["term_and_condition_id"] = "";
      }
    },
    // 'ticket.type'(val){
    //     if(val && val != 1){
    //         let pricingType = this.types.find((type) => {return type.id != val && type.id != 1});
    //         delete this.ticket[pricingType.name.toLowerCase()+'_price'];
    //     }
    // },
    "ticket.print_tc_on_ticket"(val) {
      if (!val) {
        if (!this.isEdit) delete this.ticket["tc_on_ticket_description"];
        else this.ticket["tc_on_ticket_description"] = null;
      }
    },
    "ticket.play_time_till_close"(val) {
      if (val) this.ticket["play_time"] = { hours: 5, minutes: 59, seconds: 0 };
    },
    "ticket.pass_type"(val) {
      // if(val && val == 1)
      //     this.ticket['play_time'] = {hours: 5, minutes: 59, seconds: 0};
      // else if(!this.isEdit && val)
      //     delete this.ticket['play_time'];

      if (val && val == 2) {
        if (!this.isEdit) delete this.ticket["play_time_till_close"];
        else this.ticket["play_time_till_close"] = false;
      }
    },
  },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style scoped>
/* Add your component-specific styles here */
.accordion-display {
  display: none;
}
</style>
