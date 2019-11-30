$(document).ready(function(){
    console.log("Hola bitches x2! JAJAJAJA");
    $('#seller').keyup(function(){
        var query = $(this).val();
        if(query.length > 1){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '/autocomplete/seller',
                method:"POST",
                data:{query:query, _token:_token},
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

    $(document).on('click', 'li.seller', function(){
        $('#seller').val($(this).text());
        $('#seller_id').val($(this).attr("id"));
        $('#sellerList').fadeOut();
    });

});
