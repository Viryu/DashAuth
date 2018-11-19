<?php

namespace App\Http\Controllers;

use App\BankCardCode;
use App\BankTransactionCount;
use App\User;
use App\UserDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

use App\DataTable;
use App\Exports\DataExports;
use App\Exports\ExportFromView;
use App\Exports\ExportTable;
use App\Exports\ExportAll;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\VarDumper\Cloner\Data;
use JavaScript;
use PDF;
use Mapper;
class DashboardController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            if(Auth::user()->role =="admin"){
            $transactionsalesonly= count(DB::select('select * from VDI_client_VDI_vMobeyTransactions_v1 where response_code = 0 and authorisation_response_code = 00'));
            $transactionfailonly=count(DB::select('select * from VDI_client_VDI_vMobeyTransactions_v1 where response_code != 0 and authorisation_response_code != 00'));
            $devices =count(DB::table('vGetDevices_v1')
                    ->join('vGetMerchantInfo_v1','vGetMerchantInfo_v1.merchant_id','=','vGetDevices_v1.merchant_id')
                    ->join('vTerminalIDs_v2','vGetMerchantInfo_v1.merchant_id','=','vTerminalIDs_v2.merchant_id')
                    ->select('vGetDevices_v1.serial_number','merchant_name','TID')
                    ->distinct()
                    ->get());
            $merchant = count(DB::table('vTerminalIDs_v2')
                ->select('TID')
                ->distinct()
                ->get());
            $salesraw = DB::table('VDI_client_VDI_vMobeyTransactions_v1')->select('*')->where('settle_response_code' ,'=','0')->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
            $salestotal = number_format($salesraw,'2',',','.');
            $moneytotal = $salesraw;
            $salesvoid = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code' ,'!=', 0)
                ->where('authorisation_response_code','!=', 00)
                ->where('response_description','=','Void')
                ->count();
              $usertarget = Auth::user()->target;
            $targetnumber= number_format($usertarget,'0',',','.');
            $transactiontotal= $transactionsalesonly + $salesvoid;
            $transactionday1 = $this->transactionperdate(0);
            $transactionday2 = $this->transactionperdate(1);
            $transactionday3 = $this->transactionperdate(2);
            $transactionday4 = $this->transactionperdate(3);
            $transactionday5 = $this->transactionperdate(4);
            $transactionday6 = $this->transactionperdate(5);
            $transactionday7 = $this->transactionperdate(6);
            $transactioncountday1 = $this->transactionperdatecount(0);
            $transactioncountday2 = $this->transactionperdatecount(1);
            $transactioncountday3 = $this->transactionperdatecount(2);
            $transactioncountday4 = $this->transactionperdatecount(3);
            $transactioncountday5 = $this->transactionperdatecount(4);
            $transactioncountday6 = $this->transactionperdatecount(5);
            $transactioncountday7 = $this->transactionperdatecount(6);

            return view('dashboard',compact('transactiontotal','transactionfailonly',
                'transactionsalesonly','salestotal','salesvoid','devices','merchant','transactionday1',
                'transactionday2', 'transactionday3','transactionday4','transactionday5','transactionday6',
                'transactionday7','transactioncountday1','transactioncountday2','transactioncountday3',
                'transactioncountday4', 'transactioncountday5','transactioncountday6',
                'transactioncountday7','usertarget','moneytotal','targetnumber'));
        }
        else{
            $date= Carbon::now();
            $tempmid = Auth::user()->mid;
        $transactionsalesonly= DB::table('VDI_client_VDI_vMobeyTransactions_v1')
        ->select('*')
        ->where('response_code' ,'=', 0)
        ->where('authorisation_response_code','=', 00)
            ->where('mid','=',$tempmid)
            ->whereYear('transmission_date_time','=',$date->year)
        ->count();
        $transactionfailonly= DB::table('VDI_client_VDI_vMobeyTransactions_v1')
            ->select('*')
            ->where('response_code' ,'!=', 0)
            ->where('authorisation_response_code','!=', 00)
            ->where('mid','=',$tempmid)
            ->whereYear('transmission_date_time','=',$date->year)
            ->count();

        $devices = count(DB::table('vGetDevices_v1')
                ->join('vTerminalIDs_v2','vTerminalIDs_v2.merchant_id','=','vGetDevices_v1.merchant_id')
                ->select('vGetDevices_v1.serial_number')
                ->where('vTerminalIDs_v2.MID','=',Auth::user()->mid)
                ->distinct()
                ->get());
        $merchant = count(DB::table('vTerminalIDs_v2')
        ->select('TID')
        ->where('MID','=',Auth::user()->mid)
        ->distinct()
        ->get());
        $salesraw = DB::table('VDI_client_VDI_vMobeyTransactions_v1')->select('*')->where('settle_response_code' ,'=','0')->whereYear('transmission_date_time','=',$date->year)->where('mid','=',$tempmid)->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
        $salestotal = number_format($salesraw,'2',',','.');
        $salesvoid = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code' ,'!=', 0)
                ->where('authorisation_response_code','!=', 00)
                ->where('MID','=',Auth::user()->mid)
                ->where('response_description','=','Void')
                ->whereYear('transmission_date_time','=',$date->year)
                ->count();
        $transactiontotal= $transactionsalesonly + $salesvoid;
        $transactionday1 = $this->transactionperdate(0);
        $moneytotal = $salesraw;
        $transactionday2 = $this->transactionperdate(1);
        $transactionday3 = $this->transactionperdate(2);
        $transactionday4 = $this->transactionperdate(3);
        $transactionday5 = $this->transactionperdate(4);
        $transactionday6 = $this->transactionperdate(5);
        $transactionday7 = $this->transactionperdate(6);
        $transactioncountday1 = $this->transactionperdatecount(0);
        $transactioncountday2 = $this->transactionperdatecount(1);
        $transactioncountday3 = $this->transactionperdatecount(2);
        $transactioncountday4 = $this->transactionperdatecount(3);
        $transactioncountday5 = $this->transactionperdatecount(4);
        $transactioncountday6 = $this->transactionperdatecount(5);
        $transactioncountday7 = $this->transactionperdatecount(6);
        $usertarget = Auth::user()->target;
        $targetnumber= number_format($usertarget,'0',',','.');
        return view('dashboard',compact('transactiontotal','transactionfailonly','transactionsalesonly','salestotal','salesvoid','devices','merchant',
            'transactionday1','transactionday2', 'transactionday3','transactionday4','transactionday5',
            'transactionday6','transactionday7', 'transactioncountday1',
            'transactioncountday2','transactioncountday3','transactioncountday4',
            'transactioncountday5','transactioncountday6','transactioncountday7','usertarget','moneytotal','targetnumber'));
        }

        }
        else{
            return view('auth.login');
        }
        
    }
    public function showAdministrator(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
    
        if(Auth::check()){
         $user = DB::table('vdi_user')->get();
        return view('administration',compact('user'));
        }
        else{
            return view('auth.login');
        }

    }
    public function activation(Request $req){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
             $idchanged = $req->id;
        $user = DB::table('vdi_user')->where('id','=',$idchanged)->get();
        if($req->active == 0 || $req->active == null){
            $user = DB::table('vdi_user')->where('id','=',$idchanged)->update(['active'=>1]);
        }
        else{
            $user = DB::table('vdi_user')->where('id','=',$idchanged)->update(['active'=>0]);
        }

//        $user->save();
        return redirect()->back();
        }
        else{
            return view('auth.login');
        }
       
    }
    public function transactionperdate($day){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
             $date= Carbon::now()->subDay($day)->toDateString();
        if(Auth::user()->role == "admin"){
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('amount')
                ->where('settle_response_code' ,'=','0')
                ->whereDate('transmission_date_time',$date)
                ->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
            return $sales;
        }
        else{
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')->select('amount')->where('settle_response_code' ,'=','0')->where('mid','=',Auth::user()->mid)->whereDate('transmission_date_time',$date)->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
               return $sales;
        }

        }
        else{
            return view('auth.login');
        }
       
    }
    public function transactionperdatecount($day){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
             $date= Carbon::now()->subDay($day)->toDateString();
        if(Auth::user()->role == "admin"){
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')->select('*')->where('settle_response_code' ,'=','0')->whereDate('transmission_date_time',$date)->count();
            return $sales;
        }
        else{
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')->select('*')->where('settle_response_code' ,'=','0')->where('mid','=',Auth::user()->mid)->whereDate('transmission_date_time',$date)->count();
            return $sales;
        }
        }
        else{
            return view('auth.login');
        }
       
    }
    public function financepermonth($year,$month){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            if(Auth::user()->role == "admin"){
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('amount')
                ->where('settle_response_code' ,'=','0')
                ->whereYear('transmission_date_time','=',$year)
                ->whereMonth('transmission_date_time','=',$month)
                ->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
            return $sales;
        }
        else{
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('amount')
                ->where('settle_response_code' ,'=','0')
                ->where('mid','=',Auth::user()->mid)
                ->whereYear('transmission_date_time','=',$year)
                ->whereMonth('transmission_date_time',$month)
                ->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
            return $sales;
        }
        }
        else{
            return view('auth.login');
        }
        
    }
    public function financeperyear($year){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
             if(Auth::user()->role == "admin"){
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('amount')
                ->where('settle_response_code' ,'=','0')
                ->whereYear('transmission_date_time','=',$year)
                ->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
            return $sales;
        }
        else{
            $sales=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('amount')
                ->where('settle_response_code' ,'=','0')
                ->where('mid','=',Auth::user()->mid)
                ->whereYear('transmission_date_time','=',$year)
                ->sum('VDI_client_VDI_vMobeyTransactions_v1.amount');
            return $sales;
        }
        }
        else{
            return view('auth.login');
        }
       
    }

    public function profile()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
        $name = Auth::user()->name;
        $date= date('d-m-Y', strtotime(Auth::user()->created_at));
        $mid = Auth::user()->mid;
        return view('profile',compact('date','name','mid'));
        }
        else{
            return view('auth.login');
        }

    }


    function showTransaction(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            if(Auth::user()->role == "admin"){
            $transaction=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->get();
            return view('alltransaction',compact('transaction'));
        }
        else{
            $transaction=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('mid','=',Auth::user()->mid)
                ->get();
            return view('alltransaction',compact ('transaction'));
        }

        }
        else{
            return view('auth.login');
        }
        
    }
    function showSalesOnly(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
                   $tempmid = Auth::user()->mid;
        if(Auth::user()->role == "admin"){
            $banks = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code','=',0)
                ->where('authorisation_response_code','=',00)
                ->get();
            $transaction=DB::select('select * from VDI_client_VDI_vMobeyTransactions_v1 where response_code = 0 and authorisation_response_code = 00');
            $countbanks = DB::table('dm_bank_transaction_count')
                ->select('*')
                ->sum('transaction_count');

            if($countbanks == count($banks)){
                $bankdata = DB::table('dm_bank_transaction_count')
                    ->select('*')
                    ->where('card_type','=','Debit')
                    ->where('mid','=','admin')
                    ->orderBy('transaction_count','desc')
                    ->take(5)
                    ->get();
                $bankdatacredit = DB::table('dm_bank_transaction_count')
                    ->select('*')
                    ->where('card_type','=','Credit')
                    ->where('mid','=','admin')
                    ->orderBy('transaction_count','desc')
                    ->take(5)
                    ->get();

                return view('salesonly',compact('transaction','bankdebit','banks','bankdata','bankdatacredit'));
            }
            DB::table('dm_bank_transaction_count')->where('mid','=','admin')->delete();

                foreach($banks as $bank) {
                    $clearbankcard = str_replace(' ', '', $bank->card_number);
                    $bankcard = DB::table('VDI_BankCardCode')
                        ->select('*')
                        ->where('BIN', 'LIKE', substr($clearbankcard, 0, 6))
                        ->get();
                    if($bankcard->isEmpty()){
                        $bankrecord = DB::table('dm_bank_transaction_count')
                            ->select('*')
                            ->where('merchant_bank', '=', 'unknown')
                            ->where('card_type', '=', 'unknown')
                            ->where('mid', '=', 'admin')
                            ->get();
                        if ($bankrecord->count() > 0) {
                            foreach ($bankrecord as $bankrec) {
                                $id = $bankrec->id;
                                $banktransaction = BankTransactionCount::find($id);
                                $banktransaction->transaction_count = $banktransaction->transaction_count +1;
                                $banktransaction->card_type = $bankrec->card_type;
                                $banktransaction->mid = 'admin';
                                $banktransaction->save();
                            }
                        }
                        else
                        {
                            $banktransaction = new BankTransactionCount();
                            $banktransaction->merchant_bank = 'unknown';
                            $banktransaction->card_type = 'unknown';
                            $banktransaction->transaction_count = 1;
                            $banktransaction->mid = 'admin';
                            $banktransaction->save();
                        }

                    }
                    foreach ($bankcard as $bank1) {
                            $bankrecord = DB::table('dm_bank_transaction_count')
                                ->select('*')
                                ->where('merchant_bank', '=', $bank1->merchant_bank)
                                ->where('card_type', '=', $bank1->Type)
                                ->where('mid', '=', 'admin')
                                ->get();
                                if ($bankrecord->count() > 0) {
                                    foreach ($bankrecord as $bankrec) {
                                        $id = $bankrec->id;
                                        $banktransaction = BankTransactionCount::find($id);
                                        $banktransaction->transaction_count = $banktransaction->transaction_count +1;
                                        $banktransaction->card_type = $bankrec->card_type;
                                        $banktransaction->mid = 'admin';
                                        $banktransaction->save();
                                    }
                                }
                                else {
                                        $banktransaction = new BankTransactionCount();
                                        $banktransaction->merchant_bank = $bank1->merchant_bank;
                                        $banktransaction->card_type = $bank1->Type;
                                        $banktransaction->transaction_count = 1;
                                        $banktransaction->mid = 'admin';
                                        $banktransaction->save();

                                }

                    }
            }
            $bankdata = DB::table('dm_bank_transaction_count')
                ->select('*')
                ->where('card_type','=','Debit')
                ->where('mid','=','admin')
                ->orderBy('transaction_count','desc')
                ->take(5)
                ->get();
            $bankdatacredit = DB::table('dm_bank_transaction_count')
                ->select('*')
                ->where('card_type','=','Credit')
                ->where('mid','=','admin')
                ->orderBy('transaction_count','desc')
                ->take(5)
                ->get();

            return view('salesonly',compact('transaction','bankdebit','banks','bankdata','bankdatacredit'));
        }
        else{
            $banks = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code','=',0)
                ->where('authorisation_response_code','=',00)
                ->where('mid','=',Auth::user()->mid)
                ->get();
            $countbanks = DB::table('dm_bank_transaction_count')
                ->select('*')
                ->where('mid','=',Auth::user()->mid)
                ->sum('transaction_count');
            $transaction=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code','=',0)
                ->where('authorisation_response_code','=',00)
                ->where('mid','=',Auth::user()->mid)
                ->get();
            if($countbanks == count($banks)){
                $bankdata = DB::table('dm_bank_transaction_count')
                    ->select('*')
                    ->where('card_type','=','Debit')
                    ->where('mid','=',Auth::user()->mid)
                    ->orderBy('transaction_count','desc')
                    ->take(5)
                    ->get();
                $bankdatacredit = DB::table('dm_bank_transaction_count')
                    ->select('*')
                    ->where('card_type','=','Credit')
                    ->where('mid','=',Auth::user()->mid)
                    ->orderBy('transaction_count','desc')
                    ->take(5)
                    ->get();

                return view('salesonly',compact('transaction','bankdebit','banks','bankdata','bankdatacredit'));
            }
            DB::table('dm_bank_transaction_count')->where('mid','=',Auth::user()->mid)->delete();

            foreach($banks as $bank) {
                $clearbankcard = str_replace(' ', '', $bank->card_number);
                $bankcard = DB::table('VDI_BankCardCode')
                    ->select('*')
                    ->where('BIN', 'LIKE', substr($clearbankcard, 0, 6))
                    ->get();
                if($bankcard->isEmpty()){
                    $bankrecord = DB::table('dm_bank_transaction_count')
                        ->select('*')
                        ->where('merchant_bank', '=', 'unknown')
                        ->where('card_type', '=', 'unknown')
                        ->where('mid', '=', Auth::user()->mid)
                        ->get();
                    if ($bankrecord->count() > 0) {
                        foreach ($bankrecord as $bankrec) {
                            $id = $bankrec->id;
                            $banktransaction = BankTransactionCount::find($id);
                            $banktransaction->transaction_count = $banktransaction->transaction_count +1;
                            $banktransaction->card_type = $bankrec->card_type;
                            $banktransaction->mid = Auth::user()->mid;
                            $banktransaction->save();
                        }
                    }
                    else
                    {
                        $banktransaction = new BankTransactionCount();
                        $banktransaction->merchant_bank = 'unknown';
                        $banktransaction->card_type = 'unknown';
                        $banktransaction->transaction_count = 1;
                        $banktransaction->mid = Auth::user()->mid;
                        $banktransaction->save();
                    }

                }
                foreach ($bankcard as $bank1) {
                    $bankrecord = DB::table('dm_bank_transaction_count')
                        ->select('*')
                        ->where('merchant_bank', '=', $bank1->merchant_bank)
                        ->where('card_type', '=', $bank1->Type)
                        ->where('mid', '=', Auth::user()->mid)
                        ->get();
                    if ($bankrecord->count() > 0) {
                        foreach ($bankrecord as $bankrec) {
                            $id = $bankrec->id;
                            $banktransaction = BankTransactionCount::find($id);
                            $banktransaction->transaction_count = $banktransaction->transaction_count +1;
                            $banktransaction->card_type = $bankrec->card_type;
                            $banktransaction->mid = Auth::user()->mid;
                            $banktransaction->save();
                        }
                    }
                    else {
                        $banktransaction = new BankTransactionCount();
                        $banktransaction->merchant_bank = $bank1->merchant_bank;
                        $banktransaction->card_type = $bank1->Type;
                        $banktransaction->transaction_count = 1;
                        $banktransaction->mid = Auth::user()->mid;
                        $banktransaction->save();

                    }

                }
            }
            $bankdata = DB::table('dm_bank_transaction_count')
                ->select('*')
                ->where('card_type','=','Debit')
                ->where('mid','=',Auth::user()->mid)
                ->orderBy('transaction_count','desc')
                ->take(5)
                ->get();
            $bankdatacredit = DB::table('dm_bank_transaction_count')
                ->select('*')
                ->where('card_type','=','Credit')
                ->where('mid','=',Auth::user()->mid)
                ->orderBy('transaction_count','desc')
                ->take(5)
                ->get();

            return view('salesonly',compact('transaction','bankdebit','banks','bankdata','bankdatacredit'));
        }

        }
        else{
            return view('auth.login');
        }
 
    }
    function showFailureOnly(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            $tempmid = Auth::user()->mid;
        if(Auth::user()->role =="admin"){

            $transaction=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                    ->select('*')
                    ->where('response_code', '!=' ,0)
                    ->where('authorisation_response_code','!=',00)
                    ->where('response_description','=','Void')
                    ->get();
            return view('failtransaction',compact('transaction'));
        }
        else{

                $transaction=DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                    ->select('*')
                    ->where('response_code', '!=' ,0)
                    ->where('authorisation_response_code','!=',00)
                    ->where('response_description','=','Void')
                    ->where('mid','=',$tempmid)
                    ->get();
            return view('failtransaction',compact('transaction'));
        }

        }
        else{
            return view('auth.login');
        }
        

    }
    function showDevices(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            if(Auth::user()->role == "admin"){
            $device = DB::table('vGetDevices_v1')
                ->join('vGetMerchantInfo_v1','vGetMerchantInfo_v1.merchant_id','=','vGetDevices_v1.merchant_id')
                ->join('vTerminalIDs_v2','vGetMerchantInfo_v1.merchant_id','=','vTerminalIDs_v2.merchant_id')
                ->select('vGetDevices_v1.serial_number','merchant_name','TID')
                ->distinct()
                ->get();
            return view('devices',compact('device'));
        }
        else{
            $device = DB::table('vGetDevices_v1')
                ->join('vGetMerchantInfo_v1','vGetMerchantInfo_v1.merchant_id','=','vGetDevices_v1.merchant_id')
                ->join('vTerminalIDs_v2','vGetMerchantInfo_v1.merchant_id','=','vTerminalIDs_v2.merchant_id')
                ->select('vGetDevices_v1.serial_number','merchant_name','TID')
                ->where('vTerminalIDs_v2.MID','=',Auth::user()->mid)
                ->distinct()
                ->get();
            return view('devices',compact('device'));
        }

        }
        else{
            return view('auth.login');
        }
        
    }
    function showOperators(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            if(Auth::user()->role == "admin"){
            $operators = DB::table('VDI_vGetOperators_v1')
                ->join('vGetMerchantInfo_v1','VDI_vGetOperators_v1.merchant_id','=','vGetMerchantInfo_v1.merchant_id')
                ->join('vTerminalIDs_v2','VDI_vGetOperators_v1.merchant_id','=','vTerminalIDs_v2.merchant_id')
                ->select('VDI_vGetOperators_v1.operator_code','VDI_vGetOperators_v1.operator_name','merchant_code','merchant_name','last_login_date')
                ->where('active','=','1')
                ->where('deleted','=','0')
                ->distinct()
                ->get();
            return view('operator',compact('operators'));
        }
        else{
            $operators = DB::table('VDI_vGetOperators_v1')
                ->join('vGetMerchantInfo_v1','VDI_vGetOperators_v1.merchant_id','=','vGetMerchantInfo_v1.merchant_id')
                ->join('vTerminalIDs_v2','VDI_vGetOperators_v1.merchant_id','=','vTerminalIDs_v2.merchant_id')
                ->select('VDI_vGetOperators_v1.operator_code','VDI_vGetOperators_v1.operator_name','merchant_code','merchant_name','last_login_date')
                ->where('vTerminalIDs_v2.mid','=',Auth::user()->mid)
                ->where('active','=','1')
                ->where('deleted','=','0')
                ->distinct()
                ->get();
            return view('operator',compact('operators'));
        }

        }
        else{
            return view('auth.login');
        }
        

    }
    function changePassword(Request $request){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
             $request->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);
//        $user = DB::table('vdi_user')->select('*')->where('id','=',Auth::user()->id)->get();
        $id = Auth::user()->id;
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->update();
        return redirect('dashboard/profile')->with('message','Password Changed succesfully');
        }
        else{
            return view('auth.login');
        }
       
    }
    public function settarget(Request $request){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
        $id = Auth::user()->id;
        $target = User::find($id);
        $target->target = $request->settarget;
        $target->update();
        return redirect('dashboard/profile')->with('messagetarget','Target Set');
        }
        else{
            return view('auth.login');
        }
        
    }
    public function changePasswordEveryone(Request $request){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            $request->validate([
            'password' => 'required|min:6',
        ]);
//        $user = DB::table('vdi_user')->select('*')->where('id','=',Auth::user()->id)->get();
        $id = $request->id;
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->update();
        return redirect('administrator')->with('message','Password Changed succesfully');
        }
        else{
            return view('auth.login');

        }
        
    }

    private $excel;
    public function __construct(Exporter $excel)
    {
        $this->excel = $excel;
    }
    function exportToExcelAll(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
            return (new ExportAll())->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.xls');
        }
        else{
            return view('auth.login');
        }
    }
    function exportToExcelAllcsv(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
          return (new ExportAll())->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.csv');   
        }
        else{
            return view('auth.login');
        }
       
    }
    function exportToExcel(){
//   return Excel::download(new ExportTable(0,00),'testa.xls');
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
                    return (new ExportTable())->conditionstotake('0','=','00','=')->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.xls');
        }
        else{
            return view('auth.login');
        }

    }
    function exportToExcelcsv(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
                    return (new ExportTable())->conditionstotake('0','=','00','=')->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.csv');
        }
        else{
            return view('auth.login');
        }

    }
    public $response;
    function exportToExcelError(){
//    $this->response = 0;
//        return (new ExportTable('$this->response!=0'))->download('testerror.xls');
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
                    return (new ExportTable())->conditionstotake('0','!=','00','!=')->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.xls');
        }
        else{
            return view('auth.login');
        }

    }
    function exportToExcelErrorcsv(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
                    return (new ExportTable())->conditionstotake('0','!=','00','!=')->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.csv');
        }
        else{
            return view('auth.login');
        }

    }
    function exportToPDF()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
            if(Auth::user()->role =="admin"){
            $transaction = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->orderBy('transmission_date_time','asc')
                ->get();
            $pdf = PDF::loadview('pdf', compact('transaction'));
            $pdf->setpaper('A4','landscape');
            return $pdf->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.pdf');
        }
        else{
            $transaction = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('mid','=',Auth::user()->mid)
                ->orderBy('transmission_date_time','asc')
                ->get();
            $pdf = PDF::loadview('pdf',compact('transaction'));
            $pdf->setpaper('A4','landscape');
            return $pdf->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.pdf');
        }

        }
        else{
            return view('auth.login');
        }
        
    }
    function exportToPDFfail(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
            if(Auth::user()->role =="admin") {
            $transaction = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code', '!=' ,0)
                ->where('authorisation_response_code','!=',00)
                ->where('response_description','=','Void')
                ->orderBy('transmission_date_time','asc')
                ->get();
            $pdf = PDF::loadview('pdf', compact('transaction'));
            $pdf->setpaper('A4','landscape');
            return $pdf->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.pdf');
        }
        else{
            $transaction = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code', '!=' ,0)
                ->where('authorisation_response_code','!=',00)
                ->where('response_description','=','Void')
                ->where('mid','=',Auth::user()->mid)
                ->orderBy('transmission_date_time','asc')
                ->get();
            $pdf = PDF::loadview('pdf',compact('transaction'));
            $pdf->setpaper('A4','landscape');
            return $pdf->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.pdf');
        }

        }
        else{
            return view('auth.login');
        }

    }
    function exportToPDFsuccess(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
             if(Auth::user()->role =="admin"){
            $transaction = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code', '=' ,0)
                ->where('authorisation_response_code','=',00)
                ->orderBy('transmission_date_time','asc')
                ->get();
            $pdf = PDF::loadview('pdf', compact('transaction'));
            $pdf->setpaper('A4','landscape');
            return $pdf->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.pdf');
        }
        else{
            $transaction = DB::table('VDI_client_VDI_vMobeyTransactions_v1')
                ->select('*')
                ->where('response_code', '=' ,0)
                ->where('authorisation_response_code','=',00)
                ->where('mid','=',Auth::user()->mid)
                ->orderBy('transmission_date_time','asc')
                ->get();
            $pdf = PDF::loadview('pdf',compact('transaction'));
            $pdf->setpaper('A4','landscape');
            return $pdf->download('SalesReport'.Carbon::now()->format('d-M-Y H:i:s').'.pdf');
        }

        }
        else{
            return view('auth.login');
        }
       
    }
    function financeprojection(){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:" );
        }
        if(Auth::check()){
            $status = "normal";
        return view('projection',compact('status'));
        }
        else{
            return view('auth.login');
        }
    }
    function financeprojectionmonth(Request $request){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
             $status = "month";
        $user = DB::table('vdi_user')->where('id','=',Auth::user()->id)->get();
        $m1 = $this->financepermonth($request->projectionyear,1);
        $m2 = $this->financepermonth($request->projectionyear,2);
        $m3 = $this->financepermonth($request->projectionyear,3);
        $Q1 =$m1+$m2+$m3;
        $m4 =$this->financepermonth($request->projectionyear,4);
        $m5 = $this->financepermonth($request->projectionyear,5);
        $m6 = $this->financepermonth($request->projectionyear,6);
        $Q2 = $m4+$m5+$m6;
        $m7 =$this->financepermonth($request->projectionyear,7);
        $m8 = $this->financepermonth($request->projectionyear,8);
        $m9 = $this->financepermonth($request->projectionyear,9);
        $Q3 = $m7+$m8+$m9;
        $m10 =$this->financepermonth($request->projectionyear,10);
        $m11 = $this->financepermonth($request->projectionyear,11);
        $m12 = $this->financepermonth($request->projectionyear,12);
        $Q4 = $m10+$m11+$m12;
        if(Auth::user()->target =="0" || Auth::user()->target == null){
            $q1dana = $request->q1target;
            $q2dana = $request->q2target;
            $q3dana = $request->q3target;
            $q4dana = $request->q4target;
            $dana = $q1dana+$q2dana+$q3dana+$q4dana;
            $error = "Success";
            $user = DB::table('vdi_user')->where('id','=',Auth::user()->id)->update((['target'=>$dana]));
            return view('projection',compact('error','status','Q1','Q2','Q3','Q4','q1dana','q2dana','q3dana','q4dana'));
        }
        else{
            $q1dana = $request->q1target;
            $q2dana = $request->q2target;
            $q3dana = $request->q3target;
            $q4dana = $request->q4target;
            $dana = $q1dana+$q2dana+$q3dana+$q4dana;
            if($dana > Auth::user()->target){
                $error = "targetmore";
                $user = DB::table('vdi_user')->where('id','=',Auth::user()->id)->update((['target'=>$dana]));
                return view('projection',compact('error','status','Q1','Q2','Q3','Q4','q1dana','q2dana','q3dana','q4dana'));
            }
            else{
                $error = "nothing";
                return view('projection',compact('error','status','Q1','Q2','Q3','Q4','q1dana','q2dana','q3dana','q4dana'));
            }
        }

        }
        else{
            return view('auth.login');
        }
       
    }
    function financeprojectionyear(Request $request){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
            $status = "year";
        $target = $request->target;
        $duration = $request->duration;
        $sales = [];
        $year = $request->projectionyear;
        if($request->duration == null || $request->duration == 0){
            $data = $this->financeperyear($request->projectionyear);
            array_push($sales,$data);
            return view('projection',compact('status','sales','year','target','duration'));
        }
        else{
            for($i = 0 ; $i<$request->duration ; $i++){
                $data = $this->financeperyear($request->projectionyear+$i);
                array_push($sales,$data);
            }
            return view('projection',compact('status','sales','year','target','duration'));
        }

        }
        else{
            return view('auth.login');
        }
        
    }

    function mapping($name){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
        $data = DB::table('VDI_client_VDI_vMobeyTransactions_v1')->where('name','=',$name)->get();
        foreach($data as $dat){
        Mapper::map($dat->latitude,$dat->longitude);
        }
        return view('mapping');
        }
        else{
            return view('auth.login');
        }
        
    }
    function showbin(){
        if(Auth::check()){
         $condition = 'nothere';
        return view('newbin',compact('condition'));
        }
        else{
            return view('auth.login');
        }

    }

    function insertbin(Request $request){
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        if(Auth::check()){
                    $bankcode = DB::table('VDI_BankCardCode')
            ->select('*')
            ->where('BIN','=',$request->setbin)
            ->get();
            if($bankcode->isNotEmpty()){
                $status = 'fail';
                $condition = 'here';
                $binmessage = 'Duplicate BIN found in database';
                return view('newbin',compact('status','bankcode','binmessage','condition'));
            }
            else{
                DB::table('dm_bank_transaction_count')->delete();
                $status = 'success';
                $newbankcode = new BankCardCode();
                $newbankcode->BIN = $request->setbin;
                $newbankcode->merchant_bank = $request->setbankname;
                $newbankcode->Type = $request->settype;
                $binmessage = 'Added to Database';
                $newbankcode->save();
                $condition = 'here';
                return view('newbin',compact('status','newbankcode','binmessage','condition'));
            }
        }
        else{
            return view('auth.login');
        }

    }

}
