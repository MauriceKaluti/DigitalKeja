 <table class="row-border stripe table" id="kejaDisplay" style="width:100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Location</th>
        <th>Total Units</th>
        <th>% Occupied</th>
        <th>Expected Rent</th>
        @can('edit_building')<th>Manage Building</th> @endcan
    </tr>
    </thead>
    <tbody>
    @foreach($buildings as $building)
        <tr>
            <td> 
            <a href="{{ route('building_read', ['building' => $building->id]) }}">
                    {{ $building->name }}
            </a>
            </td>
            <td>{{ $building->location }}</td>
            <td><a href="{{ route('room_browse', ['building_id' => $building->id]) }}">
                    {{ $building->rooms->count() }}
                </a> </td>
            <td>{{ $building->occupied() }} %</td>
            <td>{{ number_format($building->rent , 2) }}</td>
            <td>
                @component('layouts._button')
                  @can('read_building')
                        <li class="mb-3"> <a class="text-site" href="{{ url('accounts/building',['building' => $building->id]) }}"><i class="fa fa-building"></i> 3D Rooms</a></li>
                    @endcan
                    @can('read_building')
                        <li class="mb-3"> <a class="text-site" href="{{ route('building_read',['building' => $building->id]) }}"><i class="fa fa-user"></i> Check Tenants</a></li>
                    @endcan
                    @can('browse_rooms')
                        <li class="mb-3"> <a class="text-site" href="{{ route('room_browse',['building_id' => $building->id]) }}"><i class="fa fa-home"></i> Check Rooms</a></li>
                    @endcan
                     @can('add_rooms')
                        <li class="mb-3"><a class="text-site" href="{{ route('room_create',['building' => $building->id]) }}"><i class="fa fa-plus"></i> {{ __('Create New Room') }}</a></li>
                    @endcan
                    @can('edit_building')
                        <li class="mb-3"><a class="text-site" href="{{ route('building_edit',['building' => $building->id]) }}"><i class="fa fa-edit"></i> {{ __('Update Building Info') }}</a></li>
                    @endcan
                    @can('delete_building')
                        <li class="mb-3"><a class="text-site" href="{{ route('building_delete',['building' => $building->id]) }}"><i class="fa fa-trash"></i> {{ __('Delete Building') }}</a></li>
                    @endcan
                   
                @endcomponent
            </td>
        </tr>

    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>Name</th>
        <th>LandLord</th>
        <th>Total Units</th>
        <th>% Occupied</th>
        <th>{{ number_format($buildings->sum('rent') , 2) }}</th>
        @can('edit_building')<th>Manage Building</th> @endcan
    </tr>
    </tfoot>
</table>
