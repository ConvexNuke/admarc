<?php
require('vendor/autoload.php');
include("../connection/Functions.php");
$operation = new Functions();

// reference the Dompdf namespace
use Dompdf\Dompdf;

$html = '
<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS-->
<link href="./bootstrap.min.css" rel="stylesheet" media="all">
</head>
<table class="table table-borderless" style="background-color: #032147; width: 100%; text-align: center;">
                            <td class="text-center" colspan="2" style="color:#fff;width:100%;background-color: #032147;padding:10px;">
                                <span>ADMARC REPORT</span>
                                <br>
                                <br>
                                
                            <td>
                        </table>
    
                      <div id="" class="">
                        <div class="">
                        <div class="table-responsive">
                        
                        
';


$html_close = '
    </body>
    </html>';
$html_body = '';
if (isset($_GET['admarc_sales'])) {
    $products = $operation->retrieveMany("SELECT *FROM admarc_sales JOIN users ON admarc_sales.user_id = users.user_id");
    $tbl = '';
    foreach ($products as $product) {

        $sale_id = $product['sale_id'];
        $isApproved = ($product['is_approved'] == 1) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';
        $salesCount = $operation->countAll("SELECT *FROM admarc_sale_details WHERE sale_id = '$sale_id'");

        $tbl .= '<tr style="text-align: center">
                    <td style="padding: 10px" class="">' . $product['fname'] . ' ' . $product['lname'] . '</td>
                                                        <td  class=" ">' . $salesCount . '</td>
                                                        <td  class="">' . $product['payment_type'] . ' - ' . $isApproved . '</td>
                                                        <td  class="">' . number_format($product['total'], 2) . '</td>
                                                      
                                                       
                                                    </tr>';

    }


    $html_body = '
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
         <div class="bg-light shadow-sm rounded py-4 mb-4">
                                <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">ADMARC SALES - ' . date('d M Y H:i') . '</h6>


                               

                                <div class="table-responsive">
                                    <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                                        <tr class="bg-light ">
                                            <th class="text-left "><b>Customer</b></th>
                                            <th class="text-left "><b>Products</b></th>
                                            <th class="text-left "><b>Payment Type - isApproved?</b></th>
                                            <th class="text-left "><b>Total (MWK)</b></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            ' . $tbl . '

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

    ';
} elseif (isset($_GET['admarc_sale_details'])) {
    $sale_id = $_GET['admarc_sale_details'];
    $sale = $operation->retrieveSingle("SELECT *FROM admarc_sales JOIN users ON admarc_sales.user_id = users.user_id WHERE sale_id = '$sale_id'");
    $products_bought = $operation->retrieveMany("SELECT * FROM `admarc_sale_details` JOIN admarc_products ON admarc_sale_details.product_id = admarc_products.product_id  WHERE sale_id = '$sale_id'");
    $isApproved = ($sale['is_approved'] == 1) ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>';

    $img = ($sale['payment_type'] != 'Cash') ? '<img src="../assets/images/payment/' . $sale['payment_screenshot'] . '" class="rounded-3 m-4" height="200px" width="200px"/><br><br>' : '';
    $tbl2 = '';

    foreach ($products_bought as $product) {

        $category_id = $product['category_id'];
        $category = $operation->retrieveSingle("SELECT *FROM product_categories WHERE category_id = '$category_id'");
        $tbl2 .= '<tr style="text-align: center">
                   <td  style="padding: 10px" class="text-left"><b>' . $product['product_name'] . '</b> - <small>' . $category['category_name'] . '</small></td>
                       <td class="text-left">' . number_format($product['selling_price'], 2) . '</td>
                                <td class="text-left ">' . $product['qty'] . '</td>
                                                        <td class="text-left ">' . number_format($product['selling_price'], 2) . '</td>
                                                       
                                                    </tr>';
    }


    $html_body = '
             <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">ADMARC SALE DETAILS - ' . date('d M Y H:i') . '</h6>
            <br/>                              
            <table class="table " style="width: 100%; border: 1px solid solid;">
                <tr  style="">
                    <th width="60%">Customer Name</th>
                    <td width="20%">' . $sale['fname'] . ' ' . $sale['lname'] . '</td>
                </tr>
                <tr>
                    <th width="60%">Customer Phone</th>
                    <td width="20%">' . $sale['phone'] . '</td>
                </tr>
                <tr>
                    <th width="60%">Payment Type</th>
                    <td width="20%">' . $sale['payment_type'] . '</td>
                </tr>

                <tr>
                    <th width="60%">Is Approved?</th>
                    <td width="20%">
                        ' . $isApproved . '
                        <div class="mdc-switch mdc-switch--checked mt-2 mx-3"
                             data-mdc-auto-init="MDCSwitch">
                            <div class="mdc-switch__track"></div>
                            <div class="mdc-switch__thumb-underlay">
                                <div class="mdc-switch__thumb">
                                   ' . $isApproved . '
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th width="60%">Sale Total</th>
                    <td width="20%">K ' . number_format($sale['total'], 2) . '</td>
                </tr>
            </table>  
            
            <br/>                              
            <br/>                              
            <br/>
            
            <div class="table-responsive">
                 <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                          <tr class="bg-light ">
                                            <th class="text-left "><b>Product Name</b></th>
                                            <th class="text-left "><b>Product Price (MWK)</b></th>
                                            <th class="text-left "><b>Qty Bought</b></th>
                                            <th class="text-left "><b>Total</b></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        ' . $tbl2 . '


                                        </tbody>
                                    </table>
                                </div>                                    
                                                                         

    ';
} elseif (isset($_GET['products'])) {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
    }
    $logged_user = $_SESSION['user'];
    $user_id = $logged_user['user_id'];
    $products = $operation->retrieveMany("SELECT *FROM products WHERE user_id = '$user_id'");
    $tbl = '';

    foreach ($products as $product) {
        $status = '';
        if ($product['qty'] >= 10) {
            $status = '<i class="text-success">' . $product['qty'] . '</i>';
        } else {
            $status = '<i class="text-danger">' . $product['qty'] . '</i>';

        }
        $category_id = $product['category_id'];
        $category = $operation->retrieveSingle("SELECT *FROM product_categories WHERE category_id = '$category_id'");

        $tbl .= '<tr style="text-align: center">
                                                        <td class="text-left">' . $product['product_name'] . '</td>
                                                        <td class="text-left">' . $category['category_name'] . '</td>
                                                        <td class="text-left">' . number_format($product['price'], 2) . '</td>
                                                        <td class="text-left ">' . $status . '</td>
                                                       
                                                        <td>
                                                      
                                                        </td>
                                                    </tr>';

    }


    $html_body = '
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
         <div class="bg-light shadow-sm rounded py-4 mb-4">
                                <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">PRODUCTS - ' . date('d M Y H:i') . '</h6>


                               

                                <div class="table-responsive">
                                    <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                                        <tr class="bg-light ">
                                            <th class="text-left "><b>Product Name</b></th>
                                            <th class="text-left "><b>Category</b></th>
                                            <th class="text-left "><b>Price (K)</b></th>
                                            <th class="text-left "><b>Qty </b></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            ' . $tbl . '

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

    ';

} elseif (isset($_GET['my_sales'])) {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
    }
    $logged_user = $_SESSION['user'];
    $user_id = $logged_user['user_id'];
    $products = $operation->retrieveMany("SELECT *FROM admarc_products WHERE from_user = '$user_id'");
    $tbl = '';

//    echo '<pre>';
//    print_r($products);
//    echo '</pre>';
//    return;

    foreach ($products as $product) {
        $status = '';
        if ($product['qty_remaining'] >= 10) {
            $status = '<i class="text-success">' . $product['qty_remaining'] . '</i>';
        } else {
            $status = '<i class="text-danger">' . $product['qty_remaining'] . '</i>';
        }
        $category_id = $product['category_id'];
        $category = $operation->retrieveSingle("SELECT *FROM product_categories WHERE category_id = '$category_id'");

        $tbl .= '<tr>
                                                        <td class="text-left"><img src="../assets/images/products/' . $product['img_url'] . '" height="60px" width="60px"><b>' . $product['product_name'] . '</b> - <small>' . $category['category_name'] . '</small></td>
                                                        <td class="text-left">' . number_format($product['buying_price'], 2) . '</td>
                                                        <td class="text-left ">' . $product['qty_obtained'] . '</td>
                                                        <td class="text-left ">' . $product['date_created'] . '</td>
                                                       
                                                    </tr>';

    }

    $html_body = '
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
         <div class="bg-light shadow-sm rounded py-4 mb-4">
                                <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">MY SALES - ' . date('d M Y H:i') . '</h6>


                               

                                <div class="table-responsive">
                                    <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                                        <tr class="bg-light ">
                                            <th class="text-left "><b>Product Name</b></th>
                                            <th class="text-left "><b>Selling Price (K)</b></th>
                                            <th class="text-left "><b>Qty Sold</b></th>
                                            <th class="text-left "><b>Date Sold</b></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            ' . $tbl . '

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

    ';

} elseif (isset($_GET['admarc_items'])) {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
    }
    $logged_user = $_SESSION['user'];
    $user_id = $logged_user['user_id'];
    $products = $operation->retrieveMany("SELECT *FROM admarc_products");
    $tbl = '';

//    echo '<pre>';
//    print_r($products);
//    echo '</pre>';
//    return;

    foreach ($products as $product) {
        $status = '';
        if ($product['qty_remaining'] >= 10) {
            $status = '<i class="text-success">' . $product['qty_remaining'] . '</i>';
        } else {
            $status = '<i class="text-danger">' . $product['qty_remaining'] . '</i>';
        }
        $category_id = $product['category_id'];
        $category = $operation->retrieveSingle("SELECT *FROM product_categories WHERE category_id = '$category_id'");
        $start_date = (!empty($product['date_start_sale'])) ? $product['date_start_sale'] : "--";
        $end_date = (!empty($product['date_end_sale'])) ? $product['date_end_sale'] : "--";
        $tbl .= '<tr style="text-align: center;">
                                                        <td class="text-left">' . number_format($product['buying_price'], 2) . '</td>
                                                        <td class="text-left">' . number_format($product['selling_price'], 2) . '</td>
                                                        <td class="text-left ">' . $product['qty_obtained'] . '</td>
                                                        <td class="text-left ">' . $status . '</td>
                                                        <td class="text-left ">' . $start_date . '</td>
                                                        <td class="text-left ">' . $end_date . '</td>
                                                        <td>
                                                   
                                                        </td>
                                                    </tr>';

    }

    $html_body = '
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
         <div class="bg-light shadow-sm rounded py-4 mb-4">
                                <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">MY SALES - ' . date('d M Y H:i') . '</h6>


                               

                                <div class="table-responsive">
                                    <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                                        <tr class="bg-light ">
                                            <th class="text-left "><b>Product Name</b></th>
                                            <th class="text-left "><b>Buying Price (K)</b></th>
                                            <th class="text-left "><b>Selling Price (K)</b></th>
                                            <th class="text-left "><b>Qty Bought</b></th>
                                            <th class="text-left "><b>Qty Remaining</b></th>
                                            <th class="text-left "><b>Sales Start</b></th>
                                            <th class="text-left "><b>Sales End</b></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            ' . $tbl . '

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

    ';

}elseif (isset($_GET['users'])) {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
    }
    $logged_user = $_SESSION['user'];
    $user_id = $logged_user['user_id'];
    $users = $operation->retrieveMany("SELECT *FROM users WHERE user_id <> '$user_id'");
    $tbl = '';

//    echo '<pre>';
//    print_r($products);
//    echo '</pre>';
//    return;

    foreach ($users as $user) {
        $status = '';
        if ($user['account_status'] == 1) {
            $status = '<i class="text-success">Active</i>';
        } else {
            $status = '<i class="text-danger">Inactive</i>';

        }
        $tbl.= '<tr style="text-align: center;">
                                                        <td class="text-left">' . $user['fname'] . ' ' . $user['lname'] . '</td>
                                                        <td class="text-left ">' . $user['email'] . '</td>
                                                        <td class="text-left ">' . $user['user_role'] . '</td>
                                                        <td class="text-left ">' . $status . '</td>
                                                        <td>
                                                       
                                                        </td>
                                                    </tr>';

    }

    $html_body = '
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
         <div class="bg-light shadow-sm rounded py-4 mb-4">
                                <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">USERS - ' . date('d M Y H:i') . '</h6>


                               

                                <div class="table-responsive">
                                    <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                                        <tr class="bg-light ">
                                             <th class="text-left "><b>Fullname</b></th>
                                            <th class="text-left "><b>Email</b></th>
                                            <th class="text-left "><b>Role</b></th>
                                            <th class="text-left "><b>Status</b></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            ' . $tbl . '

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

    ';

}elseif (isset($_GET['branches'])) {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ../login.php');
    }
    $logged_user = $_SESSION['user'];
    $user_id = $logged_user['user_id'];
    $branches = $operation->retrieveMany("SELECT *FROM branch");
    $tbl = '';

//    echo '<pre>';
//    print_r($products);
//    echo '</pre>';
//    return;

    foreach ($branches as $branch) {

        $tbl .= '<tr style="text-align: center;">
                                                        <td class="text-left">' . $branch['branch_name'] . '</td>
                                                        <td class="text-left ">' . $branch['branch_phone'] . '</td>
                                                      
                                                        
                                                    </tr>';

    }

    $html_body = '
      <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
         <div class="bg-light shadow-sm rounded py-4 mb-4">
                                <h6 class="text-2 text-center font-weight-400 d-flex align-items-center px-4 mb-3">BRANCHES - ' . date('d M Y H:i') . '</h6>


                               

                                <div class="table-responsive">
                                    <table class="table " style="width: 100%; border: 1px solid black;">
                                        <thead style="background-color:black;color:#fff;">
                                        <tr class="bg-light ">
                                              <th class="text-left "><b>Branch Name</b></th>
                                            <th class="text-left "><b>Phone</b></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                            ' . $tbl . '

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        

    ';

}


$html .= $html_body . $html_close;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');


// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();