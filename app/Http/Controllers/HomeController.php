<?php

namespace App\Http\Controllers;

use App\Models\bill;
use App\Models\item;
use App\Models\safe;
use App\Models\User;
use App\Models\item_bill;
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

}
