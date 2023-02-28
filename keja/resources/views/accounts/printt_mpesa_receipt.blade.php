
<?php
 
use App\DB\Payment\MpesaTransaction;
use App\DB\Lease\Payment;
use App\DB\Lease\Lease;
use App\DB\Tenant;
use App\User;
 
?>

@extends('layouts.master')
@section('title','Preview/Download Mpesa Receipt')
@section('content')
 

    <div class=" divider">
    </div>
<?php 
// $mpesa_receiptsA = Payment::with('lease');


    $mpesa_receiptMonth = $mpesa_receipt->created_at->format('m/Y');


 ?>
 

 <div id="printingDiv" class="container">
  <div class="card">
<div class="card-header">
Invoice
<strong>FR-{{$mpesa_receipt->trans_id}}</strong> 
<br><br>
  <span class="float-right"> <strong></strong> <span style="background-color: green;" class="badge badge-primary">Ksh {{$mpesa_receipt->trans_amount}} PAID Via {{$mpesa_receipt->transaction_type}} | At: {{$mpesa_receipt->created_at}}</span></span>
  <br><br>
  <span class="float-right"> <strong></strong> <span style="background-color: #FF9800;" class="badge badge-primary">Mpesa Rent Payment | Month: {{$mpesa_receiptMonth}}</span></span>

</div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<h6 class="mb-3">From:</h6>
<div>
<strong>Accounts MD</strong>
</div>
<div>Franro Holdings</div>
<div>00100, Nairobi</div>
<div>Email: info@franroholdings.com</div>
<div>Phone: +254 722 362 432</div>
</div>

<div class="col-sm-6">
<h6 class="mb-3">To:</h6>
<div>
<strong>Tenant</strong>
</div>
<div>Name:  @if(!empty($mpesa_receipt_tenant))
                     {{$mpesa_receipt_tenant->name}} 
                    @else                    
                    @endif</div>
<div>ID No: @if(!empty($mpesa_receipt_tenant))
                     {{$mpesa_receipt_tenant->id_no}}
                    @else                    
                    @endif </div>
<div>Email: @if(!empty($mpesa_receipt_tenant))
                     {{$mpesa_receipt_tenant->email}} 
                    @else                    
                    @endif </div>
<div>Phone: @if(!empty($mpesa_receipt_tenant))
                     {{$mpesa_receipt_tenant->phone_number}}
                    @else                    
                    @endif </div>
</div>

    

</div>


    <?php       

    // $sameMonthPayments = Payment::get(["*",\DB::raw('MONTH(created_at) as month')])->groupBy('month');

//     $paymentsByYear = $sameMonthPayments;

// foreach ($paymentsByYear as $month => $payments) {
//  echo "<h2>$month</h2>";
//  echo "<ul>";
//    foreach ($payments as $payment) {
//      echo "<li>".$payment->name."</li>";
//    }
//  echo "</ul>";
// }
    $noma1 = $mpesa_receipt->created_at->format('Y-m');
    $tena = $mpesa_receipt_tenant['phone_number'];
        $id = $mpesa_receipt->id;

     
    $sameMonthPayments = Payment::where(('created_at'),$noma1)->where(('tenant_id'),$tena)->get();

  


        // single receipt

           $singleMonthPayments = DB::table("mpesa_transactions")
        // ->select("id","tenant_id","created_at")
        ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m'))"),"$noma1")

        ->where(('MSISDN'),$tena)
        ->where('id','=',$id)

        ->get();

         $sumTotal = DB::table("mpesa_transactions")
        // ->select("id","tenant_id","created_at")
        ->where(DB::raw("(DATE_FORMAT(created_at,'%Y-%m'))"),"$noma1")
        ->where(('MSISDN'),$tena)
        ->where('id','!=',$id)
        ->sum('mpesa_transactions.trans_amount');


        // $relatedProducts = Product::where('id','!=',$id)->get();

    // var_dump($noma1); die();

     ?>



     @if(count($sameMonthPayments) > 0)


<div class="container table-responsive-sm">
    <!-- <h3>Other Payments Made This Month</h3> -->

    <h3><span class="float-right"> <strong></strong> <span style="background-color: #708090;" class="badge badge-primary">Other Mpesa Payments Made During The Month: {{$mpesa_receiptMonth}}</span></span></h3>
<table class="table table-striped">
<thead>
<tr>
<th class="center">#</th>
<!-- <th>Tenant</th> -->
<th>Item</th>
<th>Receipt Date/Time</th>

  <th class="center">Reference Code</th>
<th>Amount (Ksh)</th>
</tr>
</thead>
<tbody>




    @foreach($sameMonthPayments as $sameMonthPayment)

       <?php
            $mpesa_receipt_tenantr = Tenant::where( 'id', $sameMonthPayment->MSISDN )->first();

          

            $mpesa_receipt_servedr = 'Self Served - Mpesa';
            // $mpesa_receipt_servedr = User::where( 'id', $sameMonthPayment->user_id )->first();
           
            ?>

<tr>
<td class="center">{{$sameMonthPayment->id}}</td>
<td class="left">{{$sameMonthPayment->transaction_type}}</td>
<td class="left">{{$sameMonthPayment->created_at}}</td>
<td class="center">{{$sameMonthPayment->trans_id}}</td>
<td>{{$sameMonthPayment->trans_amount}}</td>
</tr>
 
                @endforeach
 
</tbody>
</table>
</div>

@else


<div class="container table-responsive-sm">
    <!-- <h3>Other Payments Made This Month</h3> -->

    <h3><span class="float-right"> <strong></strong> <span style="background-color: #708090;" class="badge badge-primary">Single Mpesa Payment Details For The Month: {{$mpesa_receiptMonth}}</span></span></h3>
<table class="table table-striped">
<thead>
<tr>
<th class="center">#</th>
<!-- <th>Tenant</th> -->
<th>Item</th>
<th>Receipt Date/Time</th>

  <th class="center">Reference Code</th>
<th>Amount (Ksh)</th>
</tr>
</thead>
<tbody>




    @foreach($singleMonthPayments as $singleMonthPayment)

       <?php
            $mpesa_receipt_tenantr = Tenant::where( 'phone_number', $singleMonthPayment->MSISDN )->first();

          

            $mpesa_receipt_servedr = 'Self Served - Mpesa';
           
            ?>

<tr>
<td class="center">{{$singleMonthPayment->id}}</td>
<td class="left strong">{{$mpesa_receipt_tenantr->name}}</td>
<td class="left">{{$singleMonthPayment->transaction_type}}</td>
<td class="left">{{$singleMonthPayment->created_at}}</td>
<td class="center">{{$singleMonthPayment->trans_id}}</td>
<td>{{$singleMonthPayment->trans_amount}}</td>
</tr>
 
@endforeach
 
</tbody>
</table>
</div>
 
@endif



    
<div class="row">
<div class="col-lg-4 col-sm-5">

</div>

<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear">
<tbody>
<tr>
<td class="left">
<strong>Subtotal</strong>
</td>
<td class="right">{{(($sumTotal)+($mpesa_receipt->trans_amount)) - ((0.16) * (($sumTotal)+($mpesa_receipt->trans_amount))) }}</td>
</tr>
<tr>
<td class="left">
<strong>Discount (0%)</strong>
</td>
<td class="right">Ksh 0</td>
</tr>
<tr>
<td class="left">
 <strong>VAT (16%)</strong>
</td>
<td class="right">{{(0.16) * (($sumTotal)+($mpesa_receipt->trans_amount))}}</td>
</tr>
<tr>
<td class="left">
<strong>Total(Monthly Payments)</strong>
</td>
<td class="right">
<strong>Ksh. {{(($sumTotal)+($mpesa_receipt->trans_amount))}}</strong>
</td>
</tr>
</tbody>
</table>

</div>

</div>

</div>
</div>
</div>

<div id="editor"></div>
<p align="center"><button type="button" id="dwnld_btn" onclick="generatePDF()" class="btn btn-warning"><i class="fa fa-download"></i> Download Mpesa Receipt</button></p>

<p align="center"><button type="button" id="print_btn" onclick="printpage()" class="btn btn-success"><i class="fa fa-print"></i> Print Mpesa Receipt</button></p>




@endsection

@section('js')
    @include('layouts._datepicker')
 

    <script type="text/javascript">
    function printpage() {
         var printButton = document.getElementById("printingDiv");
         // printButton.style.visibility = 'hidden';
                   $("#print_btn").hide();
                   $("#dwnld_btn").hide();

        document.title = "Mpesa Receipt For Payment";
        document.URL   = "www.franroholdings.com";

        window.print();
        // printButton.style.visibility = 'hidden';
                   $("#print_btn").show();
                   $("#dwnld_btn").show();


    }
</script>


@endsection
