
     <script src="{{asset('toastr/jquery-1.12.4.min.js')}} "></script>

    <script src="{{asset('toastr/toastr.min.js')}} "></script>
    <script src="{{asset('toastr/toastr.js')}} "></script>  

    <link rel="stylesheet" href="{{asset('toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('toastr/toastr.min.css')}}">


<script>

 
// FE(Front End) Toastrs 

  @if(Session::has('titlesuccess'))

        toastr.success("{{ Session::get('titlesuccess') }}");

  @endif

   @if(Session::has('building_expense_success'))

    toastr.options.positionClass = 'toast-bottom-left';


        toastr.success("{{ Session::get('building_expense_success') }}");

  @endif

   @if(Session::has('building_income_success'))

    toastr.options.positionClass = 'toast-bottom-right';


        toastr.success("{{ Session::get('building_income_success') }}");

  @endif

     @if(Session::has('entrysuccess'))

    toastr.options.positionClass = 'toast-bottom-right';


        toastr.success("{{ Session::get('entrysuccess') }}");

  @endif

       @if(Session::has('journal_titlesuccess'))

    toastr.options.positionClass = 'toast-bottom-right';


        toastr.success("{{ Session::get('journal_titlesuccess') }}");

  @endif

       @if(Session::has('tenant_edit_success'))

    toastr.options.positionClass = 'toast-bottom-right';


        toastr.success("{{ Session::get('tenant_edit_success') }}");

  @endif

         @if(Session::has('building_edit_success'))

    toastr.options.positionClass = 'toast-bottom-right';


        toastr.success("{{ Session::get('building_edit_success') }}");

  @endif
 
 

</script>
