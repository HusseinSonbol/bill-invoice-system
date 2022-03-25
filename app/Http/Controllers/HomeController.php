<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\item;
use App\Models\safe;
use App\Models\User;
use App\Models\item_bill;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $allSafes = safe::get();
        $allUsers = User::get();
        $allItems = item::get();
        return view('bill', ['allSafes' => $allSafes , 'allUsers' => $allUsers , 'allItems' => $allItems]);


    }

    public function getItem($id)
    {
       $item  =  item::where('id','=',$id)->get();
       return $item;
    }

    public function listBill(){
        $allBills=bill::with('user')->get();

        $allitems = DB::table('item_bills')
                 ->select('item_id', DB::raw('count(*) as total'))
                 ->groupBy('item_id')
                 ->get();
        //dd($allitems);
        return view('billList',['allBills'=>$allBills , 'allItems'=>$allitems]);
    }

    public function billProfile($id){
        $allBills=bill::with('user')->where('id','=',$id)->get();

        $allItems = item_bill::with('items')->where('bill_id','=',$id)->get();

        //dd($allItems);
        return view('billProfile',['allBills'=>$allBills , 'allItems'=>$allItems]);
    }

    public function submitBill(Request $req){
        try{
        $bill_id = bill::insertGetId(['user_id'=>$req->user ,'safe_id'=> $req->safe ,'total_price'=>$req->billPrice]);

        $rows = array();
        for($i = 0 ;  $i < count($req->items) ; $i++){
            $element = ['bill_id'=>$bill_id,"item_id"=>$req->items[$i], "sale_price"=>$req->sales[$i],"item_quantity"=>$req->quantites[$i], "total_item_price"=>$req->totalItem[$i]];

            array_push($rows, $element);
        }
        item_bill::insert($rows);
       return redirect()->route('bill-list')->with('status','bill inserted succesfully');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

}
