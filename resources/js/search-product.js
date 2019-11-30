$(document).ready(function(){
    console.log("Hola bitches x3! JAJAJAJA");
    $('#product').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/autocomplete/product',
                method:"POST",
                data:{query:query, _token:_token},
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

    $(document).on('click', 'li.product', function(){
        $('#product').val($(this).text());
        $('#product_id').val($(this).attr("id"));
        $('#productList').fadeOut();
    });

});
