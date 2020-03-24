$.fn.editable.defaults.ajaxOptions = {type: "PUT"};
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.update').editable({
    validate:function(value){
        if ($.trim(value) === '') {
            return "Field is required";
        }
    }
});
