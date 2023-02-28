@extends('layouts.master')
@section('title','Create Journals')

@section('content')
@component('layouts._box')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 

 	<table id="addJournal" class="responsive-table display journal-entries" cellspacing="0">
                     		<thead>
                        		<tr>
                           			<th>Dr/Cr</th>
                           			<th>Account Title</th>
                           			<th>Description</th>
                           			<th>Debit Amount</th>
                           			<th>Credit Amount</th>
                           			<th>Actions</th>
                        		</tr>
                     		</thead>
                     		<tbody>
                        	<tr>
                            <input type="text" name="addmore[0][title_id]">
	                           <td>
	                              <select name="addmore[0][drcr]" >
	                                 <option id="dr" value="debi_t">Debit</option>
	                                 <option id="cr" value="credi_t">Credit</option>
	                              </select>
	                           </td> 
	                           <td>
	                              <select name="addmore[0][account_title]">
                                    @foreach($accountTitlesList as $accountTitle)
	                                   <option value="{{$accountTitle->id}}">{{$accountTitle->title}}</option>
                                    @endforeach
	                              </select>
	                           </td>
	                           <td style="width: 20%;">
	                              	<div class="input-field" id="textarea-input-field">
		                                 <textarea style="padding: 0;" class="materialize-textarea" name="addmore[0][description]" id="desc" cols="30" rows="2"></textarea>
		                                 <label for="desc">Description</label>
	                              	</div>
	                           </td>
                           		<td>
                              		<div class="input-field">
                                 		<input name="addmore[0][dr_amt]" type="number" min="0" step="0.01" class="dr_amt" value="0.00">
                                 		<label for="dr_amt" class="active">Amount</label>
                              		</div>
                           		</td>
	                          	<td>
	                              	<div class="input-field">
	                                 	<input name="addmore[0][cr_amt]"  type="number" class="cr_amt" value="0.00" >
	                                 	<label for="cr_amt" class="active">Amount</label>
	                              	</div>
	                           	</td>
                           		<td>
                              		<a name="add" id="add" class="waves-effect waves-light btn red add-entry">Add More</a>
                           		</td>
                        	</tr>
                     	</tbody>
                  	</table>
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

 

 <!-- add more fields -->
<script type="text/javascript">
   
    var i = 0;

       
    $("#add").click(function(){



        ++i;
   
        $("#addJournal").append('<tr><td><input type="hidden" name="addmore['+i+'][title_id]"></td><td><select name="addmore[0][drcr]"><option id="dr" value="0">Debit</option><option id="cr" value="1">Credit</option></select><td><select name="addmore[0][account_title]"><?php 
    $addArray = array($accountTitlesList);
       $rrr = $accountTitle->title;
        foreach($addArray as $value){
            echo "<option>". $rrr . "</option>";
        }
    

  ?></select></td></td><td><textarea style="padding: 0;" class="materialize-textarea" name="addmore['+i+'][description]" cols="30" rows="2"></textarea></td><td><input class="dr_amt" type="text" name="addmore['+i+'][dr_amt]" placeholder="Enter DR Amount" class="form-control" /></td><td><input class="cr_amt" type="text" name="addmore['+i+'][cr_amt]" placeholder="Enter CR Amount" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');


    });


    $(document).ready(function(){
    $("select.account_title").change(function(){
        var selectedAccount_title = $(".account_title option:selected").val();
        $.ajax({
            type: "POST",
            url: "process-request.php",
            data: { account_title : selectedAccount_title } 
        }).done(function(data){
            $("#response").html(data);
        });
    });
});
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    });  
   
</script>

<!-- end add more fields -->
@endsection



