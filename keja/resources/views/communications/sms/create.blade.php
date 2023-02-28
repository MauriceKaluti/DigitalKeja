@extends('layouts.master')
@section('title','Send bulk SMS')
@section('content')
    <div class="col-md-12">
        <div class="box box-white">

            <div class="box-header">
                <h3 class="box-title align-content-center">{{ __('Send Bulk sms to tenants') }}</h3>
                <hr/>
            </div>

            <div class="box-body">
                <form action="{{ route('sms.store') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="message" class="control-label col-md-2">{{ __('general.message') }}</label>
                        <div class="col-md-6">
                            <textarea id="message" class="form-control" name="message"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="all_tenants" class="control-label col-md-2">{{ __('general.all') }} {{ __('general.tenant') }}</label>
                        <div class="col-md-6">
                            <input type="checkbox" id="all_tenants" onchange="sms.hidePhoneNumberInput()" name="all_tenants">
                        </div>
                    </div>
                    <div class="form-group phone_numbers">
                        <label for="phone" class="control-label col-md-2">{{ __('general.phone_numbers') }}</label>
                        <div class="col-md-6">
                            <textarea id="phone" class="form-control" name="phone" placeholder="separeated with commans e.g: 0712345678, 0711223344"></textarea>
                        </div>
                    </div>


                    <div class="box-footer">
                        <button class="btn btn-success   btn-sm">Send</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('js')
<script>
     class Sms {

         hidePhoneNumberInput(){

             // Get the checkbox
             var checkBox = document.getElementById("all_tenants");
             // Get the output text

             // If the checkbox is checked, display the output text
             if (checkBox.checked == true){

                 $("div.phone_numbers").addClass('hidden')
             } else {
                 $("div.phone_numbers").removeClass('hidden')
             }
         }
     }

     const  sms = new Sms();
</script>

@endsection
