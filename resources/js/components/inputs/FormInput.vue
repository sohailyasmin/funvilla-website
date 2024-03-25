<template>
  <input
    :type="type"
    :value="modelValue"
    :placeholder="placeholder"
    :required="isRequired"
    v-bind="dynamicAttrs"
    @input="updateModel"
    class="form-control"
  />
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: "text",
    },
    modelValue: {
      type: [String, Number, Date],
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    dynamicAttrs: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    isRequired() {
      return this.dynamicAttrs.required === true;
    },
  },
  methods: {
    updateModel(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
};
</script>

<style scoped>
.error-message {
  color: red;
  font-size: 0.8rem;
  margin-top: 0.2rem;
}
</style>
