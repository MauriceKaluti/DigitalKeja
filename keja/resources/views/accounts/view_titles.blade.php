@extends('layouts.master')
@section('title','Account Titles')
@section('content')
 

    <div class=" divider">
    </div>

   <div class="table-responsive">

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


<br>
<br><br><br>
   <div class="table-responsive">

    <table class="table display table-striped" id="example" >
        <thead>
        <tr>
       <th>Id</th>
            <th>ten</th>
            <th>rm</th>
        </tr>
        </thead>
        <tbody>
<?php  

$leases = DB::table("leases")->get();

 ?>
            @foreach($leases as $lease)
<?php  

$td = $lease->tenant_id;
$rd = $lease->room_id;

$tenant = DB::table("tenants")->where( 'id', '=', $td )->first();


$room = DB::table("rooms")->where( 'id', '=', $rd )->first();

 ?>
                <tr>
                    <td width="10%">{{$lease->id}}</td>
                    @if($tenant)
                    <td>{{$tenant->name}}</td>
                    @else
                    <td>N/A</td>

                    @endif

                          @if($room)
                    <td>{{$room->id}}</td>
                    @else
                    <td>N/D</td>

                    @endif
                   
                    
                </tr>
                @endforeach

        </tbody>
        <tfoot>
        <tr>
      <th>Id</th>
            <th>ten</th>
            <th>rm</th>  
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
@endsection