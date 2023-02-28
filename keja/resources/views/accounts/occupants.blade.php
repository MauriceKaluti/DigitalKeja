
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
 
?>

@extends('layouts.master')
@section('title','All Occupants')
@section('content')
 
@include('layouts.toastr')

    <div class=" divider">
    </div>
 
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>            
            <th>Occupant Name</th>
            <th>Building Name / Room No.</th>
            <th>Payment History</th>            
            <th>Created At</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
            @foreach($occupants as $occupant)

            <?php 

         $rid = $occupant->room_id;
         $tid = $occupant->tenant_id;

        $tenant = DB::table('tenants')->where('id', '=', $tid)->first();
        $room = DB::table('rooms')->where('id', '=', $rid)->first();
        if ($room) {
        $building = DB::table('buildings')->where('id', '=', $room->building_id)->first();
             
        }
             ?>
        
                <tr>
                    <td width="10%">{{$occupant->id}}</td>
                     @if($tenant)
                    <td>{{$tenant->name}}</td>
                    @else
                    <td></td>
                    @endif
               
                    @if($room)
                    <td> <span class="badge">{{$building->name}} <a target="_blank" href="{{route('one.building',$building->id)}}"><i style="color: #fff;" class="fa fa-eye"></i> </a></span> / <span class="badge">{{$room->room_number}}</span></td>
                    @else
                    <td></td>
                    @endif

                    <td><a href="{{route('one.tenant',$occupant->tenant_id)}}"><span style="background-color: #FF00D0;" class="badge"><i class="fa fa-money"></i> Checkout</span></a></td>                
                    <td>{{$occupant->created_at}}</td>
                              

                     @if($room && $tenant)
                    <td><span  class="badge">Occupied</span> <span style="background-color: #F1B500;" class="badge"><a href="{{route('unLease',$occupant->tenant_id)}}"><i class="fa fa-remove"></i> Permanent Remove</a></span></td>
                    @else
                    <td><span class="badge" style="background-color: #FF0000; "><a style="color: #fff;" title="Ghost Lease" href="{{route('unLease',$occupant->tenant_id)}}"><i class="fa fa-trash"></i> Clear Ghost Lease</a></span></td>
                    @endif
                </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
       <th>Id</th>            
            <th>Occupant Name</th>
            <th>Building Name / Room No.</th>
            <th>Payment History</th>            
            <th>Created At</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>

 





@endsection

@section('js')
    @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>


     <script>

  


        $(document).on('click', 'a.lease-room', function () {
            swal({
                title: "Are you sure?",
                text: "You will detach this tenant from a unit!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                    if (willDelete) {
                        let uri = "{{  url('tenant/') }}";
                         uri += "/"+$(this).data('id');
                         uri +="/un-lease";

                        return window.open(uri)
                    } else {
                        swal("You have cancelled detachment!");
                    }
                });
        });
    </script>
 
@endsection
