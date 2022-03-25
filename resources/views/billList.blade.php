@extends('layouts.app')

@section('content')
<div class="container">


<table class="table table-striped table-hover" id="myTable">
    <thead>
      <tr>
        <th scope="col" style="width: 7%">#</th>
        <th scope="col" class="w-25">Client Name</th>
        <th scope="col" class="w-25">date and time</th>
        <th scope="col" class="w-25">action</th>

      </tr>
    </thead>
    <tbody>
        @foreach ( $allBills as $bill )
      <tr>
        <th scope="row">{{$bill->id}}</th>
        <td>{{$bill->user->name}}</td>
        <td><span class="sales">{{$bill->created_at}}</span></td>
        <td><a href="{{route('bill-profile',$bill->id)}}" class="btn btn-primary">View</a></td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="row mb-4">
      <div class="offset-2 col-md-3">
        <span class="h4">Total Bills :{{count($allBills)}}</span>
      </div>
      <div class="offset-2 col-md-3">
          <span class="h4">Total Items : {{count($allItems)}} </span>
      </div>
  </div>
</div>
@endsection
