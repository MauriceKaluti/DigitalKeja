<form class="form-horizontal" method="post" action="{{ route('setting_store') }}">
    {{ csrf_field() }}
    <div class="form-row mb-3">
        <label class="label-control col-md-2"></label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_name"
                class="form-control"
                value="{{ old('company_name', setting('company_name')) }}"
            >
        </div>
        <label class="label-control col-md-2">Address</label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_address"
                class="form-control"
                value="{{ old('company_address', setting('company_address')) }}"
            >
        </div>
    </div>
    <div class="form-row mb-2">
        <label class="label-control col-md-2">Phone: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_tel"
                class="form-control"
                value="{{ old('company_tel', setting('company_tel')) }}"
            >
        </div>
        <label class="label-control col-md-2">Email: </label>
        <div class="col-md-4">
            <input
                type="text"
                name="company_email"
                class="form-control"
                value="{{ old('company_email', setting('company_email')) }}"
            >
        </div>
    </div>
    <div class="modal-footer">

        <button class="btn btn-outline-primary">Update</button>
    </div>
</form>
