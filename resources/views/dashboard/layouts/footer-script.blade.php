@yield('js')
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>



<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
@if ( app()->getLocale() === 'ar')
<link rel="stylesheet" href="{{ asset('dist-rtl/css/adminlte.min.css') }}">
<script src="{{ asset('dist-rtl/js/adminlte.min.js') }}"></script>
@else
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
@endif



