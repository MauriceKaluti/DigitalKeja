<?php
   use App\DB\Payment\MpesaTransaction;
   use App\DB\Lease\Payment;
   
   use Carbon\Carbon;
   ?>
@extends('keja.layouts.data_tables')
@extends('layouts.master')
@section('title',$tenant->name.' Details')
@section('content')
<div class="container-fluid">
   <ul class="nav nav-pills mb-3">
         <li class="me-2">
      <a href="{{ route('tenant_browse') }}" class="btn btn-outline-primary w-100 mb-3"><i class="fa fa-users"></i> All Tenants </a>
   </li>
      @if(! isset($tenant->lease->room))
      @can('add_lease')
      <li class="me-2">
         <a class="btn btn-outline-primary w-100 mb-3" href="{{ route('lease_create' ,['tenant' => $tenant->id]) }}">Assign
         a Unit <i class="fa fa-plus"></i></a>
      </li>
      @endcan
      @endif
      @can('edit_tenant')
      <li class="me-2">
         <a class="btn btn-outline-primary w-100 mb-3" href="{{ route('tenant_edit' ,['tenant' => $tenant->id]) }}"><i class="fa fa-edit"></i> Edit
         Tenant
         </a>
      </li>
      @endcan
      @can('unlease_lease_room')
      @if(isset($tenant->lease->room))
      <li class="me-2">
         <a class="btn btn-outline-primary w-100 mb-3" href="{{ route('tenant_un_lease' ,['tenant' => $tenant->id]) }}"> <i class="fa fa-minus"></i> Detach from {{ trans('general.room') }}</a>
      </li>
      @endif
      @endcan
   </ul>
   <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
         <button class="nav-link active" id="next-of-kin-tab" data-bs-toggle="tab" data-bs-target="#next-of-kin" type="button" role="tab" aria-controls="next-of-kin" aria-selected="true"><i class="fa fa-info-circle"></i>About</button>
         <button class="nav-link" id="payments-made-tab" data-bs-toggle="tab" data-bs-target="#payments-made" type="button" role="tab" aria-controls="payments-made" aria-selected="false"><i class="fa fa-money"></i> Payments</button>
         <button class="nav-link" id="tenant-account-tab" data-bs-toggle="tab" data-bs-target="#tenant-account" type="button" role="tab" aria-controls="tenant-account" aria-selected="false"><i class="fa fa-list"></i> Account</button>
      </div>
   </nav>
   <div class="tab-content" id="nav-tabContent">
      <div class="py-3"></div>
      <?php 
         $tenant_phone =  $tenant->phone_number;
         $cashIncome = 'Cash';
         $bankIncome = 'Bank';
         // $countC = App\DB\Lease\Payment::where('payment_method',$idd)->count();
         // $countC = json_decode(json_encode($countC));
         $mpesas = DB::table("mpesa_transactions")->where('MSISDN',$tenant_phone)->get();
         // $mpesas = DB::table("payments")->where('MSISDN',$tenant_phone)->get();
         // $mpesas = DB::table("mpesa_transactions")->where('MSISDN',$tenant_phone)->get();
         $cashes = DB::table("payments")->where('payment_method',$cashIncome)->sum('amount');
         $banks = DB::table("payments")->where('payment_method',$bankIncome)->sum('amount');
         $expenses = DB::table("expenses")->sum('amount');
         // expected rent
         $deposit = DB::table("rooms")->sum('deposit');
         $expected_rent = DB::table("rooms")->sum('rent');
         $expected_rent_utilities = DB::table("room_utilities")->sum('amount');
         // $mpesas = DB::table("mpesa_transactions")->sum('trans_amount');
         
         // var_dump($mpesas); die();
         
         ?>
      <div class="tab-pane fade show active" id="next-of-kin" role="tabpanel" aria-labelledby="next-of-kin-tab" tabindex="0">
         <div class="box box-primary">
            <div class="box-body box-profile">
               <!--<img class="profile-user-img img-responsive img-circle"-->
               <!-- src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User profile picture">-->
               <div class="timeline-item-post row">
                  <div class="timeline-comment col-md-4">
                     <p><strong>Name</strong>: {{ $tenant->name }}</p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Phone</strong>: {{ $tenant->phone_number}}</p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Email</strong>: {{ $tenant->email}}</p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Id No</strong>: {{ $tenant->id_no}}</p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Address</strong>: {{ $tenant->address}}</p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Building
                        name</strong>: {{ isset($tenant->lease->room->building) ? $tenant->lease->room->building->name: "--"}}
                     </p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>No
                        of {{ trans('general.room') }}</strong>: {{ isset($tenant->lease->room) ? $tenant->lease->room->room_number  : "--"}}
                     </p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p>
                        <strong>LandLord</strong>: {{ isset($tenant->lease->room) ? $tenant->lease->room->building->landlord->name: "--"}}
                     </p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Total Months
                        Occupied</strong>: {{ isset($tenant->lease) ? now()->diffInMonths(\Carbon\Carbon::parse($tenant->lease->created_at) ): "--"}}
                     </p>
                  </div>
                  <div class="timeline-comment col-md-4">
                     <p><strong>Lease Agreement</strong>: 
                     </p>
                     <?php 
                        $agreement_path = 'agreements/' . $tenant->lease_agreement;
                        $agreementExists = file_exists($agreement_path);
                         ?>
                     @if(!empty($tenant->lease_agreement && $agreementExists))
                     <a target="_blank" href="{{url('agreements',$tenant->lease_agreement)}}" alt="agreement" class="btn btn-primary keja-round mb-3 w-100" download=""><i class="fa fa-download"></i> Download Agreement</a>
                     @else
                     <span class="badge badge-warning bg-warning mb-3">No File. Upload Agreement Below!</span>
                     <hr>
                     <form action="{{route('agreement.update',$tenant->id)}}"  method="POST" enctype="multipart/form-data" autocomplete="off">
                        {{csrf_field()}}
                        @method('PUT')
                        <div class="col-md-4">
                           <input type="file" accept="pdf*/image*" 
                              id="lease_agreement" 
                              name="lease_agreement"
                              value="{{ old('lease_agreement', isset($tenant) ? $tenant->lease_agreement : '') }}"
                              aria-describedby="Lease Agreeement"
                              tile="Upload Tenant Lease Agreeement(PDF/">
                        </div>
                        <br>
                        <br>
                        <button onClick="this.form.submit(); this.disabled=true; this.value='Sending…'; " type="submit" class="btn btn-primary w-100"> <i class="fa fa-paper-plane"></i> Update Agreement</button>
                     </form>
                     @endif
                  </div>
               </div>
            </div>
         </div>
         @if(isset($tenant->kinable))
         <div class="table-responsive">
            <table class="table display table-striped" id="kin">
               <thead>
                  <tr>
                     <th>Name</th>
                     <th>Phone Number</th>
                     <th>Relation</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>{{ $tenant->kinable->name }}</td>
                     <td>{{ $tenant->kinable->phone_number }}</td>
                     <td>{{ $tenant->kinable->relation }}</td>
                  </tr>
               </tbody>
            </table>
         </div>
         @endif
      </div>
      <div class="tab-pane fade" id="payments-made" role="tabpanel" aria-labelledby="payments-made-tab" tabindex="0">
         <table id="kejaDisplay" class="table">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Amount</th>
                  <th>Code</th>
                  <th>Rent</th>
                  <th>Balance</th>
                  <th>Print</th>
                  <th>Date</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $exist = $tenant->lease;
                   ?>
               @if($exist)
               @foreach($mpesas as $mpesa)
               <?php 
                  // $receipt = Room::where( 'id', $id )->first();
                  $roomID = $tenant->lease->room->id;
                  $utilityRent = 'rent';
                  $required_rent = DB::table("room_utilities")->where( 'room_id', $roomID )->where( 'utility_type', $utilityRent )->sum('amount');
                   ?>
               <tr>
                  <td>{{$mpesa->first_name}} {{$mpesa->middle_name}} {{$mpesa->last_name}}</td>
                  <td>{{$mpesa->trans_amount}}</td>
                  <td>{{$mpesa->trans_id}}</td>
                  <td>{{$mpesa->MSISDN}}</td>
                  <td>{{$required_rent}}</td>
                  <td>{{($required_rent) - ($mpesa->trans_amount)}}</td>
                  <td><a href="{{route('one.mpesa_receipt',$mpesa->id)}}"><i class="fa fa-eye"></i>...</a></td>
                  <td>
                     {{$mpesa->created_at}}
                  </td>
               </tr>
               @endforeach
               @else
               @endif
            </tbody>
         </table>
      </div>
      <div class="tab-pane fade" id="tenant-account" role="tabpanel" aria-labelledby="tenant-account-tab" tabindex="0">
         <table class="row-border stripe table" id="kejaDisplay2" style="width:100%">
            <thead>
               <tr>
                  <th>Month</th>
                  <th>Amount</th>
                  <th>Paid</th>
                  <th>Balance</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach(\Innox\Classes\Repository\RentAccountRepository::monthlyGrouped($tenant) as $account)
               <tr>
                  <td>{!! $account['month'] !!}</td>
                  <td>{{  number_format(floatval($account['amount']) , 2) }}</td>
                  <td>{{  number_format(floatval($account['paid']) , 2) }}</td>
                  <td>{{  number_format(floatval($account['balance']) , 2) }}</td>
                  <td>
                     {!! $account['edit'] !!}
                     {!! $account['pay'] !!}
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</div>
@endsection