<template>
  <div id="create-camp" class="mt-3">
    <div>
      <div>
        <div class="">
          <div class="">
            <form class="space-y-4" @submit.prevent="submitForm">
              <div class="row">
                <div
                  v-for="(item, index) in customerFormItems"
                  :class="item.grid"
                >
                  <div class="input-area relative" v-if="item.html !== 'title'">
                    <label
                      :for="item.name"
                      class="form-label mt-3"
                      style="font-size: 13px; font-weight: 500"
                    >
                      <span v-html="item.label"></span>
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
                <div v-if="wavierForFamilyMember">
                  <camp-medication
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
                  ></camp-medication>
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
import CampMedication from "@/components/CampMedication.vue";
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
    CampMedication,
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
          grid: "col-md-12",
          placeholder: "Camper Information",
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
          name: "first_name",
          label: "First Name",
          type: "text",
          grid: "col-md-4",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "middle_name",
          label: "Middle Name",
          type: "text",
          grid: "col-md-4",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "last_name",
          label: "Last Name",
          type: "text",
          grid: "col-md-4",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "select",
          name: "attending_camp",
          label: "How often will the camper be attending camp?",
          options: this.years,
          grid: "col-md-4",
          placeholder: "Select One",
          required: true,
          readOnly: false,
        },
        {
          html: "select",
          name: "camp_week",
          grid: "col-md-4",
          label: "Week of camping?",
          options: this.years,
          placeholder: "Select One",
          required: true,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          grid: "col-md-12",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "health_card",
          label: "Health Card Number",
          type: "text",
          grid: "col-md-4",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "dob",
          label: "Date of Birth",
          grid: "col-md-4",
          type: "date",
          placeholder: "",
          required: true,
          readOnly: false,
        },

        {
          html: "input",
          name: "address",
          label: "Home Address",
          type: "text",
          grid: "col-md-12",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          grid: "col-md-12",
          placeholder: "Contact Information",
          required: false,
          readOnly: false,
        },

        {
          html: "input",
          name: "guardian",
          label: "Parent/Guardian",
          type: "text",
          grid: "col-md-4",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "camper_relationship",
          label: "Relationship to camper",
          type: "text",
          grid: "col-md-4",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "home_phone",
          label: "Home Phone",
          grid: "col-md-4",
          type: "tel",
          placeholder: "",
          required: true,
          readOnly: false,
        },
        {
          html: "input",
          name: "address",
          label: "Address",
          type: "text",
          placeholder: "",
          grid: "col-md-12",
          required: false,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          grid: "col-md-12",
          type: "",
          placeholder: "Additional Information",
          required: false,
          readOnly: false,
        },
        {
          html: "select",
          name: "special_needs",
          label: "Does your child have special needs?",
          options: this.accountTypes,
          grid: "col-md-6",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          grid: "col-md-12",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "textarea",
          name: "describe_needs",
          label:
            "Please describe the special needs we should be aware of as we prepare for your camper",
          type: "text",
          grid: "col-md-6",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "title",
          name: "",
          label: "",
          type: "",
          grid: "col-md-12",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "textarea",
          name: "health_concerns",
          label:
            "Health Concerns (diet/allergies/chronic conditions/considerations we should be aware of as we prepare for your camper)",
          type: "text",
          grid: "col-md-6",
          placeholder: "",
          required: true,
          readOnly: false,
        },

        {
          html: "textarea",
          name: "heard_about_us",
          label:
            "If your Camper has had any other operations or serious injuries please explain <br> <br>",
          type: "text",
          grid: "col-md-6",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "textarea",
          name: "describe_needs",
          label:
            "<b>Please note:</b> To care for your child to the best of our ability, please describe any other physical, emotional or behavioral problems",
          type: "text",
          grid: "col-md-6",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "select",
          name: "special_needs",
          label:
            "Has your child been exposed to or suffered from any infectious disease during the three weeks prior to the first day of camp? For example: Measles, Chicken Pox, Mumps, Tuberculosis, Whooping Cough, H1N1, Mononucleosis, etc. If yes, please call the Camp Director before coming to camp.*",
          options: this.accountTypes,
          grid: "col-md-6",
          placeholder: "",
          required: false,
          readOnly: false,
        },
        {
          html: "input",
          name: "address",
          label: "Date of last immunizations <br><br>",
          type: "date",
          placeholder: "",
          grid: "col-md-4",
          required: false,
          readOnly: false,
        },
        {
          html: "select",
          name: "special_needs",
          label:
            "Does your camper receive any medication? (if yes, please explain below)",
          options: this.accountTypes,
          grid: "col-md-4",
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
      waiverForm: true,
      termsAndConditionFlag: true,
      customerRemarks: "",
      wavierForFamilyMember: true,
      familyMemberCount: 0,
      termsAndCondition: "I agree.....",
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
        this.termsAndCondition = defaultTC ? defaultTC.text : "I agree .....";
      }
    },
  },
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
