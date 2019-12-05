$(document).ready(function(){
    $('#seller').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/autocomplete/search',
                method:"POST",
                data:{query:query, _token:_token, table: 'sellers'},
                success:function(data){
                    $('#sellerList').fadeIn();
                    $('#sellerList').html(data);
                }
            });
        }else{
            $('#sellerList').fadeOut();
            $('#seller_id').val("");
        }
    });

    $(document).on('click', 'li.sellers', function(){
        $('#seller').val($(this).text());
        $('#seller_id').val($(this).attr("id"));
        $('#sellerList').fadeOut();
    });

});
