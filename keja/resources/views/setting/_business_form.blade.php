<form class="form-horizontal" method="post" action="{{ route('setting_store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group mb-3">
        <label class="control-label col-md-2"> Business Name</label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_name"
                class="form-control"
                value="{{ old('company_name', setting('company_name')) }}"
            >
        </div>
        <label class="control-label col-md-2">Address</label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_address"
                class="form-control"
                value="{{ old('company_address', setting('company_address')) }}"
            >
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="control-label col-md-2">Phone: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_tel"
                class="form-control"
                value="{{ setting('company_tel') }}"
            >
        </div>
        <label class="control-label col-md-2">Email: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_email"
                class="form-control"
                value="{{ old('company_email', setting('company_email')) }}"
            >
        </div>

    </div>
    <div class="form-group mb-2">
        <label class="control-label col-md-2">Currency: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_currency"
                class="form-control"
                value="{{ old('company_currency', setting('company_currency')) }}"
            >
        </div>

        <label class="control-label col-md-2">Logo: </label>
        <div class="col-md-4">
            <input
                type="file"
                name="company_logo"
                class="file-drop-zone"
            >
            @if( ! is_null(setting('company_logo', null)))
                <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini">
                            <img src="{{ asset('storage/'. setting('company_logo'))  }}" alt="logo" width="50px" height="50px" class="image-container img-circle" ></span>
                @endif
        </div>
    </div>


    <div class="form-group mb-2">
        <label for="allow_cash_payment" class="control-label col-md-2">Allow Cash Payment</label>
        <div class="col-md-4">
            <input
                type="checkbox"
                name="allow_cash_payment"
                id="allow_cash_payment"
                value="{{ setting('allow_cash_payment' , false)  }}"
                @if(setting('allow_cash_payment' , false) ) checked @endif
                class="checkbox">
        </div>

        <label class="control-label col-md-2">Tag Line: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_tag_line"
                class="form-control"
                value="{{ old('company_tag_line', setting('company_tag_line')) }}"
            >
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-2">Advanta Partner ID: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="advanta_partner_id"
                class="form-control"
                value="{{ old('advanta_partner_id', setting('advanta_partner_id')) }}"
            >
        </div>

        <label class="control-label col-md-2">Advanta API KEY: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="advanta_api_key"
                class="form-control"
                value="{{ old('advanta_api_key', setting('advanta_api_key')) }}"
            >
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="control-label col-md-2">Advanta Short code: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="advanta_short_code"
                class="form-control"
                value="{{ old('advanta_short_code', setting('advanta_short_code')) }}"
            >
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="control-label col-md-2">Select Theme Skin: </label>
        <div class="col-md-4">
            <select
                name="company_skin"
                class="form-control select2"
                >
                @foreach(skins() as $skin)
                    <option  @if($skin ===  setting('company_skin'))  selected @endif>
                    {{ $skin }}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="modal-footer">

        <button class="btn btn-primary">Update</button>
    </div>
</form>
