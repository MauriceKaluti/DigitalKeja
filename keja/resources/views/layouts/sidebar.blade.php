<ul class="sidebar-menu" data-widget="tree">
   <li {{ url()->current() ? "active" : '' }}>
   <a href="{{ url('/home') }}">
      <ion-icon name="home"></ion-icon>
      <i class="menu-icon fa fa-dashboard"></i><span>Dashboard</span>
   </a>
   </li>
   @can('browse_user')
   <li class="treeview {{  getActiveParentRoute('user' ) ? "active" : '' }}">
   <a href="#">
   <i class="fa fa-user"></i>
   <span>{{ trans('general.user') }}</span>
   <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
   </span>
   </a>
   <ul class="treeview-menu">
      <li class="{{ getActiveRoute( route('user_browse')) ? "active" : '' }}">
      <a href="{{ route('user_browse') }}"> <i class="fa fa-circle-o"></i>User</a></li>
      <li class="{{ url()->current()  ==  route('user_role') ? "active" : '' }}">
      <a href="{{ route('user_role') }}"> <i class="fa fa-circle-o"></i>Roles</a></li>
   </ul>
   </li>
   @endcan
   <li class="treeview ">
      <a href="#">
      <i class="fa fa-briefcase"></i>
      <span>Landlords</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
      </a>
      <ul class="treeview-menu">
         <li class="active">
            <a href="{{ route('landlord_browse') }}"> <i class="fa fa-circle-o"></i> Explore Landlords</a>
         </li>
         <li class="active">
            <a  href="{{url('accounts/landlords_simplified')}}"> <i class="fa fa-circle-o"></i> Disburse To Landlords</a>
         </li>
         <li class="active">
            <a href="{{ url('accounts/landlords') }}"> <i class="fa fa-circle-o"></i>  Landlord Expected Rent</a>
         </li>
      </ul>
   </li>
   <li class="treeview ">
      <a href="#">
      <i class="fa fa-university"></i>
      <span>Buildings</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
      </a>
      <ul class="treeview-menu">
         <li class="active">
            <a href="{{ url('building/create') }}"> <i class="fa fa-plus"></i> Create New Building</a>
         </li>
         <li class="active">
            <a href="{{ url('accounts/opt_buildings') }}"> <i class="fa fa-eye"></i> Manage Buildings</a>
         </li>
         <li class="active">
            <a href="{{ url('accounts/buildings') }}"> <i class="fa fa-money"></i>  Buildings Payment Status</a>
         </li>
         <li class="active">
            <a href="{{ url('building/browse') }}"> <i class="fa fa-circle-o"></i> Occupation Ratio</a>
         </li>
      </ul>
   </li>
   <li class="treeview ">
      <a href="#">
      <i class="fa fa-users"></i>
      <span>Tenants</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
      </a>
      <ul class="treeview-menu">
         <li class="active">
            <a href="{{ url('tenant/create') }}"> <i class="fa fa-circle-o"></i> Create Tenant</a>
         </li>
         <li class="active">
            <a href="{{ url('accounts/occupants') }}"> <i class="fa fa-circle-o"></i> Occupants</a>
         </li>
         <li class="active">
            <a href="{{ url('building/room/list') }}"> <i class="fa fa-circle-o"></i> Lease Tenant Now</a>
         </li>
         <li class="active">
            <a href="{{ route('tenant_browse') }}"> <i class="fa fa-circle-o"></i> Manage Tenants</a>
         </li>
         <li class="active">
            <a href="{{url('accounts/all_tenants')}}"> <i class="fa fa-circle-o"></i> Make Manual Payment</a>
         </li>
      </ul>
   </li>
   <li class="treeview ">
      <a href="#">
      <i class="fa fa-money"></i>
      <span>Reports</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
      </span>
      </a>
      <ul class="treeview-menu">
         <li class="active">
            <a href="{{ route('balance_sheet') }}"> <i class="fa fa-circle-o"></i> Balance Sheet</a>
         </li>
         <li class="active">
            <a href="{{ route('profit_loss') }}"> <i class="fa fa-circle-o"></i> Profit & Loss Account</a>
         </li>
         <!--  <li class="active">
            <a href="{{ route('expenses_summary') }}"> <i class="fa fa-circle-o"></i> Summary Of Expenses</a>
            </li> -->
         <li class="active">
            <a href="{{ route('receipt_reports') }}"> <i
               class="fa fa-circle-o"></i> {{ __('Receipt Reports') }}</a>
         </li>
         <li class="active">
            <a href="{{ route('mpesa_receipt_reports') }}"> <i
               class="fa fa-circle-o"></i> {{ __('Mpesa Receipt Reports') }}</a>
         </li>
         <li class="active">
            <a href="{{ route('income_statement') }}"> <i class="fa fa-circle-o"></i>Income Statement</a>
         </li>
      </ul>
   </li>
   @can('browse_payments')
   <li class="treeview {{ getActiveParentRoute('payment' ) ? "active"  :  (getActiveRoute( route('chart.index')) ? "active" : '')}}">
   <a href="#">
   <i class="fa fa-dollar"></i>
   <span>Accounting</span>
   <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
   </span>
   </a>
   <ul class="treeview-menu">
      <li class="active">
         <a href="{{url('payment/expenses/create')}}"> <i class="fa fa-circle-o"></i>{{ __('Create Internal Expenses') }}</a>
      </li>
      <li class="active">
         <a href="{{ route('payment_expenses') }}"> <i class="fa fa-circle-o"></i>{{ __('All Expenses') }}</a>
      </li>
      <li class="active">
         <a href="{{ route('account_titles') }}"> <i class="fa fa-circle-o"></i> Create Account Title</a>
      </li>
      <li class="active">
         <a href="{{ route('view_account_titles') }}"> <i class="fa fa-circle-o"></i> View All Account Titles</a>
      </li>
      <!--               <li class="active">
         <a href="{{ route('view_journals') }}"> <i class="fa fa-circle-o"></i> View All Entries</a></li>                               
         
         <li class="active">
         <a href="{{ route('create_journal_title') }}"> <i class="fa fa-circle-o"></i> {{ __('Create New Journal') }}</a>
         </li> -->
   </ul>
   </li>
   @endcan
   <li class="{{ getActiveRoute( route('sms.create')) ? "active" : '' }}">
   <a href="{{ route('sms.create') }}">
      <ion-icon name="home"></ion-icon>
      <i class="menu-icon fa fa-envelope"></i><span>{{ __('Bulk Sms') }}</span>
   </a>
   </li>
   <li>
      <a href="{{ route('setting_browse') }}">
         <ion-icon name="home"></ion-icon>
         <i class="menu-icon fa fa-cog"></i><span>{{ __('Settings') }}</span>
      </a>
   </li>
   <!--     <li>-->
   <!--    <a href="{{ url('/profile') }}">-->
   <!--        <ion-icon name="home"></ion-icon>-->
   <!--            <i class="menu-icon fa fa-refresh"></i><span>{{ __('Update Profile') }}</span>-->
   <!--        </a>-->
   <!--</li>-->
   <li>
      <a  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
      <i class="fa fa-power-off"></i> Logout
      </a>
      <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
         {{ csrf_field() }}
      </form>
   </li>
   <li class="menu-divider"></li>
   <li>
      <a href="javascript:void(0);">
      <i class="menu-icon icon-public"></i><span>Version: </span><span
         class="label label-danger">
      {{ config('system.version') }}
      </span>
      </a>
   </li>
</ul>