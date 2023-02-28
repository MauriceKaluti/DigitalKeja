@extends('layouts.master')
@section('title','Lease')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />
@endsection


@section('content')


   @component('layouts._box')
       <ul class="nav nav-pills mb-3">
           @can('add_lease_room')
               <li class="">
                   <a href="{{ route('landlord_browse') }}" class="btn btn-outline-primary"> Back </a>
               </li>
           @endcan
       </ul>

       <div class="row">

           <div class="col-md-12">
               <div class="card card-white">
                   <div class="card-heading clearfix">
                       <h4 class="card-title">Manage Lease</h4>
                   </div>
                   <div class="card-body">

                       <div class="table-responsive">
                           <table id="example" class="display table-striped table-hover table" style="width: 100%;">
                               <thead>
                               <tr>
                                   <th>#</th>
                                   <th>Tenant</th>
                                   <th>Landlord</th>
                                   <th>Room</th>
                                   <th>Bedrooms</th>
                                   <th>Actions</th>
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($leases as $lease)
                                   @if( isset($lease->tenant->name) && isset($lease->room->building->landlord->name))
                                       <tr>
                                           <td>{{ @$lease->id }}</td>

                                           <td>{{ @$lease->tenant->name }}</td>
                                           <td>{{ @$lease->room->building->landlord->name}}</td>
                                           <td><a href="{{ route('landlord_read', ['landlord' => $lease->room->building->landlord->id]) }}">{{ @$lease->room->building->name }} | {{ @$lease->room->room_number }}</a> </td>
                                           <td>{{ @$lease->room->bedrooms }}</td>
                                           <td>
                                               @component('layouts._button')
                                                   @can('edit_lease_room')
                                                       <li><a href="{{ route('lease_edit',['lease' => $lease->id]) }}">Edit</a></li>
                                                   @endcan
                                                   @can('delete_lease_room')
                                                       <li>
                                                           <a href="{{ route('lease_delete', ['lease'  => $lease->id]) }}">
                                                               Delete
                                                           </a>


                                                       </li>
                                                   @endcan
                                               @endcomponent
                                           </td>
                                       </tr>
                                   @endif
                               @endforeach
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>

           </div>
       </div>
   @endcomponent

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <script>
        $('#example').dataTable();
    </script>
@endsection
