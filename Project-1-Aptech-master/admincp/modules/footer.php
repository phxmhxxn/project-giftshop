<div>
    <br><br><br><br>
    <br><br><br><br>
    <br><br><br><br>
</div>


<script>

    $(document).ready(function() {

        $('#subtotal').html(<?= $subtotal - $shippingfee ?>)
        total = $('#subtotal').html();
        $('#shippingfee').on('input', function() {
            fee = $('#shippingfee').val();
            paid = $('#buyerpaid').val();
            $('#subtotal').html(parseFloat(total) - parseFloat(fee) + parseFloat(paid));
        });
        $('#buyerpaid').on('input', function() {
            fee = $('#shippingfee').val();
            paid = $('#buyerpaid').val();
            $('#subtotal').html(parseFloat(total) - parseFloat(fee) + parseFloat(paid));
        });
    });
</script>