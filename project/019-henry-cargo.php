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
            
            <div class="alert alert-primary" role="alert">
                <p>消費金額: <span id="sum-of-sub-total"></span></p>
                <p>其他折扣: <span id="discount"></span> <span id="discount-tip"></span></p>
                <p>運費: <span id="shipping"></span> <span id="shipping-tip"></span></p>
                <p>總計: <span id="totalGrand"></span></p>
            </div>
            
            
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">訂購人資料</h5>
                    <form name="form1" onsubmit="checkForm(); return false;">
                    <!-- <input type="hidden" name="sid" value="<?= $rows['sid'] ?>"> -->
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
                        <input type="text" class="form-control" id="address" name="address" required>
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">取件方式 <span class="star">*</span></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="pickup_way" required>
                            <option value="" disabled selected>-- 請選擇 --</option>
                            <option value="貨到付款">貨到付款</option>
                            <option value="宅配到府">宅配到府</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="exampleFormControlSelect1">取貨門市 </span></label>
                        <a href="https://emap.pcsc.com.tw/ecmap/default.aspx?eshopparid=899&eshopid=899&eshoppwd=a00013&tempvar=&sid=1&storecategory=3&showtype=1&url=/secure.rakuten.com.tw/checkout/callback">小7門市查詢</a>
                    </div> -->
                    <button type="submit" class="btn btn-primary">結帳</button>
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
    let discount = 0;
    let shipping = 300;
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
        $price.text( 'NT$ ' + $price.attr('data-price') );

        const $qty =  $(el).find('.quantity'); // <select> combo box
        // 如果有的話才設定
        if($qty.attr('data-qty')){
            $qty.val( $qty.attr('data-qty') );
        }
        $qty.removeAttr('data-qty'); // 設定完就移除

        const $sub_total = $(el).find('.sub-total');

        $sub_total.text('NT$ ' + dallorCommas($price.attr('data-price') * $qty.val()));
        total += $price.attr('data-price') * $qty.val();
    });
    // ----------------小計總和-----------------//
    $('#sum-of-sub-total').text( 'NT$ ' + dallorCommas(total));
    // ----------------折扣計算-----------------//
    
    if(total>=6000) {
        $('#sum-of-sub-total').text( 'NT$ ' + dallorCommas(total))
        $('#discount').text( '-NT$ ' + dallorCommas(total*0.1))
        $('#discount-tip').text(' (消費金額已達6000 享9折優惠)')
        discount = total * 0.1
    } else {
        $('#discount-tip').text(`( 再消費$NT ${6000-total}，享9折優惠 )`)
        $('#discount').text( '-NT$ 0' )
        discount = 0
    }
    // ----------------運費計算-----------------//
    if(total>=5000) {
        $('#shipping').text( 'NT$ 0' )
        $('#shipping-tip').text(' (消費金額已達5000，享免運優惠)')
        shipping = 0;
    } else {
        $('#shipping').text( 'NT$ 300')
        $('#shipping-tip').text(`( 再消費$NT ${5000-total}，享免運優惠 )`)
        shipping = 300;
    }
    // ----------------總額計算-----------------//
    total += shipping - discount
    $('#totalGrand').text( 'NT$ ' + dallorCommas(total));

}
calPrices();

//------------------------------------------------以下為結帳功能-----------------------------------------------------------//

const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
    const name = document.querySelector('#name');
    const email = document.querySelector('#email');
    

    function checkForm(){
        //欄位的外觀要回復原來的狀態
        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px #CCCCCC solid';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';
        //資料欄位檢查，如果格式不符，要有欄位提示的不同外觀
        let isPass = true;
        if(name.value.length < 2) {
          isPass = false;
          name.nextElementSibling.innerHTML = '請填寫正確姓名';
          name.style.border = '1px red solid';
        }
        if(! email_re.test(email.value)) {
          isPass = false;
          email.nextElementSibling.innerHTML = '請填寫正確的Email格式';
          email.style.border = '1px red solid';
        }
        if(isPass) {
          const fd = new FormData(document.form1);
          fetch('019-henry-order-insert-api.php', {
              method: 'POST',
              body: fd
          }).then(r=>r.json()).then(obj=>{
              console.log(obj);
              if(obj.success) {     
                alert('感謝訂購')           
                location.href = '019-henry-product-list.php';
              } else {
                alert(obj.error)
              }
          }).catch(error=>{
            console.log('error',error);
          })//錯誤處理，怕回傳的資料不是JSON格式。會造成JS停止
        }
    }

</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>