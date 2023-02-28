<?php


namespace App\DataTables;


use App\DB\Landlord\Landlord;
use App\DB\Tenant;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Innox\Classes\Repository\TenantRepository;
use Yajra\DataTables\Facades\DataTables;

class TenantDataTable extends BaseTable
{
    public function all(Request $request)
    {
        $contacts = (new TenantRepository())
            ->filter()
            ->map
            ->modelToArray();

        //  $contacts = Contact::latest('id')->with('agent')->get()->map->modelToArray();

        return Datatables::of($contacts)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actions = "<li class='mb-3'><a class='text-site' href='". route('tenant_view', ['tenant'  => $row['id']])."'><i class='fa fa-eye'></i> View Tenant</a> </li>";
                $actions .= "<li class='mb-3'><a class='text-site' href='". route('lease_create', ['tenant'  => $row['id']])."'><i class='fa fa-building-o'></i> Lease Tenant </a> </li>";
                $actions .= "<li class='mb-3'><a data-id='". $row['id'] ."' class='lease-room text-site'> <i class='fa fa-ban'></i> Detach/Unlease </a> </li>";
                $actions .= "<li class='mb-3'><a class='text-site' href='". route('tenant_edit', ['tenant'  => $row['id']])."'> <i class='fa fa-edit'></i> Edit </a> </li>";
                $actions .= "<li class='mb-3'><a class='text-site' href='". route('tenant_delete', ['tenant'  => $row['id']])."'><i class='fa fa-trash'></i> Delete </a> </li>";
                return $this->buttons($actions);
            })
            ->addColumn('building', function($row){

                return $row['building'];
            })

            ->rawColumns(['action','building'])
            ->make(true);
    }
}
