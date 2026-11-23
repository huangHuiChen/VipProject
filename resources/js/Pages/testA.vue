<template>
    <main-layout>
        <template #default>
            <h1>庫存日結作業</h1>
            <div>
                <table>
                    <tr>
                        <td class="title redstar">日結日期</td>
                        <td>
                            <div class="line"><input type="date" v-model="initdate" ></input>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <ButtonGroup
                                :-btn-group="BtnGroup"
                                :-btn-x="BtnX"
                                :-btn_-load="loading"
                                @button-click="BtnClick"
                            />
                        </td>
                    </tr>
                </table>
            </div>
            <div class = "redtext" v-if="loading">執行中，請耐心等待...........</div>
            <div  v-if="responseData">
                <pre>
                    執行結果:{{responseData.results}}
                    訊息: {{ responseData.message }}
                          {{ responseData.error }}
                </pre>

            </div>
        </template>
    </main-layout>
</template>

<script setup>
    import MainLayout from '@/Layouts/MainLayout.vue';
    import ButtonGroup from '@/Components/ButtonGroup.vue';

    import { ref } from 'vue';
    import { errorMsg } from '@/variable';
    import { usePut_data } from '@/utils';

    defineOptions({
        name: 'testA',
    });

    const props = defineProps({
        tdate: String,
    })
    const BtnGroup = ref(['X']);
    const BtnX = ref(true);

    const currentCount = ref(0);
    const totCount = ref(0);
    const initdate = ref(props.tdate);
    const {loading, responseData, AjaxPut_Data} = usePut_data();
    const BtnClick = async (btn) =>{
        if(btn === 'X'){
            if (confirm("確認執行庫存日結作業？")) {
                currentCount.value = 0;
                if(initdate.value.replace(/-/g, '') === ''){
                    alert(errorMsg.dateIsNull);
                    console.log('日期為空，請確認日期記錄!');
                    return;
                };

                const url = '/testA';
                const token = document.querySelector('meta[name = "csrf-token"]').getAttribute('content');
                const Jdata = {tdate: initdate.value.replace(/-/g, ''),};
                AjaxPut_Data(url, token, Jdata);
              
            } else {
                console.log("取消執行日結作業");
                return;
            }
        }
    };

    

</script>

<style>
    .line{
        display: flex; /* 使用 flexbox 布局 */
        align-items: center; /* 垂直居中对齐 */
    }
    input[type='date']{
        margin-right: 150px;
    }
    .light-blue{
        color: #66B3FF;
        margin-right: 20px;
    }
    .dark-blue{
        color: #003D79 ;
        margin-left: 20px ;
    }
</style>