<form
    class="form-horizontal"
    method="post"
    action="{{ route('rent_transaction_store', ['landlord'  => $landlord->id]) }}"
    autocomplete="off"

>
    @csrf
    <div class="form-group">
        <label for="month" class="control-label col-md-2">Month</label>
        <div class="col-md-4">
            <input
                name="month"
                type="month"
                class="form-control"
            >
        </div>

        <label for="month" class="control-label col-md-2">Landlord</label>
        <div class="col-md-4">
            <input
                readonly
                value="{{ $landlord->name }}"
                class="form-control"
            >
        </div>
    </div>
    <div class="form-group">
        <table class="table display" id="transaction-form">
            <thead>
            <tr>
                <th>Type</th>
                <th>Amount</th>
                <th width="50%">Reason</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-success"> Submit </button>
    </div>
</form>
