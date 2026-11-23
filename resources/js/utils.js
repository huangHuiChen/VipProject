export function formatDate(date) {
    // 格式化日期的函数
    return new Date(date).toLocaleDateString();
}

export function getToday(){
    //獲取今日
    const date = new Date();
    date.setDate(date.getDate());
    return date.toISOString().split('T')[0]; 
}

export function getYesterday(){
    //獲取昨日
    const date = new Date();
    date.setDate(date.getDate()-1);
    return date.toISOString().split('T')[0]; 
}

export function checkDateBE(date1, date2){
    /*檢查起始日期是否小於結束日期*/
    const d1 = new Date(date1);
    const d2 = new Date(date2);
    return d1>d2;
}

export function checkDateRange(date1, date2, day){
    /*檢查日期區間是否符合
        date1 開始日期 date2結束日期 day天數
        return ture→不符合
    */
    const d1 = new Date(date1);
    const d2 = new Date(date2);
     
    const d = (d2.getTime() -d1.getTime())/(1000*3600*24);
    return d > day;
}

import { ref } from 'vue';
export function usePut_data(){
    const loading = ref(false);
    const responseData = ref('');
    
    const AjaxPut_Data = async (url, token, josnData) =>{
        loading.value = true;
        try{
            const response = await fetch(url, {
                method: 'POST',
                headers:{
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(josnData)
            });

            if(response.status === 419){
                alert('畫面停留過久，將重新整理!');
                window.location.reload();
            }else{
                const data = await response.json();
                responseData.value = data;
            }
        }catch (error){
            console.log('發生錯誤: ', error);
            alert('查詢失敗');
        }finally{
            loading.value = false;
        } 
    };
    return {
        loading, responseData, AjaxPut_Data
    };
}

import * as XLSX from 'xlsx';
export function exportTableData(refTb, filenaPre, wscols, col = 15) {
    //col 第幾欄 A欄=0 B欄=1，以此類推→為了類似於電話號碼所設定
    /*2024.10.14 modify修改為Vue3寫法，暫時只有逾期點數統計表使用，故暫不包版
    if (!refTb || !refTb.$refs[refNa]) {
        alert('匯出失敗!');
        return;
    }
    const table = refTb.$refs[refNa];*/
    const wb = XLSX.utils.table_to_book(refTb, { sheet: "Sheet1" });
    const ws = wb.Sheets["Sheet1"];
    //如果 wscols 为空，自动计算列宽
    if (!wscols || wscols.length === 0) {
        wscols = calculateColumnWidths(ws);
    }
    ws['!cols'] = wscols;

    const range = XLSX.utils.decode_range(ws['!ref']); // 获取工作表范围
    const totalCols = range.e.c + 1; //總列數
    if(col >totalCols){
        col = totalCols+1;
    }
    for (let R = range.s.r; R <= range.e.r; R++) {
        for (let C = range.s.c; C <= range.e.c; C++) {
            let cellAddress = XLSX.utils.encode_cell({ r: R, c: C }); // 编码单元格地址
            if (C === col && R >0) {
                ws[cellAddress].v = ws[cellAddress].v.toString().padStart(10, '0');  // 确保转为字符串
                ws[cellAddress].t = 's';  // 设置为文本类型
            }

        }
    }

    const now = new Date();
    const yy = now.getFullYear().toString().slice(-2); // 取得年份的后两位
    const mm = String(now.getMonth() + 1).padStart(2, '0'); // 月份（01-12）
    const dd = String(now.getDate()).padStart(2, '0'); // 日期（01-31）
    const dateStr = `${yy}${mm}${dd}`;

    const fileName = `${filenaPre}_${dateStr}.xlsx`;
    XLSX.writeFile(wb, fileName);
    alert('匯出成功!');
}

// 计算每列的宽度
function calculateColumnWidths(ws) {
    const colWidths = [];
    const range = XLSX.utils.decode_range(ws['!ref']); // 获取工作表的范围

    for (let C = range.s.c; C <= range.e.c; ++C) {
        let maxLength = 10; // 默认宽度

        for (let R = range.s.r; R <= range.e.r; ++R) {
            const cellAddress = { c: C, r: R };
            const cellRef = XLSX.utils.encode_cell(cellAddress);
            const cell = ws[cellRef];

            if (cell && cell.v) {
                const cellValue = String(cell.v);
                maxLength = Math.max(maxLength, cellValue.length); // 找出最长的单元格内容
            }
        }

        colWidths.push({ wch: maxLength + 2 }); // 加点额外空间，防止内容紧贴
    }

    return colWidths;
}
