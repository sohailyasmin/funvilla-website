<template>
  <select
    :value="modelValue"
    v-bind="dynamicAttrs"
    @input="updateModel"
    class="form-select"
    aria-label="Default select example"
  >
    <option v-for="option in options" :key="option.value" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [String, Number],
      default: "",
    },
    dynamicAttrs: {
      type: Object,
      default: () => ({}),
    },
    options: {
      type: Array,
      default: () => [],
    },
  },
  methods: {
    updateModel(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
};
</script>
