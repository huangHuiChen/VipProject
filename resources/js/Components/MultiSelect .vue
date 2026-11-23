<template>
  <div>
    <multiselect
      v-model="selected"
      :options="options"
      :multiple="true"
      :close-on-select="false"
      :clear-on-select="false"
      :hide-selected="true"
      placeholder="Pick some"
      label="name"
      track-by="name"
    >
    </multiselect>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
  components: { Multiselect },
  data() {
    return {
      selected: [],
      options: [
        { name: 'Option 1' },
        { name: 'Option 2' },
        { name: 'Option 3' }
      ]
    };
  }
};
</script>

<style>
@import "vue-multiselect/dist/vue-multiselect.min.css";
</style>
