@extends('layouts.master')
@section('title','Business Setting')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#business" data-toggle="tab">Business</a></li>
                    <li><a href="#sms" data-toggle="tab">Sms Templates</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="business">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                               @include('setting._business_form')
                            </div>
                            <!-- /.post -->
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="sms">

                        @include('setting._sms_template')
                    </div>
                    <!-- /.tab-pane -->

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
@section('js')
    @include('layouts._form-scripts')
    <script>
    </script>
@endsection
