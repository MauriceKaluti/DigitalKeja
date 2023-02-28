<?php


namespace App\DataTables;


use App\DB\Landlord\Landlord;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Innox\Classes\QueryFilter\DateBetweenFilter;
use Innox\Classes\QueryFilter\IdFilter;
use Yajra\DataTables\Facades\DataTables;

class LandlordDataTable extends BaseTable
{
    public function all(Request $request)
    {
        $contacts = app(Pipeline::class)
            ->send(Landlord::query())
            ->through([
                IdFilter::class,
                DateBetweenFilter::class
            ])
            ->thenReturn()
            ->with('buildings')
            ->get()
            ->map
            ->modelToArray();

        //  $contacts = Contact::latest('id')->with('agent')->get()->map->modelToArray();

        return Datatables::of($contacts)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actions = "<li class='mb-3'><a class='text-site' href='". route('landlord_read', ['landlord'  => $row['id']])."'><i class='fa fa-eye'></i> View </a> </li>";
                $actions .= "<li class='mb-3'><a class='text-site' href='". route('landlord_edit', ['landlord'  => $row['id']])."'><i class='fa fa-edit'></i> Edit </a> </li>";
                return $this->buttons($actions);
            })
            ->addColumn('buildings', function($row){
                return $row['buildings'];
            })
            ->rawColumns(['action','buildings'])
            ->make(true);
    }
}
