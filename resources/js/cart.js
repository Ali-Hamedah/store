
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
                const errorMessageDiv = document.querySelector(`#item-${itemId} #error-message`);
                $(`#item-${itemId} .subtotal`).text(response.subtotal);
                $('.cart-total').text(response.total);
                errorMessageDiv.style.display = 'none';
            },
            error: error => {
                const errorMessageDiv = document.querySelector(`#item-${itemId} #error-message`);
                if (error.responseJSON && error.responseJSON.error) {
                    errorMessageDiv.textContent = error.responseJSON.error;
                    errorMessageDiv.style.display = 'block';
                    
                } else {
                    errorMessageDiv.textContent = "حدث خطأ غير متوقع.";
                    errorMessageDiv.style.display = 'block'; // إظهار رسالة الخطأ
                }
            }
            
        });
    });
   
  
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault(); 
    
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
document.getElementById('coupon_code').addEventListener('input', function () {
    const couponInput = this.value.trim();
    const applyButton = document.getElementById('apply-coupon-button');

    if (couponInput === "") {
        applyButton.disabled = true; 
    } else {
        applyButton.disabled = false; 
    }
});

