

<?php
 
use App\AccountTitle;
 
?>
@extends('layouts.master')
@section('title','Create Account Titles')

@section('content')

@include('layouts.toastr')


    @component('layouts._box')

        <form
            class="form-horizontal"
            action="{{route('storeTitle')}}"
            method="post"
            autocomplete="off">
            {{ csrf_field() }}


            <div class="form-group">
                <label for="exampleInputEmail1" class="col-md-2 control-label">Account Title</label>
                <div class="col-md-4">
                    <input type="text"
                           class="form-control "
                           id="exampleInputEmail1"
                           name="title"
                           value=""
                           aria-describedby="emailHelp"
                           placeholder="Enter Account Title">
                
                    
                </div>

                <label for="exampleInputEmail1" class="col-md-2 control-label">Account Group</label>
                <div class="col-md-4">
                 <select name="group" class="form-control">
                     <option>Select Account Group</option>
                     <option>Current Assets</option>
                     <option>Non-Current Assets</option>
                     <option>Current Liabilities</option>
                     <option>Non-Current Liabilities</option>
                     <option>Revenues</option>
                     <option>Expenses</option>
                     <option>Owners Equity</option>
                 </select>
                   
                </div>
            </div>


            <div class="form-group">
                <label for="exampleInputEmail1" class="col-md-2 control-label">Description</label>
                <div class="col-md-4">
                    <textarea name="description" style="resize: none;" class="form-control"></textarea>
                   
                </div>

     

 

            <div class="box-footer">

                <button type="submit" class="btn btn-primary"> 
                        Submit</button>
            </div>
        </form>



   <div class="table-responsive">


    <span class="badge badge-primary">
        
    <h5 style="font-weight: bold; font-size: 12px;">Explore All Charts of Account Titles  <i class="fa fa-long-arrow-down"></i> </h5>

    </span>
<br>
<br>
    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Group</th>
            <th>Description</th>            
            <th>Date & Time</th>
        </tr>
        </thead>
        <tbody>

            <?php 

          $titles =AccountTitle::get();

 ?>

            @foreach($titles as $title)

                <tr>
                    <td width="10%">{{$title->id}}</td>
                    <td>{{$title->title}}</td>
                    <td>{{$title->group}}</td>
                    <td>{{$title->description}}</td>
                    <td>{{$title->created_at}}</td>
                    
                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
       <th>Id</th>
            <th>Title</th>
            <th>Group</th>
            <th>Description</th>            
            <th>Date & Time</th>
        </tr>
        </tfoot>
    </table>
</div>

    @endcomponent


@endsection

 


@section('extra_js')

    @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>

 

@endsection



