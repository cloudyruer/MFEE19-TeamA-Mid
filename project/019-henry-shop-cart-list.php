<?php
require __DIR__ . "/partials/init.php";
$title = "購物車";
$pKeys = array_keys($_SESSION['cart']);

$rows = []; // 預設值
$data_ar = []; // dict

if(!empty($pKeys)) {
    $sql = sprintf("SELECT * FROM product_list WHERE sid IN(%s)", implode(',', $pKeys));
    $rows = $pdo->query($sql)->fetchAll();

    foreach($rows as $r) {
        $r['quantity'] = $_SESSION['cart'][$r['sid']];
        $data_ar[$r['sid']] = $r;
    }
}
?>
<?php include __DIR__ . "/partials/html-head.php"; ?>
<?php include __DIR__ . "/019-henry-css.php"; ?>
<?php include __DIR__ . "/partials/navbar.php"; ?>

<div class="container pb-3">
    <?php include __DIR__ . "/019-henry-btn_page.php"; ?>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col"><i class="fas fa-trash-alt"></i></th>
                        <th scope="col">商品</th>
                        <th scope="col">品名</th>
                        <th scope="col">價格</th>
                        <th scope="col">數量</th>
                        <th scope="col">小計</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($_SESSION['cart'] as $sid=>$qty):
                        $item = $data_ar[$sid];
                        ?>
                    <tr class="p-item" data-sid="<?= $sid ?>">
                        <td><a href="#" onclick="removeProductItem(event)"><i class="fas fa-trash-alt"></i></a></td>
                        <td><img src="imgs/<?= $item['product_img'] ?>.jpg" alt=""></td>
                        <td><?= $item['product_name'] ?></td>
                        <td class="price" data-price="<?= $item['product_price'] ?>"></td>
                        <td>
                            <select class="form-control quantity" data-qty="<?= $item['quantity'] ?>" onchange="changeQty(event)">
                                <?php for($i=1; $i<=20; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td class="sub-total"></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="alert alert-primary" role="alert">總計: <span id="totalAmount"></span></div>
            
            
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">訂購人資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false;">
                    <div class="form-group">
                        <label for="name">姓名 <span class="star">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="王大明">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="star">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="php@gmail.com">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="mobile">手機 <span class="star">*</span></label>
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="0912-345-678">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="address">聯絡地址 <span class="star">*</span></label>
                        <input type="text" class="form-control" id="address" name="address">
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">取件方式 <span class="star">*</span></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="pickup_way" required>
                            <option value="" disabled selected>-- 請選擇 --</option>
                            <option value="1">貨到付款</option>
                            <option value="2">宅配到府</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">取貨門市 </span></label>
                        <a href="https://emap.pcsc.com.tw/ecmap/default.aspx?eshopparid=899&eshopid=899&eshoppwd=a00013&tempvar=&sid=1&storecategory=3&showtype=1&url=/secure.rakuten.com.tw/checkout/callback">小7門市查詢</a>
                    </div>
                    <div class="questions">
                        <p>要如何從localhost成功連到小7?</p>
                        <p></p>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">新增</button>
                    </form>
                </div>
            </div>
            

            <?php if(isset($_SESSION['user'])): ?>
                <a href="019-henry-save-orders.php" class="btn btn-success">結帳</a>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">請先登入會員再結帳</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include __DIR__ . "/019-henry-scripts.php"; ?>
<script>

const dallorCommas = function(n){
    return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
};

function removeProductItem(event){
    event.preventDefault(); // 避免 <a> 的連結
    const tr = $(event.target).closest('tr.p-item')
    const sid = tr.attr('data-sid');

    $.get('019-henry-add-to-cart-api.php', {sid}, function(data){
        tr.remove();
        countCartObj(data);
        calPrices();
    }, 'json');
}

function changeQty(event){
    let qty = $(event.target).val();
    
    let tr = $(event.target).closest('tr');
    
    let sid = tr.attr('data-sid');
    

    $.get('019-henry-add-to-cart-api.php', {sid, qty}, function(data){
        countCartObj(data);
        calPrices();
    }, 'json');
}

function calPrices() {
    const p_items = $('.p-item');
    let total = 0;
    if(! p_items.length){
        alert('請先將商品加入購物車');
        location.href = '019-henry-product-list.php';
        return;
    }

    p_items.each(function(i, el){
        // console.log( $(el).attr('data-sid') );
        // let price = parseInt( $(el).find('.price').attr('data-price') );
        // let price = $(el).find('.price').attr('data-price') * 1;

        const $price = $(el).find('.price'); // 價格的 <td>
        $price.text( '$ ' + $price.attr('data-price') );

        const $qty =  $(el).find('.quantity'); // <select> combo box
        // 如果有的話才設定
        if($qty.attr('data-qty')){
            $qty.val( $qty.attr('data-qty') );
        }
        $qty.removeAttr('data-qty'); // 設定完就移除

        const $sub_total = $(el).find('.sub-total');

        $sub_total.text('$ ' + dallorCommas($price.attr('data-price') * $qty.val()));
        total += $price.attr('data-price') * $qty.val();
    });

    $('#totalAmount').text( '$ ' + dallorCommas(total));

}
calPrices();

</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>