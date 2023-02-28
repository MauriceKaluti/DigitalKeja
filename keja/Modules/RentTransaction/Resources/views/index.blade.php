@extends('layouts.master')
@section('title','Rent Deduction and Addiction')
@section('content')
    <div class="box box-primary">
        <div class="box-body box-primary">


            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#transactions" data-toggle="tab">Transactions List</a></li>
                    <li><a href="#add" data-toggle="tab">Add</a></li>
                   </ul>
                <div class="tab-content">
                    <div class="tab-pane active  " id="transactions">
                        <!-- Post -->
                        @include('renttransaction::partials._list')
                    </div>
                    <div class="tab-pane" id="add">
                        <!-- Post -->

                        @include('renttransaction::partials._form')
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('css')
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection
@section('extra_js')
    @include('layouts._form-scripts')
    @include('layouts._datepicker')
    @include('layouts._datatable')

    <script>
        class Transcation {
            initiateHtml() {
                return '<tr>' +
                    '<td><select class="form-control select2" name="type[]"><option>Deduction</option><option>Addiction</option></select></td>' +
                    '<td><input type="number" name="amount[]" required placeholder="amount" class="form-control"></td>' +
                    '<td><input name="reason[]"  required placeholder="reason" class="form-control"></td>' +
                    '<td>' +
                    '<div class="align-content-between">' +
                    '<div><button  onclick="transaction.addNewHtmlLine()"  type="button" class="btn btn-success">+</button> &nbsp;&nbsp;&nbsp;&nbsp;' +
                    '<button onclick="transaction.removeNewHtmlLine(event)" type="button" class="btn btn-danger removeBtn">-</button> </div> ' +
                    '</div>' +
                    ' </td>' +
                    '</tr>';
            }
            addNewHtmlLine() {
                $("table#transaction-form>tbody").append(transaction.initiateHtml());
            }
            removeNewHtmlLine(event) {
                if($("table#transaction-form > tbody > tr").length <= 1)
                {
                    return "";
                }

                event.target.parentElement.parentElement.parentElement.parentElement.remove('closest', 'tr');
            }

        }

        let transaction = new Transcation();

        $("table#transaction-form>tbody").append(transaction.initiateHtml());

        $("input.month").datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });

        $("#example").DataTable()

    </script>
@endsection
