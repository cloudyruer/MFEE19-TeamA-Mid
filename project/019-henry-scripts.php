<script src="js/jquery-3.6.0.js"></script>
<script src="bootstrap4/js/bootstrap.bundle.js"></script>
<script>
    $.get('019-henry-add-to-cart-api.php', function(data){
        countCartObj(data);
    }, 'json');

    function countCartObj(data){
        let total = 0;
        for(let i in data){
            total += data[i];
        }
        $('.cart-count').text(total);
    }
</script>