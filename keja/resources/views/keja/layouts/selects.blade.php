
<link href="{{asset('selects/select2.min.css')}}" rel="stylesheet" />

<script src="{{asset('selects/select2.min.js')}} "></script>

<script type="text/javascript">
$(document).ready(function() {
$("select").on("select2:open", function(event) {
    $('input.select2-search__field').attr('placeholder', 'Search Here...');
});
	
$("#building").select2({
placeholder: "Select Building",
allowClear: true,
width: '100%'
});

$("#keja_users").select2({
placeholder: "Select User",
allowClear: true,
width: '100%'
});

$("#room").select2({
placeholder: "Select Room",
allowClear: true,
width: '100%'
});

$("#keja_modules").select2({
placeholder: "Select Module",
allowClear: true,
width: '100%'
});

$("#keja_exams").select2({
placeholder: "Select Exam",
allowClear: true,
width: '100%'
});
 
$("#keja_roles").select2({
placeholder: "Select Role",
 maximumSelectionLength: 1,
allowClear: true,
width: '100%'
});
 

$("#status").select2({
placeholder: "Select Status",
allowClear: true,
width: '100%'
});
 

$("#update_status").select2({
placeholder: "Select Status",
allowClear: true,
width: '100%'
});

$("#keja_gender").select2({
placeholder: "Select Gender",
allowClear: true,
width: '100%'
});
 

$("#courses").select2({
placeholder: "Select Course",
allowClear: true,
width: '100%'
});

$("#coursecategories").select2({
placeholder: "Select Course Category",
allowClear: true,
width: '100%'
});


$("#modules").select2({
placeholder: "Select Module",
allowClear: true,
width: '100%'
});


});
</script>