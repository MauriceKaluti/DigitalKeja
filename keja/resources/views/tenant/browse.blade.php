@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title','Tenants')
@section('extra_css')
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection
@section('content')
<div class="container-fluid">
 <ul class="nav nav-pills mb-3">
   @can('add_tenant')
   <li class="me-2">
      <a href="{{ route('tenant_create') }}" class="btn btn-outline-primary w-100 mb-3"> <i class="fa fa-user-plus"></i> New Tenant </a>
   </li>
   @endcan
</ul>
<div class="card shadow-lg keja-round">
    <div class="card-body">
        @include('tenant._data')
    </div>
</div>
</div>
 
@endsection
@section('extra_js')
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
@endsection