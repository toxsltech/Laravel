@section('after_footer')
<script>
toastr.options = {
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "showDuration": "200",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000"
}
</script>
@if ($message = Session::get('success'))
    <script>
    	toastr["success"]("{{ $message }}")
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
    	toastr["error"]("{{ $message }}")
    </script>
@endif

@if ($message = Session::get('warning'))
    <script>
    	toastr["warning"]("{{ $message }}")
    </script>
@endif

@if ($message = Session::get('info'))
    <script>
    	toastr["info"]("{{ $message }}")
    </script>
@endif

@if ($errors->any())
	<script>
    	toastr["error"]("Please check the form for errors")
    </script>
@endif
@endsection
