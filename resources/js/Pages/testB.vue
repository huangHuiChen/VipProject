<template>
    <MainLayout>
        <template #default>
            <h1>小遊戲獲獎查詢</h1>
            <div>
                <table>
                    <tr>
                        <td class="title redstar">查詢類別</td>
                        <td><label class="cond_Radio"><input type="radio" value="0" v-model="radio_V">人數統計</label>
                            <label class="cond_Radio"><input type="radio" value="1" v-model="radio_V">贈品統計</label>
                            <label class="cond_Radio"><input type="radio" value="2" v-model="radio_V">贈品統計(依日期)</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="title redstar">檔期代號</td>
                        <td>
                            <SingleSelect
                                v-model="selected"
                                :options="options"
                                placeholder="請輸入檔期代號"
                                :startDate="startDate"
                                :endDate="endDate"
                            />
                        </td>
                    </tr>
                    <tr>
                        <td class="title redstar">日期區間</td>
                        <td>
                            <DateInput v-model="beginD"/> ~ <DateInput v-model="endD"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="title"></td>
                        <td>
                            <ButtonGroup
                                :-btn-group="BtnGroup"
                                :-btn-q="BtnQ"
                                :-btn-c="BtnC"
                                :-btn-e="BtnE"
                                :-btn_-load="loading"
                                @button-click="BtnClick"
                            />
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div v-if="responseData">
                <iecgx4 ref="recgx4" :response-data="responseData"/>
            </div>
        </template>
    </MainLayout> 
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import ButtonGroup from '@/Components/ButtonGroup.vue';
import SingleSelect from '@/Components/SingleSelect.vue';
import DateInput from '@/Components/DateInput.vue';
import iecgx4 from '@/Layouts/Iecgx4.vue';
import { nextTick, ref, watch } from 'vue';
import { getYesterday, usePut_data, checkDateBE, checkDateRange, exportTableData } from '@/utils';
import { errorMsg } from '@/variable';

defineOptions({
    name: 'testB',
});

const props = defineProps({
    options: {
        type: Array, 
        required: true
    },
});

const radio_V = ref('0');

const selected = ref(null);
const getStartDate = () =>{
    const date = new Date();
    date.setMonth(date.getMonth() -3);
    return date.toISOString().split('T')[0];
};
const getEndDate = () => {
    const date = new Date();
    return date.toISOString().split('T')[0];
};
const startDate= ref(getStartDate());  
const endDate= ref(getEndDate());

const beginD = ref(getYesterday());
const endD = ref(getYesterday());
watch(selected, (newVal) =>{
    if(newVal){
        beginD.value = newVal.beginD ? newVal.beginD.replace(/-/g, '/') : '';
        endD.value = newVal.endD ? newVal.endD.replace(/-/g, '/') : '';
    } else {
      beginD.value = '';
      endD.value = '';
    }
});


const { loading, responseData, AjaxPut_Data } = usePut_data();
const BtnGroup = ref(['Q','E','C']);
const BtnC = ref(true);
const BtnQ = ref(true);
const BtnE = ref(true);
const recgx4 = ref(null);
const BtnClick = (btn)=>{
    if(btn === 'Q'){
        if (!selected.value || selected.value.length === 0){
          alert(errorMsg.campIsNull);
          return
        }
        //檢查日期區間，不得大於半年(31天)
        if(beginD.value === '' || endD.value === ''){
          alert(errorMsg.dateIsNull);
          return
        }
        if(checkDateBE(beginD.value, endD.value)){
          alert(errorMsg.dateBeginError);
          return
        }
        const check = checkDateRange(beginD.value, endD.value, 31);
        if(check){
          alert(errorMsg.dateRange1M);
          return
        }

        const q_type = radio_V.value;
        const selected2 = selected.value.id;//檔期代號
        const date1 = beginD.value;
        const date2 = endD.value;
        const url = '/testB';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const Jdata = {
            q_type: q_type,
            sche: selected2,
            date1: date1.replace(/\//g,''),
            date2: date2.replace(/\//g,'')
        };
        AjaxPut_Data(url, csrfToken, Jdata);
    }else if(btn === 'C'){
        clearAlldata();
    }else if(btn === 'E'){
        exportData();
    }

};

const clearAlldata = () =>{
    radio_V.value = '0';
    selected.value = null;
    beginD.value = getYesterday();
    endD.value = getYesterday();
    responseData.value = '';
}

const exportData = () =>{
    nextTick(()=>{
        if(!recgx4.value || !recgx4.value.Iecgx4){
            alert(errorMsg.exportFail);
            return
        }
        const refTab = recgx4.value.Iecgx4;
        let wscols = [];
        exportTableData(refTab, '小遊戲獲獎查詢', wscols);
    })
}
</script>

<style>
label.cond_Radio {
    margin-left: 7px;   
}

</style>