<div class="internet-connection-status" id="internetStatus"></div>
<div class="footer-nav-area" id="footerNav">
   <div class="container-fluid h-100 px-0">
      <div class="keja-footer-nav h-100">
         <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
            <li class="@if (Request::path() == 'home' || Request::path() == '/') active @else @endif"><a href="{{url('/')}}"><i class="fa fa-home"></i>Home</a></li>
            @if(Auth::guest())
            <li><a href="javascript:void;" data-bs-toggle="modal" data-bs-target="#oneTapLogin"><i class="fa fa-hand-pointer"></i>Login</a></li>
            <li class="{{ (request()->is('login')) ? 'active' : '' }}"><a href="{{url('/login')}}"><i class="fa fa-sign-in"></i>Sign In</a></li>
            <li class="{{ (request()->is('register')) ? 'active' : '' }}"><a href="{{url('/register')}}"><i class="fa fa-user-plus"></i>Sign Up</a></li>
            @else
            <li class="{{ (request()->is('landlord*')) ? 'active' : '' }}"><a href="{{ route('landlord_browse') }}"><i class="fa fa-user-tie"></i> Landlords</a></li>
            <li class="{{ (request()->is('building*')) ? 'active' : '' }}"><a href="{{ route('building_browse') }}"><i class="fa fa-building"></i>Buildings</a></li>
            <li class="{{ (request()->is('tenant*')) ? 'active' : '' }}"><a href="{{ route('tenant_browse') }}"><i class="fa fa-users"></i>Tenants</a></li>
            @endif
            <li><a data-bs-toggle="offcanvas" data-bs-target="#toggleSideNav" aria-controls="toggleSideNav" href="javascript:void();"><i class="fa fa-cog"></i>Account</a></li>
         </ul>
      </div>
   </div>
</div>