<?php use App\JournalTitle; ?>

@extends('layouts.master')
@section('title','Explore All Posted Journal Entries')

@section('content')



    @component('layouts._box')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 


           <div  class="table-responsive">

    <table class="table display table-striped payment-report-table" id="example" >
        <thead>
        <tr>
        <th>Id</th>
            <th>Posted As(DR/CR)</th>
            <th>As At</th>
            <th>Journal Title</th>
            <th>Accounting Title</th>
            <th>Desc</th>
            <th>Dr Amnt</th>
            <th>Cr Amnt</th>
            <th>Date Created</th>

        </tr>
        </thead>
        <tbody>
            @foreach($journal_entries as $journal_entry)

            <?php 
            $DCR = $journal_entry->drcr;    
            $t_idd = $journal_entry->title_id;
            $title_entry = JournalTitle::where('id',$t_idd)->first();
             ?>       
                <tr>
                    <td width="10%">{{$journal_entry->id}}</td>
                    <td>{{$title_entry->as_at}}</td>                    
                    <td>{{$title_entry->title}}</td>                    
                    <td> @if ($DCR == 'debi_t') 

                        DR

                        @elseif ($DCR == 'credi_t') 

                        CR

                        @endif
               
            </td>                    
                    <td>{{$journal_entry->account_title}}</td>                    
                    <td>{{$journal_entry->description}}</td>                    
                    <td>{{$journal_entry->dr_amt}}</td>                    
                    <td>{{$journal_entry->cr_amt}}</td>                    
                    <td>{{$journal_entry->created_at}}</td>
                    <!-- <td><a title="Print A New Journal Entry" href="{{route('preview_journal_entry',$journal_entry->id)}}"><i class="fa fa-plus"></i></a></td>                     -->
                </tr>
                @endforeach



        </tbody>
        <tfoot>
        <tr>
   <th>Id</th>
            <th>Posted As(DR/CR)</th>
            <th>As At</th>
            <th>Journal Title</th>
            <th>Accounting Title</th>
            <th>Desc</th>
            <th>Dr Amnt</th>
            <th>Cr Amnt</th>
            <th>Date Created</th>
        </tr>
        </tfoot>
    </table>
</div>
    @endcomponent


@endsection

 


@section('extra_js')

  <script>
   
   $('#select_id').on('change', function()
{
    // alert(this.value); or alert($(this).val());

      if ($(this).val() == 'debi_t') {
    $(".cr_amt").attr("disabled", "disabled");
  } else {
    $(".cr_amt").removeAttr("disabled");
  }

    if ($(this).val() == 'credi_t') {
    $(".dr_amt").attr("disabled", "disabled");
  } else {
    $(".dr_amt").removeAttr("disabled");
  }



});

// have credit disabled on page load
  $(".cr_amt").prop("disabled",true);
 </script>


 
    @include('layouts._datatable')
    @include('layouts._datepicker')
    <script>
        $('table').DataTable()
        $('input.date').datepicker()
    </script>


@endsection



