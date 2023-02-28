@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title','Manage Landlords')
@section('extra_css')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}"/>
@endsection
@section('content')
<div class="container-fluid">
   <ul class="nav nav-pills mb-3">
      @can('add_landlords')
      <li class="mb-2">
         <a href="{{ route('landlord_create') }}"
            class="btn btn-outline-primary">  {{ trans('general.new') }} {{ trans('general.landlord') }} </a>
      </li>
      @endcan
      <li class="mb-2">
         <a href="{{ route('landlord_browse') }}"
            class="btn btn-outline-primary"> All Landlords </a>
      </li>
      <li class="mb-2">
         <a href="{{ route('landlord_browse' ,['active' => true]) }}"
            class="btn btn-outline-primary"> Active </a>
      </li>
      <li class="mb-2">
         <a href="{{ route('landlord_browse', ['active' => false]) }}"
            class="btn btn-outline-primary"> Inactive </a>
      </li>
   </ul>
  
   <div class="card shadow-lg keja-round">
      <div class="card-body">
         <h6 class="card-title mb-3">Manage Landlords</h6>
         <div class="table-responsive">
            <table class="row-border stripe table" id="kejaDisplayLandlords" style="width:100%">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Id</th>
                     <th>Phone</th>
                     <th>Email</th>
                     <th>Commission</th>
                     <th>Buildings</th>
                     <th>View</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
               <tfoot>
               </tfoot>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@section('extra_js')
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
@endsection