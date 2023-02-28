@extends('layouts.master')
@section('title',$room->name.' Details')
@section('content')

    <ul class="nav nav-pills mb-2 mr-1">
        @can('add_building')
            <li class="nav-item ml-2">
                <a class="btn btn-outline-primary" href="{{ route('room_create' ,['building' => $room->id]) }}">New
                    {{ trans('general.room') }}</a>
            </li>
        @endcan

        @can('edit_rooms')
            <li class="nav-item ml-2">
                <a class="btn btn-outline-primary" href="{{ route('room_edit' ,['room' => $room->id]) }}">Edit
                    {{ trans('general.room') }}
                </a>
            </li>
        @endcan
        @can('browse_building')
            <li class="nav-item ml-2">
                <a class="btn btn-outline-danger" href="{{ route('room_browse') }}">Back To  {{ trans('general.room') }}</a>
            </li>
        @endcan
    </ul>
<?php $landlord = $room->building->landlord; ?>
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
                <div class="box-body box-profile">

                    <div class="timeline-item-header">
                        <div class="timeline-comment">
                            <p><strong>Name</strong>: {{ $room->building->name }}</p>
                        </div>

                    </div>
                    <div class="timeline-item-post">

                        <div class="timeline-comment">
                            <p><strong>Land Lord</strong>: {{ $room->building->landlord->name }}</p>
                        </div>
                        <div class="timeline-comment">
                            <p><strong>Location</strong>: {{ $room->building->location }}</p>
                        </div>
                        <div class="timeline-comment">
                            <p><strong>No of Room</strong>: {{ $room->room_number }}</p>
                        </div>

                        <div class="timeline-comment">
                            <p><strong>Rent</strong>: {{ $room->rent }}</p>
                        </div>

                        <div class="timeline-comment">
                            <p><strong>Deposit</strong>: {{ $room->deposit}}</p>
                        </div>
                        <p>Rent Bills: </p>
                        @foreach(utilitiesBills() as $utility => $bill)

                            <div class="timeline-comment"
                                 style="border-bottom: 1px solid #FF0000; border-top:1px solid #FF000 "
                            >
                                <p>
                                    <strong>{{ $utility }}</strong>: {{ room_utility($room->id,'rent', $utility) }} </p>
                            </div>
                        @endforeach
                        <p>Deposit Bills: </p>
                        @foreach(utilitiesBills() as $utility => $bill)

                            <div class="timeline-comment"
                                 style="border-bottom: 1px solid #FF0000; border-top:1px solid #FF000 "
                            >
                                <p>
                                    <strong>{{ $utility }}</strong>: {{ room_utility($room->id,'deposit', $utility) }} </p>
                            </div>
                        @endforeach
                    </div>


                    <div class="timeline-comment">
                        <p><strong>BedRoom</strong>: {{ $room->bedrooms }}</p>
                    </div>

                    <div class="timeline-comment">
                        <p><strong>Status: </strong>{!! $room->status_name !!}</p>
                    </div>



                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li><a href="#tenants" data-toggle="tab">Tenant</a></li>
                    <li><a href="#payments" data-toggle="tab">Payments</a></li>
                </ul>
                <div class="tab-content">

                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tenants">

                        @include('tenant._data',['tenants' => $landlord->tenants()])
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane" id="payments">
                        @if(isset($room->lease->tenant->name))
                            <?php $tenant = $room->lease->tenant; ?>
                            @if(isset($tenant->lease->payments))
                                @include('reports.payment._data', ['payments' => $tenant->lease->payments])
                            @endif
                        @endif
                    </div>

                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection

@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />
@endsection
@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <script>
        $('#example').dataTable();
        $('table.tenant-table').dataTable();
    </script>
@endsection

