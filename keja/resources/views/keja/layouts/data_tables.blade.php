<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"> -->

<link rel="stylesheet" href="{{asset('system/datatables/css/buttons.dataTables.min.css')}}">

<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> -->



<link rel="stylesheet" href="{{asset('app/css/select.dataTables.min.css')}}"/>

 <link rel="stylesheet" type="text/css" href="{{asset('system/datatables/css/dataTables.min.css')}}">
<style>
   table.dataTable tbody tr.selected>* {
box-shadow: inset 0 0 0 9999px #747794;
color: white; 
}
.dt-buttons button{
      color: #fff!important;
      background-color: #179CF0!important;
}

 button.dt-button, div.dt-button, a.dt-button, input.dt-button {
background: linear-gradient(to bottom, #179CF0 0%, #179CF0 100%)!important;
    color: #ffff!important;
font-weight: bold!important;
border-radius: 30px!important;
 }

 .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #747794!important;
}

 .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #747794!important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
/*    color: #747794!important;*/
    background-color: transparent!important;
    background: transparent!important;
}

 .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    color: #ffff!important;
}
 

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(to bottom,#179CF0 0%,#179CF0 100%)!important;
}
</style>
 
<script src="{{asset('system/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{asset('app/js/dataTables.select.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->


<script src="{{asset('system/datatables/dataTables.buttons.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> -->


<script src="{{asset('system/datatables/jszip.min.js')}}"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> -->

<script src="{{asset('system/datatables/pdfmake.min.js')}}"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->

<script src="{{asset('system/datatables/vfs_fonts.js')}}"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->

<script src="{{asset('system/datatables/buttons.html5.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script> -->

<script src="{{asset('system/datatables/buttons.print.min.js')}}"></script>

<!-- <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script> -->
<script type="text/javascript">
   $(document).ready(function() {
   $('#kejaDisplay').DataTable( {
   "aaSorting": [],
        processing: true,
           
   dom: 'Bfrtip',
   buttons: [
   'copy', 'csv', 'excel', 'pdf', 'print'
   ]
   } );
   
   $('#kejaDisplay2').DataTable( {
   "aaSorting": [],
        processing: true,
           
   dom: 'Bfrtip',
   buttons: [
   'copy', 'csv', 'excel', 'pdf', 'print'
   ]
   } );
   
   
   $('#kejaDisplay3').DataTable( {
   "aaSorting": [],
        processing: true,
           
   dom: 'Bfrtip',
   buttons: [
   'copy', 'csv', 'excel', 'pdf', 'print'
   ]
   } );
   
   });
</script>

    <script>
        $('#kejaDisplayLandlords').DataTable({
            sort: false,
            "processing": true,
            "serverSide": true,
            ajax: "{{ route('landlord_browse') }}",
            columns: [

                { "data" : "name",   name: "name"},
                { "data" : "id_no",   name: "id_no"},
                { "data" : "phone",   name: "phone"},
                { "data" : "email", name: "email"},
                { "data" : "commission", name: "commission"},
                { "data" : "buildings", name: "buildings"},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            fnCreatedRow: function( nRow, aData, iDataIndex ) {
                $(nRow).attr('clicked_row',aData['id']);
            }
        });


        $('input.date').datepicker();
    </script>


    <script>
   $(function () {
   
       var table = $('#kejaDisplayTenants').DataTable({
           sort: false,
           processing: true,
           serverSide: true,
           ajax: "{{ route('tenant_browse') }}",
           columns: [
   
               {data: 'name', name: 'name'},
               {data: 'id_no', name: 'id_no'},
               {data: 'phone', name: 'phone'},
               {data: 'email', name: 'email'},
               {data: 'building', name: 'building'},
               {data: 'action', name: 'action', sortable: false},
   
           ]
       });
   
   });
   
   $('input.date').datepicker();
   
   $(document).on('click', 'a.lease-room', function () {
       swal({
           title: "Are you sure?",
           text: "You will detach this tenant from a unit!",
           icon: "warning",
           buttons: true,
           dangerMode: true,
       }).then((willDelete) => {
               if (willDelete) {
                   let uri = "{{  url('tenant/') }}";
                    uri += "/"+$(this).data('id');
                    uri +="/un-lease";
   
                   return window.open(uri)
               } else {
                   swal("You have cancelled detachment!");
               }
           });
   });
</script>