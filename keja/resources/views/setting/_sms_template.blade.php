<p>

    <h6>Available tags</h6>
<ul class="block">
    <li>{tenant}</li>
    <li>{building}</li>
    <li>{room_no}</li>
    <li>{amount}</li>
    <li>{rent}</li>
    <li>{deposit}</li>
</ul>
</p>
<style>
    ul.block li{
        display: inline-block;
        color: #FF0000;
    }
</style>

<form class="form-horizontal" method="post" action="{{ route('setting_store') }}">
    {{ csrf_field() }}
    <div class="form-group mb-3">
        <label class="label-control col-md-2">Payment Reminder </label>
        <div class="col-md-10">
           <textarea
               name="payment_reminder_sms"
               class="form-control"
           >{!! setting('payment_reminder_sms') !!}</textarea>
        </div>
    </div>
    <div class="form-group mb-3">
        <label class="label-control col-md-2">Payment Notification</label>
        <div class="col-md-10">
             <textarea
                 name="payment_notification_sms"
                 class="form-control"
             >{!! setting('payment_notification_sms') !!}</textarea>
        </div>
    </div>
    <div class="form-group mb-2">
        <label class="label-control col-md-2">Payment Overdue Notification</label>
        <div class="col-md-10">
             <textarea
                 name="payment_overdue_sms"
                 class="form-control"
             >{!! setting('payment_overdue_sms') !!}</textarea>
        </div>
    </div>
    <div class="modal-footer">

        <button class="btn btn-primary">Update</button>
    </div>
</form>
