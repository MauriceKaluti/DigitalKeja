<!DOCTYPE html>
<html lang="en">
   @include('layouts.header')
   <script type="text/javascript">
      var Tawk_API=Tawk_API||{},Tawk_LoadStart=new Date;!function(){var e=document.createElement("script"),t=document.getElementsByTagName("script")[0];e.async=!0,e.src="https://embed.tawk.to/6275ada97b967b11798e288b/1g2dqson7",e.charset="UTF-8",e.setAttribute("crossorigin","*"),t.parentNode.insertBefore(e,t)}()
   </script>
   <body class="hold-transition skin-{{ setting('company_skin', 'green') }} fixed sidebar-mini">
      <div class="wrapper">
         <header class="main-header">
            <a href="{{ url('/') }}" class="logo">
            </a>
            @include('layouts.topbar')
         </header>
         <!-- Left side column. contains the logo and sidebar -->
         <div id="app">
            <aside class="main-sidebar">
               <!-- sidebar: style can be found in sidebar.less -->
               <section class="sidebar">
                  <!-- Sidebar user panel -->
                  <div class="user-panel">
                     <div class="pull-left image">
                        <img src="{{ asset('dist/img/user2-160x160.png') }}" width="20%" class="img-circle"
                           alt="User Image">
                     </div>
                     <div class="pull-left info">
                        <p>{{ auth()->user()->name }}</p>
                        <a href="{{ url('/profile') }}"><i class="fa fa-circle text-success"></i> Online</a>
                     </div>
                  </div>
                  @include('layouts.sidebar')
                  <!-- sidebar menu: : style can be found in sidebar.less -->
               </section>
               <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
               <!-- Content Header (Page header) -->
               <section class="content-header">
                  <h1>
                     @yield('title','Dashboard')
                  </h1>
                  <ol class="breadcrumb">
                     <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                     <li class="active">@yield('title','Dashboard')</li>
                  </ol>
               </section>
               <!-- Main content -->
               <section class="content">
                  @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible">
                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                     &times;
                     </button>
                     @foreach ($errors->all() as $error)
                     <p>{{ $error }}</p>
                     @endforeach
                  </div>
                  @endif
                  @include('flash::message')
                  @yield('content')
               </section>
            </div>
            <footer class="main-footer">
               <div class="pull-right hidden-xs">
                  <b>Version</b> {{ config('system.version') }}
               </div>
               <strong>Franro Holdings | Copyright &copy; {{ now()->format('Y') }} </strong>
            </footer>
         </div>
      </div>
      @include('layouts.footer')
      @yield('extra_js')
      @yield('js')
      @yield('javascript')
   </body>
</html>