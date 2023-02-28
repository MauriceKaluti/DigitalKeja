@extends('layouts.master')
@section('title','Manage Invoices')
@section('extra_css')

    <!-- datatables plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" />


    <!-- bootstrap-datepicker plugin -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection


@section('content')

    <ul class="nav-pills nav mb-4">

        <li class="mr-2">
            <a href="{{ route('invoice_browse',['payment_status' => 'paid']) }}" class="btn btn-outline-success"> {{ __('general.paid') }} </a>
        </li>
        <li class="mr-2">
            <a href="{{ route('invoice_browse' ,['payment_status' => 'partially paid'] ) }}" class="btn btn-outline-warning">{{ __('general.partially_paid') }} </a>
        </li>
        <li class="mr-2">
            <a href="{{ route('invoice_browse',['payment_status' => 'un paid'] ) }}" class="btn btn-outline-danger"> {{ __('general.un_paid') }}  </a>
        </li>
    </ul>

 
     <!-- Blance Sheet CR/DR Row -->

               <div class="row">
                  <div class="col s12 m12 l6">
                    <table class="bordered responsive-table">
                      <thead class="green white-text">
                        <th colspan="2">
                          <h1>Assets</h1>
                        </th>
                      </thead>
                      <tbody>
                        @foreach($fBalanceSheetItemsList as $key => $value)
                                  @if(strpos($key, 'Assets') !== false)
                                      <tr>
                                          <td colspan="2">
                                              <strong>{{$key}}</strong>
                                          </td>
                                      </tr>
                                      @foreach($value as $key => $val)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td style="text-align: right">
                                              @if($val>=0)
                                                  ₱ {{number_format($val,2,'.',',')}}
                                              @else
                                                  (₱ {{number_format(($val*-1),2,'.',',')}})
                                              @endif
                                           </td>
                                        </tr>
                                      @endforeach
                                  @endif
                              @endforeach
                        <tr class="green">
                          <td>
                                <strong>Total Assets</strong>
                          </td>
                          <td style="text-align: right">
                                <strong>₱ {{number_format($totalAssets,2,'.',',')}}</strong>
                          </td>
                          </tr>
                        </tbody>
                    </table>
                  </div>

                  <div class="col s12 m12 l6">
                    <table class="striped">
                        <thead class="red white-text">
                            <th colspan="2">
                            <h1>Liabilities and Owner's Equity</h1>
                            </th>
                        </thead>
                        <tbody>
                        @foreach($fBalanceSheetItemsList as $key => $value)
                                  @if(strpos($key, 'Liabilities') !== false || strpos($key, 'Equity') !== false)
                                    <tr>
                                        <td colspan="2">
                                            <strong>{{$key}}</strong>
                                        </td>
                                    </tr>
                                    @foreach($value as $k => $val)
                                    <tr>
                                        <td>{{$k}}</td>
                                        <td style="text-align: right">
                                            @if($val>=0)
                                                ₱ {{number_format($val,2,'.',',')}}
                                            @else
                                                (₱ {{number_format(($val*-1),2,'.',',')}})
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        @if(strpos($key, 'Fixed Liabilities') !== false)
                                            <td> <strong> Total Liabilities </strong></td>
                                            <td style="text-align: right"> ₱ {{number_format($totalLiability,2,'.',',')}} </td>
                                        @elseif(strpos($key, 'Equity') !== false)
                                            <td> <strong> Total Equity </strong></td>
                                            <td style="text-align: right"> ₱ {{number_format($totalEquity,2,'.',',')}} </td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        <tr class="red">
                            <td>
                                <strong>Total Equity and Liabilities</strong>
                            </td>
                            <td style="text-align: right">
                                <strong>₱ {{number_format($totalLiability + $totalEquity,2,'.',',')}}</strong>
                            </td>
                        </tr>
                      </tbody>
                  </table>
                </div>

              </div>

     <!-- End Balance Sheet CR/DR Row -->

@endsection

@section('extra_js')

    <!-- datatables -->
    <script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

    <script>

        $('input.date').datepicker();

        $(function () {

            var table = $('table#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('invoice_browse') }}",
                columns: [

                    {data: 'tenant', name: 'tenant'},

                ]
            });

        });
    </script>
@endsection
