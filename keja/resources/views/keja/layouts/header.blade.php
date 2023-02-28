 <style>
   .table{
   color: #747794!important;
   }
.dataTables_wrapper .dataTables_filter input {
   color: #747794!important;

}
   select { 
   color: #747794!important;
   -webkit-text-fill-color: #747794!important; 
   }

   .select2-container--default .select2-selection--single .select2-selection__rendered {
   color: #747794!important;
   }

   .accordion-item {

      border: 0px transparent!important;

   }

   .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {

      background-color: #ffaf00;

   }

   .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
      color: #fff;
   }
   .nav-tabs .nav-link {
      border-radius: 30px;
   }
 </style>

 <link rel="stylesheet" type="text/css" href="{{asset('app/kejalive.css')}}">

<div class="header-area" id="headerArea">
   <div class="container-fluid h-100 d-flex align-items-center justify-content-between">
      <div class="back-button">
         <a href="javascript:void();" onclick="window.history.go(-1); return false;">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
               <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
            </svg>
         </a>
      </div>
      <div class="page-heading">
         <h6 class="mb-0"><a class="text-site" href="{{url('/')}}">KejaDigital</a></h6>
      </div>
      <div>
         <a data-bs-toggle="offcanvas" data-bs-target="#toggleSideNav" aria-controls="toggleSideNav" href="javascript:void(0);"><i class="fa fa-user-circle fs-1"></i></a>
      </div>
   </div>
</div>

<div class="modal" id="kejaGlobalSearch" tabindex="-1" aria-labelledby="kejaGlobalSearchLabel" aria-hidden="true">
   <div class="modal-dialog modal-fullscreen">
      <div class="modal-content keja-bg">
         <div class="modal-header justify-content-between">
            <div id="kejaGlobalSearchLabel"> <a href="javascript:void(0)" data-bs-dismiss="modal" aria-label="Back"><i class="fa fa-arrow-left text-site"></i> </a></div>
            <div> Search Landlords</div>
            <button type="button" class="btn-close shadow-none p-0 m-0" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
      
   
      </div>
            <div class="modal-footer justify-content-start">
            <div class="float-start">   
               <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <div class="float-end">   </div>
         </div>
   </div>
</div>
</div>

 