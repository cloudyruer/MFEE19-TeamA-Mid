<?php
require __DIR__ . "/partials/init.php";
$title = "購物車";
$pKeys = array_keys($_SESSION['cart']);

$rows = []; // 預設值
$data_ar = []; // dict

if (!empty($pKeys)) {
    $sql = sprintf("SELECT * FROM product_list WHERE sid IN(%s)", implode(',', $pKeys));
    $rows = $pdo->query($sql)->fetchAll();
    foreach ($rows as $r) {
        $r['quantity'] = $_SESSION['cart'][$r['sid']];
        $data_ar[$r['sid']] = $r;
    }

}

$pickup_way = $pdo->query("SELECT * FROM `store` WHERE `parents_id` = 0")->fetchAll();
// $pickup_store = $pdo->query("SELECT * FROM `store`")->fetchAll();
echo json_encode($pickup_way)
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
                    <th scope="col">商品圖片</th>
                    <th scope="col">品名</th>
                    <th scope="col">價格</th>
                    <th scope="col">數量</th>
                    <th scope="col">小計</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['cart'] as $sid => $qty) :
                    $item = $data_ar[$sid];
                ?>
                    <tr class="p-item" data-sid="<?= $sid ?>">
                        <td><a href="#" onclick="removeProductItem(event)"><i class="fas fa-trash-alt"></i></a></td>
                        <td><img src="imgs/<?= $item['product_img'] ?>" alt=""></td>
                        <td><?= $item['product_name'] ?></td>
                        <td class="price" data-price="<?= $item['product_price'] ?>" id="price<?= $sid ?>"></td>
                        <td>
                            <select class="form-control quantity" data-qty="<?= $item['quantity'][0] ?>" id="qty<?= $sid ?>" onchange="changeQty(event)">
                                <?php for ($i = 1; $i <= 100; $i++) : ?>
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
            <p>總計: NT$ <span id="totalGrand"></span></p>
        </div>
        
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
                        <input type="text" class="form-control" id="address" name="address" required>
                        <small class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="order_status">付款方式 <span class="star">*</span></label>
                        <select class="form-control" id="order_status" name="order_status" required>
                            <option value="" disabled selected>-- 請選擇 --</option>
                            <option value="等待結帳">宅配貨到付款</option>
                            <option value="已經結帳">ATM轉帳</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="pickup_way">取件方式 <span class="star">*</span></label>
                        <select class="form-control" id="pickup_way" name="pickup_way" required>
                            <option value="" disabled selected>-- 請選擇 --</option>
                            <option value="貨到付款">7-11取貨付款</option>
                            <option value="宅配到府">宅配到府</option>
                        </select>
                    </div>
                    
                    <div class="form-group d-none" id="store">
                        <label for="pickup_store">取貨門市 <span class="star">*</span></label>
                        <select class="form-control" id="pickup_store" name="pickup_store" required>
                            <option value="" disabled selected>-- 請選擇 --</option>
                            <option value="板仁門市">板仁門市</option>
                            <option value="仁金門市">仁金門市</option>
                            <option value="學央門市">學央門市</option>
                            <option value="竹盈門市">竹盈門市</option>
                            <option value="景旭門市">景旭門市</option>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <label for="pickup_way">取貨門市</label>
                        <select class="form-control" id="pickup_way" name="pickup_way">
                        <option disabled selected>請選擇</option>
                        <?php foreach($pickup_way as $cm) : ?>
                        <option value="<?= $cm['sid'] ?>"><?= $cm['name'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="pickup_store">取貨門市</label>
                        <select class="form-control" id="pickup_store" name="pickup_store">
                        <option disabled selected>請選擇</option>
                        <?php foreach($pickup_store as $cc) : ?>
                        <option value="<?= $cc['sid'] ?>"><?= $cc['name'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>    -->
                    <div class="form-group">
                        <label for="pickup_store">取貨門市</label>
                        <select class="form-control" id="pickup_store" name="pickup_store">
                        <option disabled selected>請選擇</option>
                        </select>
                    </div>

                    
                    <div class="form-group d-none" id="payment">
                        <p class="text-success">
                            匯款資訊<br>
                            中華郵政 代碼 : 700<br>
                            戶名 : 資策會<br>
                            帳號 : 01234567898765<br>
                        </p>
                    </div>
                    <div class="form-group d-none">
                        <label for="total_price">總金額</span></label>
                        <input type="text" class="form-control" id="total_price" name="total_price" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">結帳</button>
                </form>
            </div>
        </div>
        <?php if (!isset($_SESSION['user'])) : ?>
            <div class="alert alert-danger" role="alert">請先登入會員再結帳</div>
        <?php endif; ?>
    </div>
</div>

</div>
<?php include __DIR__ . "/019-henry-scripts.php"; ?>
<script>


$(function() {
        $('#pickup_way').change(function() {
            //更動第一層時第二層清空
            $('#pickup_store').empty().append("<option disabled value=''>請選擇</option>");
            var i = 0;
            $.ajax({
                type: "GET",
                url: "019-henry-store.php",
                data: {
                    lv: $('#pickup_way option:selected').val()
                },
                datatype: "json",
                success: function(result) {
                    //當第一層回到預設值時，第二層要如何顯示之前的預設值呢?
                    if (result == "") {
                        $("#pickup_way").append("<option value='" + result[i]['name'] + "'"  + ">" + result[i]['name'] + "</option>");
                     
                    }
                    //依據第一層回傳的值去改變第二層的內容
                    while (i < result.length) {
                        $("#pickup_store").append("<option value='" + result[i]['name'] + "'"  + ">" + result[i]['name'] + "</option>");
                        i++;
                    }
                },
                error: function(xhr, status, msg) {
                    console.error(xhr);
                    console.error(msg);
                }
            });
        });
    });





    


    $('#order_status').click(function(){
        if($('#order_status').val()==='已經結帳') {
            $('#payment').removeClass('d-none')
        } else {
            $('#payment').addClass('d-none')
        }
    })
    


    const dollarCommas = function(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    };

    function removeProductItem(event) {
        event.preventDefault(); // 避免 <a> 的連結
        const tr = $(event.target).closest('tr.p-item')
        const sid = tr.attr('data-sid');

        $.get('019-henry-add-to-cart-api.php', {
            sid
        }, function(data) {
            tr.remove();
            countCartObj(data);
            calPrices();
        }, 'json');
    }

    function changeQty(event) {
        let qty = $(event.target).val();

        let tr = $(event.target).closest('tr');

        let sid = tr.attr('data-sid');


        $.get('019-henry-add-to-cart-api.php', {
            sid,
            qty
        }, function(data) {
            countCartObj(data);
            calPrices();
        }, 'json');
    }

    function calPrices() {
        const p_items = $('.p-item');
        let total = 0;
        let discount = 0;
        let shipping = 300;
        if (!p_items.length) {
            alert('請先將商品加入購物車');
            location.href = '019-henry-product-list.php';
            return;
        }

        p_items.each(function(i, el) {
            // console.log( $(el).attr('data-sid') );
            // let price = parseInt( $(el).find('.price').attr('data-price') );
            // let price = $(el).find('.price').attr('data-price') * 1;

            const $price = $(el).find('.price'); // 價格的 <td>
            $price.text('NT$ ' + dollarCommas($price.attr('data-price')));

            const $qty = $(el).find('.quantity'); // <select> combo box
            
            // 如果有的話才設定
            if ($qty.attr('data-qty')) {
                $qty.val($qty.attr('data-qty'));
            }
            $qty.removeAttr('data-qty'); // 設定完就移除

            const $sub_total = $(el).find('.sub-total');

            $sub_total.text('NT$ ' + dollarCommas($price.attr('data-price') * $qty.val()));
            total += $price.attr('data-price') * $qty.val();
        });
        // ----------------小計總和-----------------//
        $('#sum-of-sub-total').text('NT$ ' + dollarCommas(total));
        // ----------------折扣計算-----------------//

        if (total >= 6000) {
            $('#sum-of-sub-total').text('NT$ ' + dollarCommas(total))
            $('#discount').text('-NT$ ' + dollarCommas(total * 0.1))
            $('#discount-tip').text(' (消費金額已達6,000，享9折優惠)')
            discount = total * 0.1
        } else {
            let rest = 6000 - total
            let dollarComma = dollarCommas(rest)
            $('#discount-tip').text(`( 再消費$NT ${dollarComma}，享9折優惠 )`)
            $('#discount').text('-NT$ 0')
            discount = 0
        }
        // ----------------運費計算-----------------//
        if (total >= 5000) {
            $('#shipping').text('NT$ 0')
            $('#shipping-tip').text(' (消費金額已達5,000，享免運優惠)')
            shipping = 0;
        } else {
            let rest = 6000 - total
            let dollarComma = dollarCommas(rest)
            $('#shipping').text('NT$ 300')
            $('#shipping-tip').text(`( 再消費$NT ${dollarComma}，享免運優惠 )`)
            shipping = 300;
        }
        // ----------------總額計算-----------------//
        total += shipping - discount
        $('#totalGrand').text(dollarCommas(total));

        $('#total_price').val(total)
    }
    calPrices();

    //------------------------------------------------以下為結帳功能-----------------------------------------------------------//

    const email_re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const mobile_re = /^09\d{2}-?\d{3}-?\d{3}$/;
    const name = document.querySelector('#name');
    const email = document.querySelector('#email');


    function checkForm() {
        //欄位的外觀要回復原來的狀態
        name.nextElementSibling.innerHTML = '';
        name.style.border = '1px #CCCCCC solid';
        email.nextElementSibling.innerHTML = '';
        email.style.border = '1px #CCCCCC solid';
        //資料欄位檢查，如果格式不符，要有欄位提示的不同外觀
        let isPass = true;
        if (name.value.length < 2) {
            isPass = false;
            name.nextElementSibling.innerHTML = '請填寫正確姓名';
            name.style.border = '1px red solid';
        }
        if (!email_re.test(email.value)) {
            isPass = false;
            email.nextElementSibling.innerHTML = '請填寫正確的Email格式';
            email.style.border = '1px red solid';
        }
        if (isPass) {
            const fd = new FormData(document.form1);
            fetch('019-henry-order-insert-api.php', {
                method: 'POST',
                body: fd
            }).then(r => r.json()).then(obj => {
                console.log(obj);
                if (obj.success) {
                    alert('感謝訂購')
                    location.href = '019-henry-product-list.php';
                } else {
                    alert(obj.error)
                }
            }).catch(error => {
                console.log('error', error);
            }) //錯誤處理，怕回傳的資料不是JSON格式。會造成JS停止
        }
    }
</script>
<?php include __DIR__ . '/partials/html-foot.php'; ?>