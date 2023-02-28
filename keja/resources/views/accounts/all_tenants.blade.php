
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
 
?>

@extends('layouts.master')
@section('title','All Tenants')
@section('content')
 

    <div class=" divider">
    </div>
 
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>            
            <th>Tenant Name</th>
            <th>ID No</th>
            <th>Phone</th>
            <th>Status</th>            
            <th>Date & Time</th>
            <th>Action</th>
            <th>Pay/Unlease</th>

        </tr>
        </thead>
        <tbody>
            @foreach($tenants as $tenant)

       
                <tr>
                    <td width="10%">{{$tenant->id}}</td>
                    <td>{{$tenant->name}}</td>
                    <td>{{$tenant->id_no}}</td>
                    <td>{{$tenant->phone_number}}</td>
                    <td>@if($tenant->is_active == 1) <span style="background-color: #ffb600" class="badge badge-primary">Active</span>@else<span style="background-color: red" class="badge badge-primary">Inactive</span>@endif</td>
                    <td>{{$tenant->created_at}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{route('one.tenant',$tenant->id)}}"><i class="fa fa-eye"></i> Explore</a>
                        

                    </td>

                    @if(isset($tenant->lease))
                        <?php 

                        $lease = Lease::where( 'tenant_id', $tenant->id )->first();

                         ?>


                       

                   <td> 
                     <a class="btn btn-primary" href="{{route('payManual',$tenant->id)}}"><i class="fa fa-money"></i> Pay Manual</a>


                    <span style="background-color: green;" class="badge badge-primary"><i class="fa fa-smile-o"></i> Leased</span> 

                    <br>
                    <form action="{{route('unLease',$lease->tenant_id)}}" method="POST">
                    {{csrf_field()}}

                    <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-remove"></i> Unlease</button>
                    </form>

                    <!-- <a data-id="{{$tenant->id}}" class='lease-room'> <i class="fa fa-remove"></i> Detach </a>  -->

                    </td>
                    @else
                    <td><span style="background-color: #f9c300;" class="badge badge-primary">Not Leased <i class="fa fa-frown"></i></span> 
                    </td>
                    

                    @endif

                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
       <th>Id</th>            
            <th>Tenant Name</th>
            <th>ID No</th>
            <th>Phone</th>
            <th>Status</th>            
            <th>Date & Time</th>
            <th>Action</th>
            <th>Pay/Unlease</th>
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
