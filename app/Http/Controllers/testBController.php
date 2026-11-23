<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
require_once app_path('Helper/Common.php');
use App\Helpers\Common;

class testBController extends Controller
{
    public function Report_testB(){
        $Common = new Common();
        $navItems = $Common -> NavBar();
        $options = DB::table(DB::raw('table01 WITH (NOLOCK)'))
        ->select('col_id as id', 'col_name as na', 
                DB::raw("stuff(stuff(begin,5,0,'/'),8,0,'/') as beginD"), 
                DB::raw("stuff(stuff(end,5,0,'/'),8,0,'/') as endD"))
        ->where('set_id', '=', 'A')
        ->orderBy('begin', 'desc')
        ->get();

        $bind = [
            'options' =>$options,
            'navItems' => $navItems,
        ];
        return view('testB', $bind);
    } 

    public function Create_Report(Request $request){
        $sche = $request->input('col');
        $q_type = $request->input('q_type');
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');

        if($q_type === '0'){
            try{
                $res1 = $this->A_Report1($sche, $date1, $date2);
                $res2 = $this->A_Report2($sche, $date1, $date2);
                $res3 = $this->A_Report3($sche, $date1, $date2);
                return response()->json([
                    'results' => ['res1'=>$res1, 'res2'=>$res2, 'res3'=>$res3],
                    'type' => 'X'
                ]);
            }catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()], 500); 
            }
        }else{
            try {
                $result = $this->B_Report($sche, $date1, $date2, $q_type);
                return response()->json([
                    'results' => $result,
                    'type' => $q_type
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500); 
            }    
        }
    }

    private function A_Report1($sc_id, $date1, $date2){
        /*計算 日期區間 次數+人數*/
        $sql = "
        with a as(
        select user_id, count(deal_date) as 'count_deal'
        from deal_record with(nolock)
        where col_id = ? and deal_date between ? and ?
        group by user_id
        )

        select count_deal, count(count_deal) as people
        from a with(nolock)
        group by count_coming order by count_deal; 
        ";
        return DB::select($sql, [$sc_id, $date1, $date2]);
    }

    private function A_Report2($sc_id, $date1, $date2){
        /*計算 日期區間 每日 人數+人次*/
        $sql = "
        select stuff(stuff( deal_date, 5,0, '/'),8,0,'/') as td, count(user_id) AS p1, count(distinct user_id) as p2
        from deal_record with(nolock) where col_id = ? and deal_date between ? and ?
        group by deal_date order by deal_date;
        ";
        return DB::select($sql, [$sc_id, $date1, $date2]);
    }

    private function A_Report3($sc_id, $date1, $date2){
        /*計算 日期區間 總人數+總人次*/
        $sql = "
        select count(user_id) as p1,count(distinct user_id)  as p2
        from deal_record with(nolock) where col_id = ? and deal_date between ? and ?;
        ";
        return DB::select($sql, [$sc_id, $date1, $date2]);
    }

    private function B_Report($sc_id, $date1, $date2, $type){

        $select1 = "select ";
        $select2 = "select  stuff(stuff(dr.deal_date, 5,0, '/'),8,0,'/') d_date,";
        $sql = "dr.deal_id , format(sum(dr.deal_count),'0') d_count,  df.col_v, " ;
        $col1 = "ROW_NUMBER() OVER (ORDER BY dr.deal_id) AS rownum";
        $col2 = "ROW_NUMBER() OVER (ORDER BY stuff(stuff(dr.deal_date, 5,0, '/'),8,0,'/')) AS rownum";
        $from = "
        from deal_record as dr with(nolock) JOIN deal_funciton  as df with(nolock) ON dr.col_id = df.col_id and dr.deal_id = df.deal_id 
        where  dr.col_id = ? and deal_date between ? and ?
        ";
        $group1 = "group by dr.deal_id,df.col_v;";
        $group2 = "group by stuff(stuff(dr.deal_date, 5,0, '/'),8,0,'/'),dr.deal_id,df.col_v;";
        $final = '';
        if($type === '1'){
            //不區分日期
            $final = $select1.$sql.$col1.$from.$group1;
        }else if($type === '2'){
            $final = $select2.$sql.$col2.$from.$group2;
        }
        return DB::select($final, [$sc_id, $date1, $date2]);
    }
}