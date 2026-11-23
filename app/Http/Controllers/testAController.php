<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use DateTime;
use PDO;
use Log;
require_once app_path('Helper/Common.php');
require_once app_path('Helper/JsonConfig.php');
use App\Helpers\Common;
use App\Helpers\JsonConfig;


class testAController extends Controller{
    protected $totalRec = 0;
    
    public function Menu_A(){
        $Common = new Common();
        $navItems = $Common -> NavBar();

        $JsonConfig = new JsonConfig();
        $lastDate = $JsonConfig->getDynamicConfig('testA_DATE');
        $date = new DateTime($lastDate);
        $date->modify('+1 day'); //最後日結日+1
        $newDate = (String)$date->format('Y-m-d');
        
        $bind = [
            'navItems'=> $navItems,
            'tdate'=> $newDate
        ];
        return view('testA', $bind);
    }

    public function Excute_A(Request $requset){
        try {
            $tdate = $requset->input('tdate');
            $JsonConfig = new JsonConfig();
            $get_date = $JsonConfig->getDynamicConfig('testA_DATE');
            $check = new DateTime($get_date);
            $check_date = (String)$check->format('Ymd');

            if($check_date === $tdate){
                return response()->json([
                    'results' =>'失敗',
                    'message' => '該日期'. $check_date.'已經執行過，請更新日期!',
                    'error' => ''
                ]); 
            }
            $get_date2 = $JsonConfig->getDynamicConfig('testA_DATE');
            $check2=  new DateTime($get_date2);
            $check2->modify('+1 day');
            $check_date1 = (String)$check2->format('Ymd');
            if($check_date1 !== $tdate){
                return response()->json([
                    'results' =>'失敗',
                    'message' => '前次結算日'.$check_date.',日期'. $tdate.'非已結算隔日，請確認!' ,
                    'error' => ''
                ]); 
            }
            //從mssql撈取資料並寫入sql檔
            $filePath = storage_path('app/public/deal_insert.sql');
            $data = $this->Query_GIFT($tdate);
            try{
                $file = fopen($filePath, 'w');
                foreach($data as $row){
                    $line = "insert INTO test (a, b, c) VALUES ";
                    $line .= "(to_date('$row->deal_date', 'YYYY/MM/DD'), '$row->deal_id', $row->QTY);";
                    fwrite($file, $line . PHP_EOL);
                }
                fwrite($file, 'COMMIT;');
            }catch (Exception $e){
                return response()->json([
                    'results' =>'失敗',
                    'message' => '執行失敗!資料撈取有誤!',
                    'error'=> $e->getMessage(),
                ]);
            }finally{
                fclose($file);
            }
            //匯入oracle
            $shellPath = storage_path('app/public/switch10g.sh');
            $shell = shell_exec('bash ' . $shellPath);
            $user = config('database.connections.oracle_8i.username');
            $paswd = config('database.connections.oracle_8i.password');
            $host = config('database.connections.oracle_8i.host');
            $port = config('database.connections.oracle_8i.port');
            $service = config('database.connections.oracle_8i.database');
            $commd = "/opt/instantclient_10_2/sqlplus \"{$user}/{$paswd}@//{$host}:{$port}/{$service}\" @{$filePath}";
            try{
                exec($commd, $output, $returnVar);
                if($returnVar !== 0){
                    throw new Exception("Sql PLUS執行失敗: ".  implode("\n", $output));
                }

                $date = new DateTime($tdate);
                $newDate = $date->format('Y/m/d');
                $JsonConfig->setDynamicConfig('testA_DATE', $newDate);

                return response()->json([
                    'results' => '成功',
                    'message' => '執行成功! 共計匯入: '.$this->totalRec .'筆',
                    'error' => ''
                ]); 
            }catch (Exception $e){
                Log::error("Data匯入失敗: ". $e->getMessage());
                Log::info('Return Code: ' . $returnVar);
                exec("echo 'ROLLBACK;' | {$commd}");
                return response()->json([
                    'results' => '失敗',
                    'message' => '資料匯入失敗!',
                    'error' => 'Data import failed. Check logs for details.'
                ], 500
                );
            }   

        } catch (Exception $e) {
            return response()->json([
                'results' => '失敗',
                'message' => '執行失敗!請確認資料，再重新執行!',
                'error'=> $e->getMessage(),
            ]);
        }
    }


    public function Query_GIFT($tdate){
        #mssql撈取
        $sql = "
        select stuff(stuff(deal_date,5,0,'/'),8,0,'/') AS deal_date, 
               deal_record.deal_id AS deal_id, format(SUM(deal_record.deal_count),'0') AS QTY
        from deal_record with(nolock), deal_function with(nolock)
        WHERE deal_date >= ? AND deal_date <= ?
        AND check_v = '1' AND deal_record.deal_id = deal_function.deal_id
        GROUP BY deal_date, deal_record.deal_id
        ORDER BY deal_date, deal_record.deal_id
        ";
        try{
            $data = DB::select($sql, [$tdate, $tdate]);
            $this->totalRec = count($data);
            return $data;
        }catch(Exception $e){
            throw new Exception('MSSQL資料撈取失敗:  ' . $e->getMessage());
        }
    }

}