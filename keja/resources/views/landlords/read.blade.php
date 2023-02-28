@extends('layouts.master')
@section('title',$landlord->name.' Details')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body  box-profile">
                    <ul class="nav nav-pills mb-2 mr-1">
                        @can('add_building')
                            <li class="nav-item ml-2">
                                <a class="btn btn-outline-primary"
                                   href="{{ route('building_create' ,['landlord' => $landlord->id]) }}">New
                                    Building</a>
                            </li>
                        @endcan

                        @can('delete_landlords')
                            <li class="nav-item ml-2">
                                <a class="btn btn-outline-primary"
                                   href="{{ route('landlord_delete' ,['landlord' => $landlord->id]) }}">
                                    Delete Landlord
                                </a>
                            </li>
                        @endcan

                        @can('edit_landlords')
                            <li class="nav-item ml-2">
                                <a class="btn btn-outline-primary"
                                   href="{{ route('landlord_edit' ,['landlord' => $landlord->id]) }}">Edit
                                    Landlord
                                </a>
                            </li>
                        @endcan
                        @can('browse_landlords')
                            <li class="nav-item ml-2">
                                <a class="btn btn-outline-danger" href="{{ route('landlord_browse') }}">Back to
                                    Landlord</a>
                            </li>

                        @endcan
                            @can('transactions_landlords')
                                <li class="nav-item ml-2">
                                    <a class="btn btn-outline-danger" href="{{ route('landlord_deduction' , ['landlord'  => $landlord->id]) }}">
                                        Deductions </a>
                                </li>
                            @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                         src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="User profile picture">

                    <h3 class="profile-username text-center">{{ $landlord->name }}</h3>
                    <ul class="list-group list-group-unbordered">

                        <li class="list-group-item">
                            <b>Phone Number</b> <a class="pull-right"> {{ $landlord->phone_number }}</a>

                        </li>

                        <li class="list-group-item">
                            <b>Email</b> <a class="pull-right"> {{ $landlord->email }}</a>

                        </li>

                        <li class="list-group-item">
                            <b>Address</b> <a class="pull-right"> {{ $landlord->address }}</a>

                        </li>

                        <li class="list-group-item">
                            <b>Account No</b> <a class="pull-right"> {{ $landlord->acount_number }}</a>

                        </li>

                        <li class="list-group-item">
                            <b>Account Name</b>

                        </li>
                        <li class="list-group-item">
                            {{ $landlord->account_name }}

                        </li>

                        <li class="list-group-item">
                            <b>Bank</b> <a class="pull-right"> {{ $landlord->bank }}</a>
                        </li>

           

                    </ul>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>


        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class=" @if(! request()->has('start_date'))  active @endif "><a href="#building" data-toggle="tab">Building</a></li>

                    <li><a href="#payments" data-toggle="tab">{{ trans('general.disburse') .' '. trans('general.amount') }}</a></li>
                    <li class=" @if( request()->has('start_date'))  active @endif "><a href="#paymentsReport" data-toggle="tab">{{ trans('general.payment') .' '. trans('general.report') }}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if(! request()->has('start_date'))  active @endif " id="building">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                @include('building._data' , ['buildings' => $landlord->buildings])
                            </div>
                            <!-- /.post -->
                        </div>
                    </div>

                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="payments">
                        <div class="table-responsive">
                            <table
                                class="disburse-table table table-striped display" width="100%">
                                <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Reference No</th>
                                    <th>Date Disbursed</th>
                                    <th>User Responsible</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($landlord->disburses as $disburse)
                                    <tr>
                                        <td>{{ $disburse->amount }}</td>
                                        <th>{{ $disburse->payment_method }}</th>
                                        <th> {{ $disburse->reference_number }}</th>
                                        <td>{{ $disburse->disburse_at }}</td>
                                        <td>{{ $disburse->user->name }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>{{ setting('company_currency').' '. number_format($landlord->disburses->sum('amount') , 2) }}</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <!----- /. start Payment Report ./ --->
                    <div class="tab-pane @if(request()->has('start_date'))  active @endif " id="paymentsReport">
                        <h3>Report</h3>
                        <form >
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date"> Start date</label>
                                   <input
                                       type="text"
                                       class="form-control date"
                                       name="start_date"
                                       value="{{ old('start_date') , request()->has('payment_start_date') ? request('payment_start_date') : ''}}"

                                   >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label for="start_date"> End date</label>
                                    <input
                                        type="text"
                                        class="form-control date"
                                        name="end_date"
                                        value="{{ old('end_date') , request()->has('end_date') ? request('end_date') : ' '}}"
                                    >
                                </div>
                            </div>
                           <div class="box-footer">
                               <button type="submit" class="btn btn-success">Pull</button>
                           </div>
                          @include('reports.payment._data',['payments' => $payments])
                        </form>
                    </div>

                    <!----- /. end Payment Report ./ --->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>

    </div>



@endsection
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}"/>
@endsection
@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    @include('layouts._datepicker')
    <script>
        $('#example').dataTable();
        $('table.tenant-table , table.disburse-table ,  table.payment-report-table').dataTable();
        $("input.date").datepicker()
        $('a.sidebar-toggle').trigger('click')
    </script>
@endsection
