@extends('layouts.master')
@section('title','Create Journal Name/Title')

@section('content')

@include('layouts.toastr')


    @component('layouts._box')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


        <form
            class="form-horizontal"
            action="{{route('storeEntryTitle')}}"
            method="post"
            autocomplete="off">
            {{ csrf_field() }}


            <div class="form-group">
                <label class="col-md-2 control-label">Title</label>
                <div class="col-md-4">
               
                 <input class="form-control" type="text" name="title">               
                    
                </div>

                <label  class="col-md-2 control-label">As At (Date)</label>
                <div class="col-md-4">
                     <input name="as_at" type="date" class="form-control">
                 
                </div>
            </div> 
                 <div class="form-group">
                <label  class="col-md-2 control-label">Company</label>
                <div class="col-md-4">
                   <input name="company_name" type="text" class="form-control" value="Franro Ltd" >
                   
                </div>

                
               </div>

 

            <div class="box-footer">

                <button type="submit" class="btn btn-primary"> 
                 Submit</button>
            </div>
        </form>

 
   <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
        <th>Id</th>
            <th>Title</th>
            <th>As At</th>
            <th>Co. Name</th>
            <th>Date Created</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
            @foreach($journal_titles as $journal_title)       
                <tr>
                    <td width="10%">{{$journal_title->id}}</td>
                    <td>{{$journal_title->title}}</td>                    
                    <td>{{$journal_title->as_at}}</td>                    
                    <td>{{$journal_title->company_name}}</td>                    
                    <td>{{$journal_title->created_at}}</td>
                    <td><a title="Create A New Journal Entry" href="{{route('create_journal_entry',$journal_title->id)}}"><i class="fa fa-plus"></i></a></td>                    
                </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
      <th>Id</th>
            <th>Title</th>
            <th>As At</th>
            <th>Co. Name</th>
            <th>Date Created</th>
            <th>Action</th>
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



