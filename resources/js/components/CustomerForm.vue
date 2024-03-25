<template>
  <div id="create-customer" class="mt-3">
    <div>
      <div>
        <div class="">
          <div class="">
            <div
              class="space-y-4 card"
              style="padding: 3rem 3rem"
              v-show="!waiverForm"
            >
              <div class="card-body p-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mt-3">
                      <h6 class="section-title-h6 text-center">
                        Need your Email Address to start
                      </h6>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="input-area relative"></div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-area relative mt-4">
                      <label for="turning" class="form-label label-text"
                        ><span>Email</span>
                      </label>
                      <div>
                        <input
                          type="email"
                          name="checkemail"
                          v-model="checkemail"
                          id="checkemail"
                          class="form-control"
                          placeholder=""
                        />
                      </div>
                      <p
                        class="text-danger text-sm text-center mb-0"
                        v-show="checkemailError"
                      >
                        {{ checkemailError }}
                      </p>
                    </div>
                    <a
                      href="javascript:void(0)"
                      class="custom-button mt-4"
                      @click="inputverification"
                      ><span class="circle" aria-hidden="true"
                        ><span class="icon arrow"></span></span
                      ><span class="button-text">Confirm & Continue</span></a
                    >
                  </div>
                </div>
              </div>
            </div>
            <form
              class="space-y-4"
              @submit.prevent="submitForm"
              v-show="waiverForm"
            >
              <div class="row">
                <div
                  v-for="(item, index) in customerFormItems"
                  :class="{
                    'col-md-12': item.html === 'title',
                    'col-md-4': item.html !== 'title',
                  }"
                >
                  <div class="input-area relative" v-if="item.html !== 'title'">
                    <label
                      :for="item.name"
                      class="form-label mt-3"
                      style="font-size: 13px; font-weight: 500"
                    >
                      <span>{{ item.label }}</span>
                      <span v-if="item.required" class="text-danger"> * </span>
                    </label>
                    <div v-if="item.html == 'select'">
                      <select
                        :class="item.readOnly ? 'cursor-not-allowed' : ''"
                        :name="item.name"
                        :id="item.name"
                        v-model="customer[item.name]"
                        class="form-select"
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
                          {{ option.name }}
                        </option>
                      </select>
                    </div>
                    <div v-else-if="item.html == 'textarea'">
                      <textarea
                        :name="item.name"
                        :id="item.name"
                        v-model="customer[item.name]"
                        class="form-control resize-none"
                        :placeholder="item.placeholder"
                        rows="4"
                        :readonly="item.readOnly"
                      ></textarea>
                    </div>
                    <div v-else>
                      <input
                        :type="item.type"
                        :name="item.name"
                        :id="item.name"
                        v-model="customer[item.name]"
                        class="form-control"
                        :placeholder="item.placeholder"
                        :readonly="item.readOnly"
                      />
                    </div>
                    <div v-if="Object.keys(errors).indexOf(item.name) != '-1'">
                      <span class="mt-4 text-danger" style="font-size: 11px">{{
                        Array.isArray(errors[item.name])
                          ? errors[item.name][0]
                          : errors[item.name]
                      }}</span>
                    </div>
                  </div>
                  <div v-if="item.html === 'title'" class="mt-3">
                    <h6 class="section-title-h6">{{ item.placeholder }}</h6>
                  </div>
                </div>
              </div>
              <div class="mt-2 mb-2">
                <span
                  class="text-sm font-bold dark:text-white mt-4 mb-4 section-title-h6"
                >
                  PLEASE READ THE FOLLOWING INFORMATION AND AGREE TO TERMS AND
                  CONDITIONS
                </span>

                <terms-conditions></terms-conditions>
                <div class="flex dark:text-white mt-4 mb-4">
                  <input
                    id="terms-and-condition-checkbox"
                    type="checkbox"
                    v-model="termsAndConditionFlag"
                    class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="terms-and-condition-checkbox"
                    style="max-height: 10rem"
                    class="overflow-y-auto ml-2 mt-4 text-sm font-medium text-gray-900 dark:text-gray-300"
                    v-html="termsAndCondition"
                  ></label>
                </div>
                <div
                  v-if="
                    Object.keys(isEdit ? editError : errors).indexOf(
                      'termsAndConditionFlag'
                    ) != '-1'
                  "
                >
                  <div class="mt-4 text-center font-bold text-red-600">
                    {{
                      Array.isArray(
                        isEdit
                          ? editError["termsAndConditionFlag"]
                          : errors["termsAndConditionFlag"]
                      )
                        ? isEdit
                          ? editError["termsAndConditionFlag"][0]
                          : errors["termsAndConditionFlag"][0]
                        : isEdit
                        ? editError["termsAndConditionFlag"]
                        : errors["termsAndConditionFlag"]
                    }}
                  </div>
                </div>
              </div>

              <div v-if="termsAndConditionFlag">
                <div class="mt-2 mb-2">
                  <span class="text-sm text-red-600 font-bold section-title-h6"
                    >ALL ADULTS, CHILDREN AND KIDS ARE REQUIRED TO BE ADDED IN
                    THE WAIVER</span
                  >
                </div>
                <div class="flex items-center dark:text-white mt-4 mb-4">
                  <input
                    id="signing-wavier-checkbox"
                    type="checkbox"
                    v-model="wavierForFamilyMember"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="signing-wavier-checkbox"
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >Signing Waiver</label
                  >
                </div>

                <div v-if="wavierForFamilyMember">
                  <family-member-form
                    :months="this.months"
                    :years="this.years"
                    :customerFamilyMembers="familyMembers"
                    :totalMember="familyMemberCount"
                    :termsAndCondition="termsAndCondition"
                    :errors="errors"
                    :isEdit="false"
                    :customer="customer"
                    :custWavierRemarks="[]"
                    ref="familyMemberWavier"
                  ></family-member-form>
                </div>
                <div
                  class="flex items-center dark:text-white mt-4 mb-4"
                  v-if="termsAndConditionFlag"
                >
                  <input
                    id="subscription-news-checkbox"
                    type="checkbox"
                    v-model="customer.news_subscription"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label
                    for="subscription-news-checkbox"
                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                    >I want to receive emails and newsletter</label
                  >
                </div>
              </div>
              <div v-if="termsAndConditionFlag">
                <button
                  type="submit"
                  class="btn inline-flex justify-center btn-dark mt-4 w-full"
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
import FamilyMemberForm from "@/components/FamilyMemberForm.vue";
import TermsConditions from "@/components/TermsConditions.vue";

export default {
  props: [
    "months",
    "years",
    "locations",
    "accountTypes",
    "defaultTermsAndConditions",
    "mainCustomer",
    "isEdit",
    "submitVia",
  ],
  components: {
    FamilyMemberForm,
    TermsConditions,
  },
  data() {
    return {
      formItems: [
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          placeholder: "Basic Information",
          required: false,
          readOnly: false,
        },

        {
          html: "input",
          name: "first_name",
          label: "First Name",
          type: "text",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "last_name",
          label: "Last Name",
          type: "text",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "email",
          label: "Email",
          type: "email",
          placeholder: "",
          required: true,
          readOnly: true,
        },
        {
          html: "input",
          name: "phone",
          label: "Phone",
          type: "text",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "select",
          name: "month_dob",
          label: "Date of Birth (Month)",
          options: this.months,
          placeholder: "Select Month",
          required: true,
          readOnly: false,
        },
        {
          html: "select",
          name: "year_dob",
          label: "Date of Birth (Year)",
          options: this.years,
          placeholder: "Select Year",
          required: true,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          placeholder: "Adress Information",
          required: false,
          readOnly: false,
        },

        {
          html: "input",
          name: "state",
          label: "State",
          type: "text",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "city",
          label: "City",
          type: "text",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "postal_code",
          label: "Postal Code",
          type: "text",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "address",
          label: "Address",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          placeholder: "We would like to know",
          required: false,
          readOnly: false,
        },
        {
          html: "select",
          name: "account_type_id",
          label: "Account Type",
          options: this.accountTypes,
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "organisation_name",
          label: "Organisation Name",
          type: "text",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "select",
          name: "location_id",
          label: "Location",
          options: this.locations,
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "heard_about_us",
          label: "How you Heard about us",
          type: "text",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          placeholder: "Password for a new account",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "password",
          label: "Password",
          type: "password",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "password_confirmation",
          label: "Confirm Password",
          type: "password",
          placeholder: "",
          required: true,
          readOnly: false,
        },
      ],
      customer: this.mainCustomer ?? [],
      familyMembers: [],
      errors: {},
      checkemail: null,
      checkemailError: null,
      waiverForm: false,
      termsAndConditionFlag: false,
      customerRemarks: "",
      wavierForFamilyMember: false,
      familyMemberCount: 0,
      termsAndCondition: "I agree with terms and condition.",
      // ... Other data properties ...
    };
  },
  computed: {
    customerFormItems: function () {
      let customerFormItems = [];
      for (let item of this.formItems) {
        if (
          this.isEdit &&
          (item.name == "password" || item.name == "password_confirmation")
        )
          continue;
        if (item.html == "select" && item.options.length < 1) continue;
        if (
          item.name == "organisation_name" &&
          this.customer["account_type_id"] == "1"
        )
          continue;
        if (
          this.isEdit &&
          (item.name == "account_type_id" ||
            (item.name == "location_id" && this.customer["location_id"]))
        )
          item.readOnly = true;
        customerFormItems.push(item);
      }
      return customerFormItems;
    },
  },
  methods: {
    isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    },
    inputverification() {
      if (this.checkemail && this.isValidEmail(this.checkemail)) {
        // If the email is not empty and is a valid email
        this.checkemailError = null;
        this.emailExists();
      } else {
        this.checkemailError = "please provide valid email";
        setTimeout(() => (this.checkemailError = null), 3000);
      }
    },
    async emailExists() {
      //
      try {
        let imageUrl = window.location.origin + "/images/funvilla.png";
        $.LoadingOverlay("show", {
          image: imageUrl,
          imageAnimation: "1.5s fadein",
        });

        const response = await axios.post(`/api/check-customer-email`, {
          email: this.checkemail,
        });

        if (response.data === "not exists") {
          this.waiverForm = true;
          this.customer["email"] = this.checkemail;
        } else {
          this.checkemailError = "Email Already Exists";
          setTimeout(() => (this.checkemailError = null), 4000);
        }

        $.LoadingOverlay("hide");
      } catch (error) {
        console.log(error);
      }
    },

    validateForm() {
      if (this.customer["month_dob"] && this.customer["year_dob"]) {
        let currDate = new Date();
        let presentDate = new Date(
          this.customer["year_dob"],
          this.customer["month_dob"],
          0
        );
        let age = Math.floor((currDate - presentDate) / 31557600000);
        if (age < 18) this.errors["year_dob"] = "Age must be greater than 18";
        else
          this.customer["dob"] =
            presentDate.getFullYear() +
            "-" +
            (presentDate.getMonth() + 1) +
            "-" +
            presentDate.getDate();
      }
      for (let item of this.customerFormItems) {
        if (
          item.required &&
          (!(item.name in this.customer) ||
            this.customer[item.name]?.length == 0)
        )
          this.errors[item.name] = "The " + item.label + " is required";
        else if (this.customer[item.name]?.length > 255)
          this.errors[item.name] =
            item.label + " must not exceed than 255 character";
        else if (
          item.name == "password" ||
          item.name == "password_confirmation"
        ) {
          if (this.customer[item]?.length < 8)
            this.errors[item.name] =
              item.label + " length should be greater than 8 characters";
          else if (
            this.customer["password"]?.length > 0 &&
            this.customer["password_confirmation"]?.length > 0 &&
            this.customer["password"] != this.customer["password_confirmation"]
          )
            this.errors["password_confirmation"] = "Password doesn't matched";
        }
      }
      // validating wavier after validate customer form
      if (this.wavierForFamilyMember && Object.keys(this.errors).length <= 0)
        this.errors = this.$refs.familyMemberWavier.validateForm();

      if (Object.keys(this.errors).length > 0) return true;
      return false;
    },
    async submitForm() {
      let imageUrl = window.location.origin + "/images/funvilla.png";
      $.LoadingOverlay("show", {
        image: imageUrl,
        imageAnimation: "1.5s fadein",
      });
      this.errors = {};
      // if (this.wavierForFamilyMember) {
      //   $.LoadingOverlay("hide");
      //   this.errors["termsAndConditionFlag"] =
      //     "*Please agree to terms and condition!";
      //   let position = $("#terms-and-condition-checkbox").offset()?.top - 105;
      //   $("html, body").animate(
      //     {
      //       scrollTop: position,
      //     },
      //     600
      //   );
      //   return;
      // }
      try {
        let validate = this.validateForm();
        if (!validate) {
          console.log(this.customer);
          let form = Object.assign({}, this.customer);
          let method = "post";
          let url = `/signup-waiver/store`;
          if (!this.isEdit) {
            form["signing_wavier_for_family_member"] =
              this.wavierForFamilyMember;
            if (this.wavierForFamilyMember) {
              // Update Family Member Data for type customer
              let custFamilyMemberIndex = this.familyMembers.findIndex(
                ({ type }) => type === "customer"
              );
              if (custFamilyMemberIndex != "-1") {
                this.familyMembers[custFamilyMemberIndex].family_first_name =
                  this.customer["first_name"];
                this.familyMembers[custFamilyMemberIndex].family_last_name =
                  this.customer["last_name"];
                this.familyMembers[custFamilyMemberIndex].family_dob =
                  this.customer["dob"];
              }
              form["family_members"] = this.familyMembers;
              form["family_member_count"] = this.familyMemberCount;
              form["waiver_via"] = this.submitVia;
            }
            form["terms_and_conditions"] = this.termsAndCondition;
            form["customer_remarks"] = this.customerRemarks;
          } else {
            method = "put";
            url = `/customers/${this.customer["id"]}`;
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
          if (errorString.startsWith("family_members", 1))
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
    wavierForFamilyMember() {
      this.familyMembers = [];
      this.familyMemberCount = 0;
      this.termsAndConditionFlag = true;
      //this.customerRemarks = "";
    },
    "customer.location_id"(val) {
      if (this.defaultTermsAndConditions) {
        let defaultTC = this.defaultTermsAndConditions.find(function (
          defaultTc
        ) {
          return defaultTc.location_id == val;
        });
        this.termsAndCondition = defaultTC
          ? defaultTC.text
          : 'I agree with <a href="javascript:;">terms and condition.</a>';
      }
    },
  },
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
