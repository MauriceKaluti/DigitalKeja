@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('content')
<div class="container-fluid">
   <?php
   $queryString = '';
   if (request()->has('building_id'))
   {
       $queryString = '?building_id='. request('building_id');
   }
   ?>
<ul class="nav nav-pills mb-5" style="margin-bottom: 10px">
   @can('add_rooms')
   <li class="mr-2">
      <a class="btn btn-primary" href="{{ url("building/room/create/{$queryString}") }}"><i class="fa fa-plus"></i> {{ __('Create A New Room') }}</a>
   </li>
   @endcan
   <li class="mr-2">
      <a href="{{ url('building/room/list') }}" class="btn btn-primary"><i class="fa fa-home"></i> All Rooms </a>
   </li>
</ul>
@include('livewire.room')
</div>
@endsection