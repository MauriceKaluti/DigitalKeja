
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
 

 <body >

    <div class=" divider">
    </div>
 
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="bodyData" >
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

 


</body>


@endsection

@section('js')
    @include('layouts._datatable')
    @include('layouts._datepicker')

    <script>

    $(function() {
    $('#bodyData').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ url('accounts/tenants_data/getTenantData') }}',
    columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'email', name: 'email' }
    ]
    });
    });
    
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
