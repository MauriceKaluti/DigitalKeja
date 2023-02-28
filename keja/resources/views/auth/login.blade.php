@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <form id="msform" method="POST" action="{{ route('login') }}" autocomplete="off
">
        @csrf
        <div class="form-group has-feedback">
            <input value="admin@admin.com" 
                id="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}"
                required
                placeholder="your emal address"
                autocomplete="email" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>


            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="form-group has-feedback">
            <input value="password" 
                id="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                placeholder="password"
                required
                autocomplete="current-password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <div class="align-content-between"></div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button id="keja_login" type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
<script type="text/javascript">
$(document).ready(function(){
    $("#keja_login").trigger('click'); 
});
</script>
@endsection
