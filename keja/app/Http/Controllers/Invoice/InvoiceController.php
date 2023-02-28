<?php

namespace App\Http\Controllers\Invoice;

use App\DB\Lease\Invoice;
use App\DB\Lease\InvoiceItem;
use App\DB\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Innox\Classes\Repository\InvoiceRepository;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->can('browse_invoices')) {
            accessDenied();

        }

        $request->request->add(['status' => 'un paid']);

        if ($request->has('invoice')) {
            $request->request->add(['id' => $request['invoice']]);
        }

        if ($request->ajax()) {

            $tableContent = [];

            $invoices = (new InvoiceRepository())->filter()->groupBy(function ($q) {
                return '<a href="'. route('tenant_view', ['tenant' => $q->tenant->id]). '">' . $q->tenant->name . '</a>';
            });

            foreach ($invoices as $index => $invoice) {

                $tableContent[] = [
                    'tenant' => $index,
                ];

            }
            return Datatables::of($tableContent)
                ->addIndexColumn()
                ->addColumn('tenant', function ($row) {
                    return $row['tenant'];
                })
                ->rawColumns(['tenant'])
                ->make(true);
        }

        return view('invoice.browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(Invoice $invoice)
    {
        if (!auth()->user()->can('read_invoices')) {
            accessDenied();

            return back();
        }

        return view('invoice.read')
            ->with([
                'invoice' => $invoice
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Invoice $invoice)
    {
        if (!auth()->user()->can('edit_invoices')) {
            accessDenied();

            return back();
        }

        return view('invoice.edit')
            ->with([
                'invoice' => $invoice
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        if (!auth()->user()->can('edit_invoices')) {
            accessDenied();

            return back();
        }

        foreach ($request['id'] as $id => $amount) {

            $invoiceItem = InvoiceItem::where('id', $id)->first();

            $invoiceItem->amount = $amount;
            $invoiceItem->save();

        }
        flash('successfully updated the invoice items')
            ->success()
            ->important();

        return redirect()
            ->route('invoice_show', ['invoice' => $invoice->id])
            ->send();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
