
<!-- jQuery 3 -->
<!-- <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }} "></script> -->
<!-- Bootstrap 3.3.7 -->
<!-- <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script> -->
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }} "></script>
<!-- AdminLTE App -->
<!-- <script src="{{ asset('dist/js/adminlte.min.js') }} "defer></script> -->
<!-- Sparkline -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }} "></script>
<!-- jvectormap  -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }} "></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }} "></script>
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }} "></script>
<!-- ChartJS -->
<script src="{{ asset('/js/app.js') }} "></script>

<!-- <script src="/dist/js/demo.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"defer></script>
<script>
    $('.select_unit').each(function () {
        var total = $('.select_unit').length;

        $(this).on('click', function () {
            var i = 0;
            $('.select_unit').each(function () {
                if ($(this).is(':checked')) {
                    i++;
                }
            });
            if (i === total) {
                $('.select_all').prop('checked', true);

            } else {
                $('.select_all').prop('checked', false);
            }
        });
    });

    $('input[type="checkbox"].select_all').on('change', function () {

        if ($(this).is(':checked')) {
            $('.select_unit').each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $('.select_unit').each(function () {
                $(this).prop('checked', false);
            });
        }
    });

    $('#flash-overlay-modal').modal();
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    $('form').attr('autocomplete','off');
</script>



