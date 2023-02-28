<div class="table-responsive mt-2 clearfix">

        <div class="clearfix clear" style="margin-bottom: 10px">
            <button type="button" class="btn btn-primary mb-5" id="updatePricing"> Update selected pricing</button>

        </div>

        <form  id="selected-form" action="{{ route('room_pricing') }}">
            {{ csrf_field() }}

            <div class="table-responsive">

 <table class="row-border stripe table" id="kejaDisplay" style="width:100%">
                <!-- <table class="table display table-striped room-table"> -->
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="select_all"></th>
                        <th>{{ trans('general.room') }} Number</th>
                        <th>Status</th>
                        <th>Rent</th>
                        <th>Deposit</th>
                        <th>Tenant</th>
                        @can('edit_building')
                            <th>Actions</th> @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rooms as $room)
                        <tr href="{{ route('room_details', ['room' => $room->id]) }}">
                            <td><input type="checkbox" name="room_id[]"  class="select_unit" value="{{ $room->id }}"></td>
                            <td>{{ $room->room_number }} {{ $room->getMeta('room_type', false) ? ' ( '. $room->getMeta('room_type') .' )': ""}}</td>
                            <td>{!! $room->status_name  !!}</td>
                            <td>{{ setting('company_currency') . ' ' .number_format(floatval($room->rent ))}}</td>
                            <td>{{ setting('company_currency') . ' ' . number_format(floatval($room->deposit) , 2) }}</td>
                            <td>{!! $room->tenant_name !!}</td>
                            <td>
                                @component('layouts._button')

                                    @if(! isset($room->lease->is_active))
                                        @can('add_lease_room')
                                            <li><a href="{{ route('lease_create',['room_id' => $room->id]) }}">Lease</a>
                                            </li>
                                        @endcan
                                    @endif
                                    @if(! isset($room->lease->is_active) && ! $room->is_vacant)
                                        @can('add_lease_room')
                                            <li><a href="{{ route('room_activate',['room' => $room->id]) }}">Activate room</a>
                                            </li>
                                        @endcan
                                    @endif
                                    @can('edit_rooms')
                                        <li><a href="{{ route('room_edit',['room' => $room->id]) }}">Edit</a></li>
                                    @endcan
                                    @can('delete_rooms')
                                        <li><a href="{{ route('room_delete',['room' => $room->id]) }}">Delete</a></li>
                                    @endcan
                                @endcomponent
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@section('js')
    <script>
        $('button#updatePricing').on('click', function () {
            $(".append-selected-units").empty()
            let i = 0;
            $('.select_unit').each(function () {
                if ($(this).is(':checked')) {
                    i++;

                }
            });

            if (i <= 0) {
                swal({
                    title: "Warning!",
                    text: "You must select at least one unit",
                    icon: "warning",
                    button: "OK!",
                });
                return '';
            }
            $("form#selected-form").submit()
        });
        $("table.room-table").DataTable({
            "order": [[ 1, "desc" ]],
        })
    </script>
@endsection
