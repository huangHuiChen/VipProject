<template>
    <div>
    <multiselect
      v-model="selected"
      :options="options"
      :multiple="false"
      :searchable="true"
      :allow-empty="true"
      :close-on-select="true"
      :clear-on-select="false"
      placeholder="請選擇活動代號"
      label="id"
      track-by="id"
    >
      <!--自訂義選項顯示-->
      <template #option="{option}">
        <div v-show="isOptionVisible(option)">{{ option.id }} {{option.na}}
        </div>
      </template>
      
    </multiselect>
    <pre class="language-json" v-if="!selected"><code>{{ selected }}</code></pre>
    <pre class="language-json" v-else><code>{{ selected.na }}  期間:{{selected.beginD}}~{{selected.endD}}</code></pre>
    </div>
</template>

<script>
//僅for會員活動用
import Multiselect from 'vue-multiselect';

export default {
  name: 'SingleSelect',
  components: { Multiselect },
  props: {
    modelValue: {
      type: Array,
      default: () => []
    },
    options: {
      type: Array,
      required: true,
      default: () => []
    }, 
    placeholder: {
      type: String,
      required: true,
      default: '請輸入/選擇活動代號'
    },
    startDate: {
      type: String,
      default: ''
    },
    endDate: {
      type: String,
      default: ''
    }
  },

  /*computed: {
    filteredOptions() {
      const start = new Date(this.startDate);
      const end = new Date(this.endDate);
      return this.options.filter(option => {
        const beginDate = new Date(option.beginD);
        const optionDate = this.parseOptionDate(option.begin);
        return beginDate >= start && beginDate <= end;
      });
    }
  },*/
  
  methods: {
    isOptionVisible(option) {
      const start = new Date(this.startDate);
      const end = new Date(this.endDate);
      const beginDate = new Date(option.beginD);
      return beginDate >= start && beginDate <= end;
    },
    removeTabindexFromMultiselect() {
      // 获取第一个 'multiselect' 类的元素
      const multi = document.querySelector('main');

      // 如果找到了元素
      if (multi) {
        // 获取所有含有 tabindex 的子元素
        const focusableElements = multi.querySelectorAll('[tabindex]');
        
        // 遍历并移除 tabindex 属性
        focusableElements.forEach(element => {
          element.removeAttribute('tabindex');
        });
      } else {
        // 输出失败消息
        console.log('Fail: No element found with class "multiselect".');
      }
    },
   
  },
  watch:{
    modelValue(newVal){
      this.selected = newVal;
    },
    selected(newVal){
      this.$emit('update:modelValue',newVal);
    }
  },
  mounted() {
    this.$nextTick(()=>{
      this.removeTabindexFromMultiselect();
    })
  },
  data() {
    return {
      selected: this.modelValue,
      options: this.options
    };
  },

};
</script>

<style scoped>
  @import "vue-multiselect/dist/vue-multiselect.css";

  设置最大高度和滚动条样式
  .multiselect__content-wrapper {
    max-height: 200px; 
    overflow-y: auto; 
  }

  .multiselect {
    width: 700px;
    font-size: 12pt;
    max-height: 200px; /* 设置下拉选单的最大高度 */
    overflow-y: auto; 
    top: 5px;
  }

  .multiselect-dropdown .multiselect__tags,
  .multiselect-dropdown .multiselect__select {
  z-index: 1000; /* 确保 Multiselect 在表格之上 */
}
</style>
