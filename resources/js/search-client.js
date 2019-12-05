$(document).ready(function(){
    $('#client').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/autocomplete/search',
                method:"POST",
                data:{query:query, _token:_token, table: 'clients'},
                success:function(data){
                    $('#clientList').fadeIn();
                    $('#clientList').html(data);
                }
            });
        }else{
            $('#clientList').fadeOut();
            $('#client_id').val("");
        }
    });

    $(document).on('click', 'li.clients', function(){
        $('#client').val($(this).text());
        $('#client_id').val($(this).attr("id"));
        $('#clientList').fadeOut();
    });
});
