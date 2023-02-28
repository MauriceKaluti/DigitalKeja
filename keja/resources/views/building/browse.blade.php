@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title','Manage Building')
@section('content')
<div class="container-fluid">
@if( request()->has('landlord_id'))
   <ul class="nav nav-pills mb-3">
      @can('add_building')
      <li class="">
         <a href="{{ route('building_create') }}" class="btn btn-outline-primary"> New Building </a>
      </li>
      @endcan
   </ul>
   @endif
      <h5 class="box-title">Browse Buildings</h5>
     <div class="card shadow-lg keja-round">
        <div class="card-body">
            <div class="table-responsive">
         @include('building._data')
      </div>
        </div>
     </div>
</div>
@endsection