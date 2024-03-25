<template>
  <div class="mb-4">
    <div
      :class="
        wavierMember.type == 'adult'
          ? 'bg-gray-100  family-member rounded-lg'
          : 'bg-slate-100 family-member rounded-lg'
      "
    >
      <div
        class="flex items-center border-b border-slate-100 dark:border-slate-700 mx-4"
      >
        <div class="flex-1">
          <div class="card-title text-slate-900 dark:text-white">
            I
            {{
              wavierMember.type == "infants" || wavierMember.type == "customer"
                ? (customer["first_name"] ?? "") +
                  " " +
                  (customer["last_name"] ?? "")
                : (familyMembers[tempWavierIndex]?.family_first_name ?? "") +
                  " " +
                  (familyMembers[tempWavierIndex]?.family_last_name ?? "")
            }}
            signing this waiver
          </div>
        </div>
      </div>
      <div class="">
        <div class="input-area relative">
          <div
            class="container bg-white"
            :id="'family_members_' + tempWavierIndex + '_signature'"
          >
            <VueSignaturePad
              :options="{ onBegin, onEnd }"
              width="100%"
              height="20vh"
              style="border: 1px solid"
              :ref="'signaturePad_' + wavierMember.familyMemberIndex"
            />
          </div>
        </div>
        <div
          v-if="
            familyMemberErrors.indexOf(
              'signature_' + wavierMember.familyMemberIndex
            ) != '-1'
          "
        >
          <span class="mt-4 text-red-600">{{
            Array.isArray(
              familyMemberErrors["signature_" + wavierMember.familyMemberIndex]
            )
              ? familyMemberErrors[
                  "signature_" + wavierMember.familyMemberIndex
                ][0]
              : familyMemberErrors[
                  "signature_" + wavierMember.familyMemberIndex
                ]
          }}</span>
        </div>
        <div
          v-if="
            Object.keys(isEdit ? editError : errors).indexOf(
              'family_members.' + tempWavierIndex + '.signature'
            ) != '-1'
          "
        >
          <span class="mt-4 text-red-600">{{
            Array.isArray(
              isEdit
                ? editError["family_members." + tempWavierIndex + ".signature"]
                : errors["family_members." + tempWavierIndex + ".signature"]
            )
              ? isEdit
                ? editError[
                    "family_members." + tempWavierIndex + ".signature"
                  ][0]
                : errors["family_members." + tempWavierIndex + ".signature"][0]
              : isEdit
              ? editError["family_members." + tempWavierIndex + ".signature"]
              : errors["family_members." + tempWavierIndex + ".signature"]
          }}</span>
        </div>
        <div class="flex gap-5">
          <button
            type="button"
            class="btn inline-flex justify-center btn-dark mt-4 mb-2 w-full"
            @click="clear(wavierMember.familyMemberIndex)"
          >
            Clear
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: [
    "customer",
    "familyMembers",
    "wavierMember",
    "isEdit",
    "familyMemberHtml",
    "editError",
    "errors",
  ],
  data() {
    return {
      familyMemberErrors: [],
      // ... Other data properties ...
    };
  },
  computed: {
    tempWavierIndex: function () {
      return this.familyMembers.findIndex(
        ({ familyMemberIndex }) =>
          familyMemberIndex === this.wavierMember.familyMemberIndex
      );
    },
  },
  methods: {
    onBegin() {},
    onEnd() {
      let index = this.wavierMember.familyMemberIndex;
      this.familyMemberErrors = [];
      const { isEmpty, data } =
        this.$refs["signaturePad_" + index].saveSignature();
      if (!isEmpty) {
        // let adultFamilyHtml = this.wavierSignatureHtml.filter(function(el){ return el.type == 'adult'});
        // for(let adultFamilyMember of adultFamilyHtml){
        //     if(this.familyMembers[adultFamilyMember.familyMemberIndex - 1]?.signature == data){
        //         this.familyMemberErrors['signature_'+index] = 'The '+ item.label + ' is matched with family member ' + adultFamilyMember.familyMemberIndex;
        //         break;
        //     }
        // }
        if (this.familyMemberErrors.length <= 0)
          this.familyMembers[this.tempWavierIndex].signature = data;
      }
    },
    clear(index) {
      this.$refs["signaturePad_" + index].clearSignature();
      if (
        Object.keys(this.familyMembers[this.tempWavierIndex]).indexOf(
          "signature"
        ) != "-1"
      )
        this.familyMembers[this.tempWavierIndex].signature = "";
    },
  },
};
</script>
