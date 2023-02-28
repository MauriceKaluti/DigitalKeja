@inject('request', 'Illuminate\Http\Request')
@if(Auth::guest())
@else
<?php 
$sideuserid = Auth::user()->id;
$sideuser = App\User::where('id','=',$sideuserid)->first();
$sideuserRole = $sideuser->roles->pluck('name')->all();
$sideuserRole = $sideuserRole[0];
?>
@endif
<div class="offcanvas offcanvas-start keja-bg" data-bs-backdrop="true" data-bs-scroll="true" tabindex="-1" id="toggleSideNav"  aria-labelledby="toggleSideNavLabel">
   <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="toggleSideNavLabel">Keja Digital</h5>
      <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
   </div>
   <div class="offcanvas-body py-0">
      <div class="sidenav-profile">
         <div class="user-profile"><img src="{{url('images/avatar.png')}}" alt=""></div>
         @if(Auth::guest())
         @else
         <div class="user-info">
            <h6 class="user-name text-site mb-1">{{Auth::user()->name}}</h6>
            <span class="badge badge-warning bg-warning keja-round"><small>{{$sideuserRole}}</small></span>
         </div>
         @endif
      </div>
      <ul class="sidenav-nav ps-0">
         <li class="text-site"><a class="text-site" href="{{url('/dashboard')}}"><i class="fa fa-home"></i>Dashboard</a></li>
         @if(Auth::guest())
         <li class="text-site"><a class="text-site" href="javascript:void;" data-bs-toggle="modal" data-bs-target="#oneTapLogin"><i class="fa fa-flash"></i>Login Express</a></li>
         <li class="text-site"><a class="text-site" href="{{ url('login') }}"><i class="fa fa-sign-in"></i>Login</a></li>
         <li class="text-site"><a class="text-site" href="{{ url('register') }}"><i class="fa fa-user-plus"></i>Create Account</a></li>
         @else
         @can('role-list')
         <li class="text-site"><a class="text-site" href="{{ route('roles.index') }}"><i class="fa fa-user-shield"></i>Manage Roles</a></li>
         @endcan
         @can('user-list')
         <li class="text-site"><a class="text-site" href="{{ route('users.index') }}"><i class="fa fa-users"></i> Users</a></li>
         @endcan
         <li class="text-site"><a class="text-site" href="{{url('/me')}}"><i class="fa fa-user"></i>My Account</a></li>
         <li class="text-site"><a class="text-site" href="{{url('/appexit')}}"><i class="fa fa-power-off"></i>Sign Out</a></li>
         @endif
         <li class="text-site"><a class="text-site" href="{{url('/')}}"><i class="fa fa-phone"></i>Help 24/7</a></li>
         <li {{ url()->current() ? "active" : '' }}>
         <a class="text-site" href="{{ url('/home') }}">
            <ion-icon name="home"></ion-icon>
            <i class="menu-icon fa fa-dashboard"></i><span>System Home</span>
         </a>
         </li>
         @can('browse_user')
         <li class="treeview{{  getActiveParentRoute('user' ) ? "active" : '' }}">
         <a href="#">
         <i class="fa fa-user"></i>
         <span class="text-site">System Users</span>
         </a>
         <ul class="treeview-menu">
            <li class="{{ getActiveRoute( route('user_browse')) ? "active" : '' }}">
            <a class="text-site" href="{{ route('user_browse') }}"> <i class="fa fa-circle-o"></i>User</a></li>
            <li class="{{ url()->current()  ==  route('user_role') ? "active" : '' }}">
            <a class="text-site" href="{{ route('user_role') }}"> <i class="fa fa-circle-o"></i>Roles</a></li>
         </ul>
         </li>
         @endcan
         <li class="treeview">
            <a href="#">
            <i class="fa fa-briefcase"></i>
            <span class="text-site">Landlords</span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a class="text-site" href="{{ route('landlord_browse') }}"> <i class="fa fa-circle-o"></i> Explore Landlords</a>
               </li>
               <li>
                  <a class="text-site" href="{{url('accounts/landlords_simplified')}}"> <i class="fa fa-circle-o"></i> Disburse To Landlords</a>
               </li>
               <li>
                  <a class="text-site" href="{{ url('accounts/landlords') }}"> <i class="fa fa-circle-o"></i>  Landlord Expected Rent</a>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-university"></i>
            <span class="text-site">Buildings</span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a class="text-site" href="{{ url('building/create') }}"> <i class="fa fa-plus"></i> Create New Building</a>
               </li>
               <li>
                  <a class="text-site" href="{{ url('accounts/opt_buildings') }}"> <i class="fa fa-eye"></i> Manage Buildings</a>
               </li>
               <li>
                  <a class="text-site" href="{{ url('accounts/buildings') }}"> <i class="fa fa-money"></i>  Buildings Payment Status</a>
               </li>
               <li>
                  <a class="text-site" href="{{ url('building/browse') }}"> <i class="fa fa-circle-o"></i> Occupation Ratio</a>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-users"></i>
            <span class="text-site">Tenants</span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a class="text-site" href="{{ url('tenant/create') }}"> <i class="fa fa-circle-o"></i> Create Tenant</a>
               </li>
               <li>
                  <a class="text-site" href="{{ url('accounts/occupants') }}"> <i class="fa fa-circle-o"></i> Occupants</a>
               </li>
               <li>
                  <a class="text-site" href="{{ url('building/room/list') }}"> <i class="fa fa-circle-o"></i> Lease Tenant Now</a>
               </li>
               <li>
                  <a class="text-site" href="{{ route('tenant_browse') }}"> <i class="fa fa-circle-o"></i> Manage Tenants</a>
               </li>
               <li>
                  <a class="text-site" href="{{url('accounts/all_tenants')}}"> <i class="fa fa-circle-o"></i> Make Manual Payment</a>
               </li>
            </ul>
         </li>
         <li class="treeview">
            <a href="#">
            <i class="fa fa-money"></i>
            <span class="text-site">Reports</span>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a class="text-site" href="{{ route('balance_sheet') }}"> <i class="fa fa-circle-o"></i> Balance Sheet</a>
               </li>
               <li>
                  <a class="text-site" href="{{ route('profit_loss') }}"> <i class="fa fa-circle-o"></i> Profit & Loss Account</a>
               </li>
               <!--  <li>
                  <a class="text-site" href="{{ route('expenses_summary') }}"> <i class="fa fa-circle-o"></i> Summary Of Expenses</a>
                  </li> -->
               <li>
                  <a class="text-site" href="{{ route('receipt_reports') }}"> <i
                     class="fa fa-circle-o"></i> {{ __('Receipt Reports') }}</a>
               </li>
               <li>
                  <a class="text-site" href="{{ route('mpesa_receipt_reports') }}"> <i
                     class="fa fa-circle-o"></i> {{ __('Mpesa Receipt Reports') }}</a>
               </li>
               <li>
                  <a class="text-site" href="{{ route('income_statement') }}"> <i class="fa fa-circle-o"></i>Income Statement</a>
               </li>
            </ul>
         </li>
         @can('browse_payments')
         <li class="treeview{{ getActiveParentRoute('payment' ) ? "active"  :  (getActiveRoute( route('chart.index')) ? "active" : '')}}">
         <a href="#">
         <i class="fa fa-dollar"></i>
         <span class="text-site">Accounting</span>
         </a>
         <ul class="treeview-menu">
            <li>
               <a class="text-site" href="{{url('payment/expenses/create')}}"> <i class="fa fa-circle-o"></i>{{ __('Create Internal Expenses') }}</a>
            </li>
            <li>
               <a class="text-site" href="{{ route('payment_expenses') }}"> <i class="fa fa-circle-o"></i>{{ __('All Expenses') }}</a>
            </li>
            <li>
               <a class="text-site" href="{{ route('account_titles') }}"> <i class="fa fa-circle-o"></i> Create Account Title</a>
            </li>
            <li>
               <a class="text-site" href="{{ route('view_account_titles') }}"> <i class="fa fa-circle-o"></i> View All Account Titles</a>
            </li>
            <!--  <li><a class="text-site" href="{{ route('view_journals') }}"> <i class="fa fa-circle-o"></i> View All Entries</a></li>                               

            <li><a class="text-site" href="{{ route('create_journal_title') }}"> <i class="fa fa-circle-o"></i> {{ __('Create New Journal') }}</a>
            </li> -->
         </ul>
         </li>
         @endcan
         <li class="{{ getActiveRoute( route('sms.create')) ? "active" : '' }}">
         <a class="text-site" href="{{ route('sms.create') }}">
            <ion-icon name="home"></ion-icon>
            <i class="menu-icon fa fa-envelope"></i><span>{{ __('Bulk Sms') }}</span>
         </a>
         </li>
         <li>
            <a class="text-site" href="{{ route('setting_browse') }}">
               <ion-icon name="home"></ion-icon>
               <i class="menu-icon fa fa-cog"></i><span>{{ __('Settings') }}</span>
            </a>
         </li>
         <!--     <li>-->
         <!--    <a class="text-site" href="{{ url('/profile') }}">-->
         <!--        <ion-icon name="home"></ion-icon>-->
         <!--            <i class="menu-icon fa fa-refresh"></i><span>{{ __('Update Profile') }}</span>-->
         <!--        </a>-->
         <!--</li>-->
         <li>
            <a class="text-site" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
            <i class="fa fa-power-off"></i> Logout
            </a>
            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
               {{ csrf_field() }}
            </form>
         </li>

         <li class="menu-divider"></li>
         <li>
            <a class="text-site" href="javascript:void(0);">
            <i class="fa fa-copyright"></i><span>Version: </span><span class="label label-danger text-site">
            {{ config('system.version') }}
            </span>
            </a>
         </li>

         <hr>
         <li class="text-site">
            <div class="single-settings d-flex align-items-center justify-content-between">
               <div class="title"><i class="fa fa-sun"></i><span>Light/Dark Mode</span></div>
               <div class="data-content">
                  <div class="toggle-button-cover">
                     <div class="button r">
                        <input class="checkbox" id="darkSwitch" type="checkbox">
                        <div class="knobs"></div>
                        <div class="layer"></div>
                     </div>
                  </div>
               </div>
            </div>
         </li>
         <hr>
      </ul>
   </div>
</div>
<div class="modal" id="oneTapLogin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="oneTapLoginLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content keja-bg keja-round keja-border-top">
         <div class="modal-header">
            <h1 class="modal-title keja-bold fs-5" id="oneTapLoginLabel">Login Express</h1>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
               <strong>Whoops!</strong> Something went wrong.<br><br>
               <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
               </ul>
            </div>
            @endif
            @include('keja.layouts.onetap')
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>