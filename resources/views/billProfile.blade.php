@extends('layouts.app')

@section('content')
<div class="container">
@foreach ($allBills as $bill )
<h5>Date and time  : {{$bill->created_at}} <br></h5>
<h5>Bill number  : {{$bill->id}} <br></h5>
<h5>Client Name  : {{$bill->user->name}} <br></h5>
@endforeach
<br>



<table class="table table-striped table-hover mt-4" id="myTable">
    <thead>
      <tr>
        <th scope="col" style="width: 7%">#</th>
        <th scope="col" class="w-25">item Name</th>
        <th scope="col" class="w-25">sale</th>
        <th scope="col" class="w-25">quantity</th>
        <th scope="col" class="w-25">total</th>

      </tr>
    </thead>
    <tbody>
        @foreach ($allItems as $item )
      <tr>
        <th scope="row">{{$item->id}}</th>
        <td>{{$item->items->name}}</td>
        <td>{{$item->sale_price}}%</td>
        <td>{{$item->item_quantity}}</td>
        <td>{{$item->total_item_price}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
<div class="text-center">
    <h4 class="text-success ">Bill Price  : {{$allBills[0]->total_price}}</h4>
</div>





</div>
@endsection
