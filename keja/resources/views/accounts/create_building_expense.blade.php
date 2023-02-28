
<?php
 
use App\BuildingExpense;
 
use App\DB\Building\Building;
use App\DB\Landlord\Landlord;
 
?>

 @extends('layouts.master')
@section('title') Create Building Expense @endsection
@section('content')

  
@include('layouts.toastr')

    @can('browse_building')
          <ul class="nav nav-pills">
           <li class="">
                <a href="{{ url('accounts/opt_buildings') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-arrow-left"></i> Back to
                    Buildings </a>
            </li>
            <li class="">
                <a href="{{ url('accounts/buildings') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-arrow-left"></i> Explore </a>
            </li>
             <li class="">
                <a href="{{ route('building_browse') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-arrow-left"></i> Occupation Ratio </a>
            </li>
    
             <li class="">
                <a href="{{ url('building/create') }}" class="btn btn-outline-primary btn-rounded"><i class="fa fa-arrow-left"></i> Create
                    Building</a>
            </li>
        </ul>
    @endcan

    <div class="box box-white">
        <div class="box-heading"></div>
        <div class="box box-body">

            <form class="form-horizontal form-bordered" action="{{ route('storeBuildingExpenses') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="landlord_id" class="form-control" value="{{$landlord->id}}">   

                <div class="form-group">
      
                    <label class="control-label col-md-2"> Select Building </label>
                    <div class="col-md-4">
                        <select
                            class="select2 form-control"
                            name="building_id"
                            id="building_ids"
                        >
                            @foreach($all_buildings as $building)
                                <option value="{{ $building->id }}">{{ $building->name }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                <label class="control-label col-md-1"> Overseer </label>
                    <div class="col-md-4">

                        <input readonly="" name="overseer" class="form-control" value="{{Auth::user()->name}}">                 
                                    

                    </div>
                </div>
 

                <div class="form-group">
                    <label class="col-md-2 control-label">Particular</label>

                     <div class="col-md-4">
                        <input
                            name="expense_particular"
                            class="form-control"
                            value="{{ old('expense_particular') }}"
                        >
               
                    </div>

                    <label class="col-md-1">Expense Amount</label>

                    <div class="col-md-4">
                        <input
                            type="number"
                            class="form-control"
                            name="expense_amount"
                            value="{{ old('expense_amount') }}"
                            placeholder="e.g. 2500">
                     
                    </div>

                </div>


                <div class="box-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>


            </form>



   <div class="table-responsive">


    <span class="badge badge-primary">
        
    <h5 style="font-weight: bold; font-size: 12px;">Explore All Building Expenses  <i class="fa fa-long-arrow-down"></i> </h5>

    </span>
<br>
<br>
    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Building Name</th>
            <th>Landlord Name</th>
            <th>Particular</th>
            <th>Amount</th>
            <th>Overseer</th>            
            <th>Date & Time</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

            <?php 

          $expenses =BuildingExpense::get();

             ?>

            @foreach($expenses as $expense)

            <?php
             
            $expense_building = Building::where( 'id', $expense->building_id )->first();

            $l_id = $expense_building->landlord_id;

            $expense_landord = Landlord::where( 'id', $l_id )->first();

             ?>

                <tr>
                    <td width="10%">{{$expense->id}}</td>
                    <td>{{$expense_building->name}}</td>
                    <td>{{$expense_landord->name}}</td>
                    <td>{{$expense->expense_particular}}</td>
                    <td>{{$expense->expense_amount}}</td>
                    <td>{{$expense->overseer}}</td>
                    <td>{{$expense->created_at}}</td>
                    <td><i class="fa fa-edit"></i> &nbsp&nbsp
                    <i class="fa fa-trash"></i></td>
                    
                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
      <th>Id</th>
            <th>Building Name</th>
            <th>Landlord Name</th>
            <th>Particular</th>
            <th>Amount</th>
            <th>Overseer</th>            
            <th>Date & Time</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>
        </div>
    </div>

@endsection



@section('extra_js')
    @include('layouts._form-scripts')

        @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>


 
    <script>
           $(document).ready(function () { 
            $('#landlord_id').on('change',function(e){
            console.log(e);
            var landlord_id = e.target.value;
            //console.log(landlord_id);
            //ajax
            $.get('/ajax?landlord_id='+ landlord_id,function(data){
                //success data
               //console.log(data);
                var building_id =  $('#building_id').empty();
                $.each(data,function(create,bObj){
                    var option = $('<option/>', {id:create, value:bObj});
                    building_id.append('<option value ="'+bObj+'">'+bObj+'</option>');
                });
            });
        });
    });
    </script>
@endsection
