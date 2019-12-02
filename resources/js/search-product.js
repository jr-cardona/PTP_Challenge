$(document).ready(function(){
    $('#product').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/autocomplete/search',
                method:"POST",
                data:{query:query, _token:_token, table: 'products'},
                success:function(data){
                    $('#productList').fadeIn();
                    $('#productList').html(data);
                }
            });
        }else{
            $('#productList').fadeOut();
            $('#product_id').val("");
        }
    });

    $(document).on('click', 'li.products', function(){
        $('#product').val($(this).text());
        $('#product_id').val($(this).attr("id"));
        $('#productList').fadeOut();
    });

});
