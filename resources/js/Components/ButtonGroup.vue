<template>
    <button v-if="BtnShow('A') && BtnA" type="button" @click="emitBtnClick('A')" :disabled="Btn_Load">新增</button>
    <button v-if="BtnShow('M') && BtnM" type="button" @click="emitBtnClick('M')" :disabled="Btn_Load">修改</button>
    <button v-if="BtnShow('D') && BtnD" type="button" @click="emitBtnClick('D')" :disabled="Btn_Load">刪除</button>
    <button v-if="BtnShow('T') && BtnT" type="button" @click="emitBtnClick('T')" :disabled="Btn_Load">取消</button>
    <button v-if="BtnShow('S') && BtnS" type="button" @click="emitBtnClick('S')" :disabled="Btn_Load">儲存</button>
    <button v-if="BtnShow('Q') && BtnQ" type="button" @click="emitBtnClick('Q')" :disabled="Btn_Load">查詢</button>
    <button v-if="BtnShow('E') && BtnE" type="button" @click="emitBtnClick('E')" :disabled="Btn_Load">匯出</button>
    <button v-if="BtnShow('X') && BtnX" type="button" @click="emitBtnClick('X')" :disabled="Btn_Load">執行</button>
    <button v-if="BtnShow('C') && BtnC" type="button" @click="emitBtnClick('C')" :disabled="Btn_Load">清除</button>
</template>


<script setup>
    
    defineOptions({
        name: 'ButtonGroup',
    });

    const props = defineProps({
        BtnGroup:{
                type: Array,
                required: true
            },
            BtnA: {
                type: Boolean,
                default: false,
            },
            BtnM: {
                type: Boolean,
                default: false,
            },
            BtnD: {
                type: Boolean,
                default: false,
            },
            BtnT: {
                type: Boolean,
                default: true,
            },
            BtnS: {
                type: Boolean,
                default: true,
            },
            BtnQ: {
                type: Boolean,
                default: false,
            },
            BtnC: {
                type: Boolean,
                default: false,
            },
            BtnE: {
                type: Boolean,
                default: false,
            },
            BtnX: {
                type: Boolean,
                default: false,
            },
            BtnQ_s:{
                type: Boolean,
                default: false
            },
            Btn_Load:{
                type: Boolean,
                default: false
            },
    });

    const BtnShow = (btnNa) => {
        return props.BtnGroup.includes(btnNa);
    };

    const emit = defineEmits(['button-click']);
    //觸發父組件的Click事件
    const emitBtnClick = (button) =>{
        emit('button-click', button);
    };

</script>

<style>
    button[disabled] {
        background-color: #cccccc;
        color: #666666;
        cursor: not-allowed;
    }
</style>

    


