<?php
include("../../admin/syst/connection/Functions.php");
$operation = new Functions();
//add to cart
session_start();
//print_r($_POST);
//unset($_SESSION['cart_customer']);return;
//echo "<pre>";
//print_r($_SESSION['cart_customer']);
//echo "</pre>";
//return;
if (isset($_POST['add_id']) && isset($_POST['qty']) && isset($_POST['product_name']) && isset($_POST['price'])) {
    $prod_id = addslashes($_POST['add_id']);
    $qty = addslashes($_POST['qty']);
    $product_name = addslashes($_POST['product_name']);
    $price = addslashes($_POST['price']);

    $newitem = array(
        'prod_id' => $prod_id,
        'qty' => $qty,
        'product_name' => $product_name,
        'price' => ($price )
    );
    if (isset($_SESSION['cart_customer']) && !empty($_SESSION['cart_customer'])) {
        if (isset($_SESSION['cart_customer'][$prod_id])) {
            unset($_SESSION['cart_customer'][$prod_id]);
            $_SESSION['cart_customer'][$prod_id] = $newitem;
        } else {
            $_SESSION['cart_customer'][$prod_id] = $newitem;
        }
    } else {
        $_SESSION['cart_customer'][$prod_id] = $newitem;
    }
    $cart_total = 0;
    $html = '';
    $html .= '
        <table style="width: 100%" class="table ">
            <tbody>
                <tr>
                   <th style="text-align: left; padding-left:  30px; width: 40%;"><small>Product Name</small></th>
                    <th style="text-align: left; width: 30%;" ><small>Price (K)</small></th>
                    <th style="text-align: left;width: 20%; " ><small>Quantity</small></th>
                    <th style="text-align: left; width: 10%;"></th>
                </tr>	
            ';
    foreach ($_SESSION['cart_customer'] as $item) {

        $prod_id = $item['prod_id'];
        $product_name = $item['product_name'];

        $qty = $item['qty'];
        $cart_total += $item['price'];

        $html .= '
				<tr>
				<td style="text-align: left">' . $item["product_name"] . '</td>
				<td style="text-align: left">' . number_format($item["price"], 2) . '</td>
				<td  style="text-align: left">' . $item["qty"] . '</td>
				<td style="text-align: left">
				    <a onclick="deleteFromCart(\'' . $item['prod_id'] . '\')" href="#" class="mdc-button mdc-button--danger icon-sm">
                                                <i class="mdi mdi-trash-can-outline mr-2 tx-16"></i>
                     </a>
                </td>
				</tr>
            ';
    }

    $html .= '
            </tbody>
            </table>';
    echo json_encode(array("code" => 1, "count_cart" => count($_SESSION['cart_customer']), 'htmlData' => $html, 'cart_total' => '<b>Total:</b> K' . number_format($cart_total, 2)));

} elseif (isset($_POST['del_id'])) {

    $prod_id = addslashes($_POST['del_id']);

    $cart = array();
    $cart_total = 0;


//        print_r($_SESSION['cart_customer']);return;
    for ($i = 0; $i < count($_SESSION['cart_customer']); $i++) {

        if (isset($_SESSION['cart_customer'][$prod_id])) {
            unset($_SESSION['cart_customer'][$prod_id]); //remove old item

        }
    }
    $html = '';

    if (!empty($_SESSION['cart_customer'])) {
        $html .= '
        <table style="width: 100%" class="table ">
            <tbody>
                <tr>
                   <th style="text-align: left; padding-left:  30px; width: 40%;"><small>Product Name</small></th>
                    <th style="text-align: left; width: 30%;" ><small>Price (K)</small></th>
                    <th style="text-align: left;width: 20%; " ><small>Quantity</small></th>
                    <th style="text-align: left; width: 10%;"></th>
                </tr>	
            ';
        foreach ($_SESSION['cart_customer'] as $item) {

            $prod_id = $item['prod_id'];
            $product_name = $item['product_name'];

            $qty = $item['qty'];
            $cart_total += $item['price'];

            $html .= '
				<tr>
				<td style="text-align: left">' . $item["product_name"] . '</td>
				<td style="text-align: left">' . number_format($item["price"], 2) . '</td>
				<td  style="text-align: left">' . $item["qty"] . '</td>
				<td style="text-align: left">
				    <a onclick="deleteFromCart(\'' . $item['prod_id'] . '\')" href="#" class="mdc-button mdc-button--danger icon-sm">
                                                <i class="mdi mdi-trash-can-outline mr-2 tx-16"></i>
                     </a>
                </td>
				</tr>
            ';
        }

        $html .= '
            </tbody>
            </table>';
    } else {
        $html = '<span class="p-5">No Items in your cart</span>';
    }


    echo json_encode(array("code" => 1, "count_cart" => count($_SESSION['cart_customer']), 'htmlData' => $html, 'cart_total' => '<b>Total:</b> K' . number_format($cart_total, 2)));
} elseif (isset($_POST['finish_payment'])) {

    $cart_total = 0;
    if (isset($_SESSION['cart_customer']) && !empty($_SESSION['cart_customer'])) {
        foreach ($_SESSION['cart_customer'] as $item) {
            $prod_id = $item['prod_id'];
            $qty = $item['qty'];
            $product = $operation->retrieveSingle("SELECT * FROM `products` WHERE product_id = '$prod_id'");

            if ($operation->countAll("SELECT *FROM admarc_products WHERE primary_product_id = '$prod_id'") > 0) {
                $productAdmarc = $operation->retrieveSingle("SELECT *FROM admarc_products WHERE primary_product_id = '$prod_id'");
                $new_qty = $productAdmarc['qty_remaining'] + $qty;
                $tbl = 'admarc_products';
                $data = [
                    'qty_obtained' => $productAdmarc['qty_obtained'] + $qty,
                    'qty_remaining' => $new_qty,
                ];
                $wher = "primary_product_id = '$prod_id'";
                $operation->updateData($tbl, $data, $wher);
            } else {
                $tbl = 'admarc_products';
                $data = [
                    'from_user' => $product['user_id'],
                    'category_id' => $product['category_id'],
                    'primary_product_id' => $prod_id,
                    'product_name' => $product['product_name'],
                    'buying_price' => $product['price'],
                    'qty_obtained' => $qty,
                    'qty_remaining' => $qty,
                    'img_url' => $product['img_url']
                ];
                $operation->insertData($tbl, $data);
            }


            //update source of product
            $new_qty = $product['qty'] - $qty;
            //update
            $table = 'products';
            $where = "product_id = '$prod_id'";
            $dt = [
                'qty' => $new_qty
            ];
            $operation->updateData($table, $dt, $where);
            unset($_SESSION['cart_customer'][$prod_id]); //remove old item
        }

        echo json_encode(array("code" => 1, "msg" => "Successfully acquired new items!"));
    } else {
        echo json_encode(array("code" => 2, "msg" => "Failed checking out, reloading...."));
    }
}
