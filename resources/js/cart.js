
(function($) {

    $('.item-quantity').on('change', function() {
        const itemId = $(this).data('id'); 
        const newQuantity = $(this).val();

        $.ajax({
            url: "/cart/" + itemId, 
            method: "put",
            data: {
                quantity: newQuantity,
                _token: csrf_token, 
            },
            success: response => {
                $(`#item-${itemId} .subtotal`).text(response.subtotal);
                $('.cart-total').text(response.total);
            },
            error: error => {
                alert("حدث خطأ أثناء تحديث الكمية. حاول مرة أخرى.");
            },
        });
    });
   
  
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault(); // منع السلوك الافتراضي
    
        let id = $(this).data('id'); 
        $.ajax({
            url: "/cart/" + id,
            method: 'delete',
            data: {
                _token: csrf_token 
            },
            success: response => {
                $(`#item-${id}`).remove();
                $('.cart-total').text(response.total);
            },
            error: error => {
                alert("حدث خطأ أثناء حذف العنصر. حاول مرة أخرى.");
            }
        });
    });
    

    $('.add-to-cart').on('click', function(e) {

        $.ajax({
            url: "/cart",
            method: 'post',
            data: {
                product_id: $(this).data('id'),
                quantity: $(this).data('quantity'),
                _token: csrf_token
            },
            success: response => {
                alert('product added')
            }
        });
    });

})(jQuery);