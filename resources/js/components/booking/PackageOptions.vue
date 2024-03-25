<template>
  <div class="row">
    <div v-for="(item, itemName) in form" :key="itemName" class="col-md-12">
      <label>{{ item.label }}:</label>
      <div v-if="item.type === 'select'">
        <select
          v-model="formData[itemName]"
          :name="itemName"
          @change="handleSelectChange(itemName)"
          class="form-select"
          style="width: 30%"
        >
          <option v-for="(value, valueName) in item.values" :key="value.label">
            {{ value.label }}
          </option>
        </select>
      </div>

      <div>
        <div v-for="(value, valueGroup) in item.values" :key="valueGroup">
          <div v-if="value.type === 'group'" class="row">
            <div
              v-for="(input, valueInput) in value.values"
              :key="valueInput"
              class="col-md-3"
            >
              <label>{{ input.label }}</label>
              <input
                v-model="formData[valueGroup]"
                :name="valueGroup"
                type="text"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive } from "vue";

export default {
  data() {
    return {
      form: {
        0: {
          label: "Pizza",
          type: "select",
          values: {
            0: {
              type: "single",
              label: "flavor 1",
            },
            1: {
              type: "single",
              label: "flavor 2",
            },
            2: {
              type: "group",
              label: "flavor 3",
            },
            3: {
              type: "single",
              label: "flavor 4",
            },
          },
        },
      },
      formData: {},
    };
  },
  methods: {
    handleSelectChange(itemName) {
      const selectedFlavor = this.formData[itemName];
      //const flavorItem = this.form[itemName].values[selectedFlavor];
      console.log(selectedFlavor);
      //   if (flavorItem && flavorItem.type === "group" && flavorItem.values) {
      //     this.formData = reactive({
      //       ...this.formData,
      //       ...flavorItem.values,
      //     });
      //   }
    },
    isObjectGroup(item) {
      console.log(item);

      return (
        typeof item === "object" &&
        item.type === "group" &&
        typeof item.values === "object" &&
        !Array.isArray(item.values)
      );
    },
  },
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
