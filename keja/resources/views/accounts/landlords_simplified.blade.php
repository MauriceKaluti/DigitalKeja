
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\DB\Landlord\Landlord;
use App\DB\Building\Building;
use App\DB\Building\Room;
use App\User;
 
?>

@extends('layouts.master')
@section('title','Landlord Expected Rent Per Building')
@section('content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 


    <div class=" divider">
    </div>
<?php 


  $landlords =Landlord::get();

 ?>
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Landlord Name</th>
            <th>Phone</th>
            <th>Created At</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
            @foreach($landlords as $landlord)
 <tr> 
                    <td>{{$landlord->id}}</td>
                    <td>{{$landlord->name}}</td>
                    <td>{{$landlord->phone_number}}</td>
                    <td>{{$landlord->created_at}}</td>    
 <td> 

                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('one.landlord',$landlord->id)}}"><i class="fa fa-money"></i> Disburse</a>
                        <br> 
                        <a style="margin-bottom: 10px;" class="btn btn-primary" href="{{route('landlord_read',$landlord->id)}}"><i class="fa fa-university"></i> Check Buildings</a> 
                        <br>
                        <a class="btn btn-primary" href="{{route('landlord_edit',$landlord->id)}}"><i class="fa fa-refresh"></i> Update Landlord Info</a> 

                    </td>
                </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
        <th>Id</th>
            <th>Landlord Name</th>
            <th>Phone</th>
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
 <script type="text/javascript">
     

     function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);
 </script>
@endsection
