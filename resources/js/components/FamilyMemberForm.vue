<template>
  <div>
    <div v-for="(familyMember, index) in familyMemberHtml" class="mt-4 mb-4">
      <div
        v-if="
          !(
            this.isEdit &&
            Object.keys(familyMember).indexOf('isDeleted') != '-1' &&
            familyMember['isDeleted'] == 1
          )
        "
        id="familyMembers"
        :class="
          familyMember.type == 'adult'
            ? 'bg-gray-100 p-4 family-member rounded-lg'
            : 'bg-slate-100 p-4 family-member rounded-lg'
        "
      >
        <b> Add {{ familyMember.type }} Details </b>

        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div v-for="item in familyMember.inputFields" class="col-md-6">
                <div class="input-area relative">
                  <label
                    :for="
                      'family_members_' +
                      (!this.editWithCustomer ? index + 1 : index) +
                      '_' +
                      item.name
                    "
                    class="form-label"
                    style="font-size: 13px; font-weight: 500"
                  >
                    <span>{{ item.label }}</span>
                    <span v-if="item.required" class="text-red-600"> * </span>
                  </label>
                  <div v-if="item.html == 'select'">
                    <select
                      :name="
                        'family_members_' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '_' +
                        item.name
                      "
                      :id="
                        'family_members_' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '_' +
                        item.name
                      "
                      v-model="
                        familyMembers[
                          !this.editWithCustomer ? index + 1 : index
                        ][item.name]
                      "
                      class="form-select"
                      :disabled="item.readonly"
                      :readonly="item.readonly"
                    >
                      <option value="" selected disabled>
                        Select {{ item.label }}
                      </option>
                      <option v-for="option in item.options" :value="option.id">
                        {{ option.name }}
                      </option>
                    </select>
                  </div>
                  <div v-else-if="item.html == 'textarea'">
                    <textarea
                      :name="
                        'family_members_' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '_' +
                        item.name
                      "
                      :id="
                        'family_members_' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '_' +
                        item.name
                      "
                      v-model="
                        familyMembers[
                          !this.editWithCustomer ? index + 1 : index
                        ][item.name]
                      "
                      class="form-control resize-none"
                      :placeholder="item.placeholder"
                      rows="4"
                      :readonly="item.readonly"
                    ></textarea>
                  </div>
                  <div v-else>
                    <input
                      :type="item.type"
                      :name="
                        'family_members_' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '_' +
                        item.name
                      "
                      :id="
                        'family_members_' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '_' +
                        item.name
                      "
                      v-model="
                        familyMembers[
                          !this.editWithCustomer ? index + 1 : index
                        ][item.name]
                      "
                      class="form-control"
                      :placeholder="item.placeholder"
                      :readonly="item.readonly"
                    />
                  </div>
                </div>
                <div
                  v-if="
                    Object.keys(isEdit ? editError : errors).indexOf(
                      'family_members.' +
                        (!this.editWithCustomer ? index + 1 : index) +
                        '.' +
                        item.name
                    ) != '-1'
                  "
                >
                  <span class="mt-4 text-red-600">{{
                    Array.isArray(
                      isEdit
                        ? editError[
                            "family_members." +
                              (!this.editWithCustomer ? index + 1 : index) +
                              "." +
                              item.name
                          ]
                        : errors[
                            "family_members." +
                              (!this.editWithCustomer ? index + 1 : index) +
                              "." +
                              item.name
                          ]
                    )
                      ? isEdit
                        ? editError[
                            "family_members." +
                              (!this.editWithCustomer ? index + 1 : index) +
                              "." +
                              item.name
                          ][0]
                        : errors[
                            "family_members." +
                              (!this.editWithCustomer ? index + 1 : index) +
                              "." +
                              item.name
                          ][0]
                      : isEdit
                      ? editError[
                          "family_members." +
                            (!this.editWithCustomer ? index + 1 : index) +
                            "." +
                            item.name
                        ]
                      : errors[
                          "family_members." +
                            (!this.editWithCustomer ? index + 1 : index) +
                            "." +
                            item.name
                        ]
                  }}</span>
                </div>
              </div>
            </div>
            <div class="flex justify-start mt-4">
              <div class="mr-4" v-if="familyMember.removeAllowed">
                <button
                  type="button"
                  class="btn btn-danger text-white rounded remove-family-member"
                  @click="sweetAlertDelete(index, familyMember.type)"
                >
                  <i class="fas fa-trash text-secondary text-white"></i>
                </button>
              </div>
              <div class="mr-4" v-else>
                <button
                  type="button"
                  class="btn btn-dark text-white px-4 py-2 rounded edit-family-member"
                  @click="editFamilyMember(index, familyMember.type)"
                >
                  Edit
                </button>
              </div>
              <div
                class="ml-4"
                v-if="
                  isEdit &&
                  familyMember.isEdited &&
                  Object.keys(
                    familyMembers[!this.editWithCustomer ? index + 1 : index]
                  ).indexOf('family_id') != '-1'
                "
              >
                <button
                  type="button"
                  class="btn btn-dark text-white px-4 py-2 rounded edit-family-member"
                  @click="cancelFamilyMember(index, familyMember.type)"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
          <div class="col-md-6" v-if="familyMember.type == 'adult'">
            <div
              v-for="(wavierMember, wavierMemberIndex) in wavierSignatureHtml"
            >
              <div
                v-if="
                  wavierMember.type === 'adult' &&
                  wavierMember.familyMemberIndex ===
                    familyMember.familyMemberIndex
                "
              >
                <signing-wavier-form
                  :customer="customer"
                  :familyMembers="familyMembers"
                  :wavierMember="wavierMember"
                  :isEdit="isEdit"
                  :familyMemberHtml="familyMemberHtml"
                  :editError="editError"
                  :errors="errors"
                ></signing-wavier-form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <button
        type="button"
        id="addAdultFamilyMember"
        @click="addFamilyMember('adult')"
        class="btn col-md-3 justify-center btn-dark mt-4 mb-2 w-full"
      >
        Add Adult Member
      </button>
      <span class="col-md-2"></span>
      <button
        type="button"
        id="addInfantsFamilyMember"
        @click="addFamilyMember('infants')"
        class="btn col-md-3 justify-center btn-dark mt-4 mb-2 w-full"
      >
        Add Kid Member
      </button>
    </div>

    <div v-for="(wavierMember, index) in wavierSignatureHtml">
      <div v-if="wavierMember.type == 'customer'">
        <signing-wavier-form
          :customer="customer"
          :familyMembers="familyMembers"
          :wavierMember="wavierMember"
          :isEdit="isEdit"
          :familyMemberHtml="familyMemberHtml"
          :editError="editError"
          :errors="errors"
        ></signing-wavier-form>
      </div>
    </div>
    <!-- <div class="mt-2 mb-2">
      <span class="text-base font-bold dark:text-white mt-2 mb-2">
        Customer Remarks
      </span>
      <div v-if="this.custWavierRemarks.length > 0" class="border-2 mt-2 mb-2">
        <ul class="list-disc p-2 m-2">
          <li
            v-for="custWavierRemark in this.custWavierRemarks"
            class="text-sm"
          >
            {{ custWavierRemark.remarks }}
          </li>
        </ul>
      </div>
      <textarea
        id="customer_remarks"
        name="customer_remarks"
        v-model="customerRemarks"
        class="mt-4 mb-4 form-control"
        placeholder="Customer Remark"
        rows="6"
      ></textarea>
    </div> -->
    <div v-if="isEdit">
      <button
        @click="submitFamilyMemberForm"
        class="btn inline-flex justify-center btn-dark mt-4 w-full"
      >
        Submit
      </button>
    </div>
  </div>
</template>
<script>
import SigningWavierForm from "@/components/SigningWavierForm.vue";
export default {
  props: [
    "months",
    "years",
    "customerFamilyMembers",
    "totalMember",
    "termsAndCondition",
    "errors",
    "isEdit",
    "customer",
    "custWavierRemarks",
  ],
  components: {
    SigningWavierForm,
  },
  data() {
    return {
      familyMemberHtml: [],
      wavierSignatureHtml: [],
      familyMemberCount: this.totalMember,
      termsAndConditionFlag: true,
      customerRemarks: "",
      editError: {},
      familyMembers: this.customerFamilyMembers,
      editWithCustomer: false,
    };
  },
  mounted() {
    if (this.familyMemberCount > 0 && this.isEdit) {
      for (let i = 0; i < this.familyMemberCount; i++) {
        let familyMemberCountHtml = i + 1;
        let type = this.familyMembers[i]?.type;
        this.familyMembers[i]["familyMemberIndex"] = familyMemberCountHtml;
        if (type == "customer") {
          this.wavierSignatureHtml.push({
            familyMemberIndex: familyMemberCountHtml,
            type: type,
            removeAllowed: false,
            required: true,
          });
          this.editWithCustomer = false;
          this.familyMembers[i]["readOnly"] = false;
        } else {
          this.familyMembers[i]["readOnly"] = false; //(this.familyMembers[i]['readOnly'] == 0 || this.familyMembers[i]['readOnly'] == '0') ? false : true;
          let familyInputItems = [
            {
              html: "input",
              name: "family_first_name",
              label: "First Name",
              type: "text",
              placeholder: "",
              required: true,
              readonly: this.familyMembers[i]["readOnly"],
            },
            {
              html: "input",
              name: "family_last_name",
              label: "Last Name",
              type: "text",
              placeholder: "",
              required: true,
              readonly: this.familyMembers[i]["readOnly"],
            },
            {
              html: "select",
              name: "family_month_dob",
              label: "DOB Month",
              options: this.months,
              placeholder: "Select Month",
              required: true,
              readonly: this.familyMembers[i]["readOnly"],
            },
            {
              html: "select",
              name: "family_year_dob",
              label: "DOB Year",
              options: this.years,
              placeholder: "Select Year",
              required: true,
              readonly: this.familyMembers[i]["readOnly"],
            },
          ];
          this.familyMemberHtml.push({
            inputFields: familyInputItems,
            familyMemberIndex: familyMemberCountHtml,
            type: type,
            removeAllowed: !this.familyMembers[i]["readOnly"], //Object.keys(this.familyMembers).indexOf('readOnly_'+familyMemberCountHtml) != '-1' ? !this.familyMembers['readOnly_'+familyMemberCountHtml] : false
          });
        }
        if (
          !this.familyMembers[i]["readOnly"] &&
          (type == "adult" ||
            (this.editWithCustomer &&
              (type == "infants" || type == "customer") &&
              this.familyMemberHtml.filter(function (el) {
                return (
                  (el.type == "infants" || el.type == "customer") &&
                  el.removeAllowed == true
                );
              }).length < 2))
        )
          this.wavierSignatureHtml.push({
            familyMemberIndex: familyMemberCountHtml,
            type: type,
            removeAllowed: false,
            required: true,
          });
      }
    } else {
      this.wavierSignatureHtml.push({
        familyMemberIndex: this.familyMemberCount,
        type: "customer",
        removeAllowed: false,
        required: true,
      });
      this.familyMembers.push({
        family_first_name: this.customer["first_name"],
        family_last_name: this.customer["last_name"],
        family_month_dob: this.customer["month_dob"],
        family_year_dob: this.customer["year_dob"],
        type: "customer",
        familyMemberIndex: this.familyMemberCount,
      });
      this.editWithCustomer = false;
    }
  },
  methods: {
    addFamilyMember(type) {
      this.familyMemberCount++;
      let familyInputItems = [
        {
          html: "input",
          name: "family_first_name",
          label: "First Name",
          type: "text",
          placeholder: "",
          required: true,
          readonly: false,
        },
        {
          html: "input",
          name: "family_last_name",
          label: "Last Name",
          type: "text",
          placeholder: "",
          required: true,
          readonly: false,
        },
        {
          html: "select",
          name: "family_month_dob",
          label: "DOB Month",
          options: this.months,
          placeholder: "Select Month",
          required: true,
          readOnly: false,
        },
        {
          html: "select",
          name: "family_year_dob",
          label: "DOB Year",
          options: this.years,
          placeholder: "Select Year",
          required: true,
          readOnly: false,
        },
      ];
      this.familyMembers.push({
        type: type,
        familyMemberIndex: this.familyMemberCount,
      });
      this.familyMemberHtml.push({
        inputFields: familyInputItems,
        familyMemberIndex: this.familyMemberCount,
        type: type,
        removeAllowed: true,
      });

      if (
        type == "adult" ||
        (this.editWithCustomer &&
          (type == "infants" || type == "customer") &&
          this.familyMemberHtml.filter(function (el) {
            return (
              (el.type == "infants" || el.type == "customer") &&
              el.removeAllowed == true &&
              el.isDeleted != true
            );
          }).length < 2)
      )
        this.wavierSignatureHtml.push({
          familyMemberIndex: this.familyMemberCount,
          type: type,
          removeAllowed: true,
          required: true,
        });
    },
    removeFamilyMember(index, type) {
      let memberIndex = index; // To remove last index of family Members
      let wavierIndex =
        this.familyMembers[
          !this.editWithCustomer ? memberIndex + 1 : memberIndex
        ].familyMemberIndex;
      if (
        this.isEdit &&
        Object.keys(
          this.familyMembers[
            !this.editWithCustomer ? memberIndex + 1 : memberIndex
          ]
        ).indexOf("family_id") != "-1"
      )
        this.familyMemberHtml[memberIndex]["isDeleted"] = this.familyMembers[
          !this.editWithCustomer ? memberIndex + 1 : memberIndex
        ]["isDeleted"] = 1;
      else {
        this.familyMembers.splice(
          !this.editWithCustomer ? memberIndex + 1 : memberIndex,
          1
        );
        this.familyMemberHtml.splice(memberIndex, 1);
      }
      if (
        type == "adult" ||
        (this.editWithCustomer &&
          (type == "infants" || type == "customer") &&
          this.familyMemberHtml.filter(function (el) {
            return (
              (el.type == "infants" || el.type == "customer") &&
              el.removeAllowed == true &&
              el.isDeleted != true
            );
          }).length < 1)
      ) {
        let wavierSignatureIndex = this.wavierSignatureHtml.findIndex(
          ({ familyMemberIndex }) => familyMemberIndex === wavierIndex
        );
        this.wavierSignatureHtml.splice(wavierSignatureIndex, 1);
      }
    },
    editFamilyMember(index, type) {
      let memberIndex = index;
      this.familyMemberHtml[memberIndex].isEdited = true;
      this.familyMemberHtml[memberIndex].removeAllowed = true;
      this.familyMemberHtml[memberIndex].inputFields = this.familyMemberHtml[
        memberIndex
      ].inputFields.map((obj) => {
        return { ...obj, readonly: false };
      });
      this.familyMembers[
        !this.editWithCustomer ? memberIndex + 1 : memberIndex
      ].readOnly = false;
      if (
        type == "adult" ||
        (this.editWithCustomer &&
          (type == "infants" || type == "customer") &&
          this.familyMemberHtml.filter(function (el) {
            return (
              (el.type == "infants" || el.type == "customer") &&
              el.removeAllowed == true &&
              el.isDeleted != true
            );
          }).length < 2)
      )
        this.wavierSignatureHtml.push({
          familyMemberIndex:
            this.familyMemberHtml[memberIndex].familyMemberIndex,
          type: type,
          removeAllowed: true,
          required: true,
        });
    },
    cancelFamilyMember(index, type) {
      let memberIndex = index;
      this.familyMemberHtml[memberIndex].isEdited = false;
      this.familyMemberHtml[memberIndex].removeAllowed = false;
      this.familyMemberHtml[memberIndex].inputFields = this.familyMemberHtml[
        memberIndex
      ].inputFields.map((obj) => {
        return { ...obj, readonly: true };
      });
      this.familyMembers[
        !this.editWithCustomer ? memberIndex + 1 : memberIndex
      ].readOnly = true;
      if (
        type == "adult" ||
        (this.editWithCustomer &&
          (type == "infants" || type == "customer") &&
          this.familyMemberHtml.filter(function (el) {
            return (
              (el.type == "infants" || el.type == "customer") &&
              el.removeAllowed == true &&
              el.isDeleted != true
            );
          }).length < 1)
      ) {
        let wavierSignatureIndex = this.wavierSignatureHtml.findIndex(
          ({ familyMemberIndex }) =>
            familyMemberIndex ===
            this.familyMembers[
              !this.editWithCustomer ? memberIndex + 1 : memberIndex
            ].familyMemberIndex
        );
        this.wavierSignatureHtml.splice(wavierSignatureIndex, 1);
      }
    },
    validateForm() {
      this.editError = {};
      let familyMemberHtmlInputFields = this.familyMemberHtml.map(function (
        item
      ) {
        return item.inputFields;
      });
      for (let index in this.familyMembers) {
        if (this.familyMembers[index].readOnly) continue;
        if (
          this.familyMembers[index]["family_month_dob"] &&
          this.familyMembers[index]["family_year_dob"]
        ) {
          let errorId = "family_members." + index + ".family_year_dob";
          let currDate = new Date();
          let presentDate = new Date(
            this.familyMembers[index]["family_year_dob"],
            this.familyMembers[index]["family_month_dob"],
            0
          );
          let age = Math.floor((currDate - presentDate) / 31557600000);
          if (this.familyMembers[index]["type"] == "adult" && age < 18)
            this.editError[errorId] = "Age must be greater than 18";
          else if (this.familyMembers[index]["type"] == "infants" && age > 18)
            this.editError[errorId] = "Age must be less than 18";
          else
            this.familyMembers[index]["family_dob"] =
              presentDate.getFullYear() +
              "-" +
              (presentDate.getMonth() + 1) +
              "-" +
              presentDate.getDate();
        }
        for (let inputFields of familyMemberHtmlInputFields) {
          for (let item of inputFields) {
            let errorId = "family_members." + index + "." + item.name;
            if (
              item.required &&
              (!(item.name in this.familyMembers[index]) ||
                this.familyMembers[index][item.name]?.toString().length == 0)
            )
              this.editError[errorId] =
                "The " +
                errorId +
                " field is required when signing wavier for family member is true.";
            else if (this.familyMembers[index][item.name]?.length > 255)
              this.editError[errorId] =
                item.label + " must not exceed than 255 character";
          }
        }
        // wavier validation

        for (let wavierInputFields of this.wavierSignatureHtml) {
          let errorId = "family_members." + index + ".signature";
          if (
            this.familyMembers[index].type != "infants" &&
            wavierInputFields.required &&
            (!("signature" in this.familyMembers[index]) ||
              this.familyMembers[index]["signature"]?.toString().length == 0)
          )
            this.editError[errorId] = "This field is required";
        }
      }
      if (!this.isEdit) return this.editError;
      if (Object.keys(this.editError).length > 0) return true;
      return false;
    },
    async submitFamilyMemberForm() {
      let imageUrl = window.location.origin + "/images/funvilla.png";
      $.LoadingOverlay("show", {
        image: imageUrl,
        imageAnimation: "1.5s fadein",
      });
      this.editError = {};
      // if (this.isEdit && this.termsAndConditionFlag == true) {
      //   $.LoadingOverlay("hide");
      //   this.editError["termsAndConditionFlag"] =
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
          let form = {};
          form["family_members"] = this.familyMembers;
          form["family_member_count"] = this.familyMemberCount;
          form["terms_and_conditions"] = this.termsAndCondition;
          form["customer_remarks"] = "NA";
          await axios
            .post("/customer-family-member-update/" + this.customer.id, form)
            .then((response) => {
              if (response.data.status) {
                window.location.href = "/" + response.data.href;
              }
            })
            .catch((error) => {
              const statusCode = error.response?.status;
              const errorsList = error.response?.data?.errors;
              if (statusCode == 422 && errorsList) {
                this.editError = errorsList;
              }
              $.LoadingOverlay("hide");
            });
        }
        if (Object.keys(this.editError).length > 0) {
          let errorString = "#" + Object.keys(this.editError)[0];
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

    sweetAlertDelete(index, type) {
      Swal.fire({
        title: "Are you sure ?",
        icon: "question",
        showDenyButton: true,
        confirmButtonText: "Yes I'm sure",
        denyButtonText: "Cancel",
      }).then((result) => {
        if (result.isConfirmed) {
          this.removeFamilyMember(index, type);
        }
      });
    },
  },
  watch: {
    termsAndConditionFlag(val) {
      if (!this.isEdit) this.$parent.termsAndConditionFlag = false;
    },
    familyMemberCount(val) {
      if (!this.isEdit) this.$parent.familyMemberCount = val;
    },
    familyMembers(val) {
      if (!this.isEdit) this.$parent.familyMembers = val;
    },
    customerRemarks(val) {
      if (!this.isEdit) this.$parent.customerRemarks = val;
    },
  },
};
</script>
