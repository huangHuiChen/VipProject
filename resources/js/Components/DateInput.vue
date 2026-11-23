<template>
    
    <input
      type = "date"
      :value="formattedDate"
      @input="updateDate($event.target.value)"
    >
    
</template>

<script>
//僅for會員活動日期區間用
export default {
    name: 'DateInput',
    props: {
      modelValue:{
        type: String,
        default: ''
      }
    },
    computed: {
      formattedDate() {
         return this.modelValue ? this.modelValue.replace(/\//g, '-') : '';
      }
    },
    methods: {
      updateDate(newDate) {
      const parsedDate = newDate ? newDate.replace(/-/g, '/') : '';
      this.$emit('update:modelValue', parsedDate);
    }
      
    },
    /*data() {
      return {
        dateInput: this.formattedDate
      };
    },
    watch: {
      value(newVal) {
        this.dateInput = this.formatDate(newVal);
      }
    }*/
};
</script>
