<?php
session_start();
//unset($_SESSION['user']);
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
}
include('connection/Functions.php');
$operation = new Functions();
$logged_user = $_SESSION['user'];
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
$user_role = $_SESSION['user']['user_role'];
$uid = $_SESSION['user']['user_id'];

$year = date('Y');
$html = '';


$months = array();
$record_count = array();

if ($user_role == 'admin' || $user_role == 'stock_manager') {
    $all_users = $operation->countAll('SELECT *FROM users');
    $all_sales_by_year = $operation->retrieveSingle("SELECT SUM(multilplied) AS total FROM (SELECT (prod_total) AS multilplied FROM `admarc_sale_details` WHERE YEAR(date_created) = '$year') S; ");

    $product_categories = $operation->retrieveMany("SELECT 
	product_categories.category_id,category_name, COUNT(admarc_products.product_id) AS products
FROM `admarc_products` 
LEFT JOIN product_categories 
ON admarc_products.category_id = product_categories.category_id 
GROUP BY product_categories.category_name,category_name ORDER BY admarc_products.category_id LIMIT 5; ");
    $count_admarc_products = $operation->countAll("SELECT * FROM `admarc_products` WHERE YEAR(date_created) = '$year'");
    $count_admarc_sales = $operation->countAll("SELECT * FROM `admarc_sales` WHERE YEAR(date_created) = '$year'");

    $yearSales = $operation->retrieveMany('SELECT 
                                CASE 
                                    WHEN (MONTH(date_created) = 1) 
                                        THEN "Jan" 
                                    WHEN (MONTH(date_created) = 2) 
                                        THEN "Feb" 
                                    WHEN (MONTH(date_created) = 3) 
                                        THEN "Mar" 
                                    WHEN (MONTH(date_created) = 4) 
                                        THEN "Apr" 
                                    WHEN (MONTH(date_created) = 5) 
                                        THEN "May" 
                                    WHEN (MONTH(date_created) = 6) 
                                        THEN "Jun" 
                                    WHEN (MONTH(date_created) = 7) 
                                        THEN "Jul" 
                                    WHEN (MONTH(date_created) = 8) 
                                        THEN "Aug" 
                                    WHEN (MONTH(date_created) = 9) 
                                        THEN "Sep" 
                                    WHEN (MONTH(date_created) = 10) 
                                        THEN "Oct" 
                                    WHEN (MONTH(date_created) = 11) 
                                        THEN "Nov" 
                                    WHEN (MONTH(date_created) = 12) 
                                        THEN "Dec" 
                                    ELSE "" END 
                                AS month_name, MONTH(date_created) month_number, COUNT(*) record_count 
                                FROM admarc_sales 
                                WHERE YEAR(date_created)="' . $year . '" 
                                GROUP BY MONTH(date_created),month_name;');

    foreach ($yearSales as $sale) {
        array_push($months, $sale['month_name']);
        array_push($record_count, $sale['record_count']);
    }


    $table = '';
    $i = 1;
    foreach ($product_categories as $product_category) {
        $table .= '
        <tr>
            <td>
            <th>#' . $i . ' </th>
            </td>
            <td>
                ' . $product_category['category_name'] . '
            </td>
            <td>
                ' . $product_category['products'] . '
            </td>
            <!--                                                    <td class=" font-weight-medium"> 39%</td>-->
        </tr>.';

        $i++;
    }


    $html = '
        <main class="content-wrapper">
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--success">
                                <div class="card-inner">
                                    <h5 class="card-title"><small><?= $year ?> </small>Products</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">' . $count_admarc_products . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">48% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">dvr</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--danger">
                                <div class="card-inner">
                                    <h5 class="card-title"><small>' . $year . '</small> Annual Sales </h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">
                                        K' . number_format($all_sales_by_year['total'], 2) . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">55% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <small class="text-light">MWK</small>
                                        <!--                                        <i class="material-icons ">MWK</i>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--primary">
                                <div class="card-inner">
                                    <h5 class="card-title"><small>' . $year . ' Annual Sales </small></h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">' . $count_admarc_sales . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">87% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--info">
                                <div class="card-inner">
                                    <h5 class="card-title">All Users</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">' . $all_users . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">87% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons ">credit_card</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title mb-0" style="margin-left: 20%;">Categories - Products </h4>
                                    <div>
                                        <!--                                        <i class="material-icons refresh-icon">refresh</i>-->
                                        <!--                                        <i class="material-icons options-icon ml-2">more_vert</i>-->
                                    </div>
                                </div>
                                <!--                                <div class="d-block d-sm-flex justify-content-between align-items-center">-->
                                <!--                                    <h5 class="card-sub-title mb-2 mb-sm-0">Sales performance based by-->
                                <!--                                        branch</h5>-->
                                <!--                                    <div class="menu-button-container">-->
                                <!--                                        <button class="mdc-button mdc-menu-button mdc-button--raised button-box-shadow tx-12 text-dark bg-white font-weight-light">-->
                                <!--                                            Last 7 days-->
                                <!--                                            <i class="material-icons">arrow_drop_down</i>-->
                                <!--                                        </button>-->
                                <!--                                        <div class="mdc-menu mdc-menu-surface" tabindex="-1">-->
                                <!--                                            <ul class="mdc-list" role="menu" aria-hidden="true"-->
                                <!--                                                aria-orientation="vertical">-->
                                <!--                                                <li class="mdc-list-item" role="menuitem">-->
                                <!--                                                    <h6 class="item-subject font-weight-normal">Today</h6>-->
                                <!--                                                </li>-->
                                <!--                                                <li class="mdc-list-item" role="menuitem">-->
                                <!--                                                    <h6 class="item-subject font-weight-normal">Last 30 days</h6>-->
                                <!--                                                </li>-->
                                <!---->
                                <!--                                            </ul>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                                <div class="mdc-layout-grid__inner mt-2">
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-2 mdc-layout-grid__cell--span-3-tablet">
                                    </div>
                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-9-tablet">
                                        <div class="table-responsive">
                                            <table class="table dashboard-table" style="width: 100%;">
                                                <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>Category</th>
                                                <th>Products</th>
</tr>
                                                <tbody>
                                              
                                                ' . $table . '

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--                                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6 mdc-layout-grid__cell--span-8-tablet">-->
                                    <!--                                        <div id="revenue-map" class="revenue-world-map"></div>-->
                                    <!--                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-2 mb-sm-0">Sales Overview in year <?= $year ?></h4>
                                    <div class="d-flex justtify-content-between align-items-center">
                                        <!--                                        <p class="d-none d-sm-block text-muted tx-12 mb-0 mr-2">Goal reached</p>-->
                                        <!--                                        <i class="material-icons options-icon">more_vert</i>-->
                                    </div>
                                </div>
                                <div class="d-block d-sm-flex justify-content-between align-items-center">
                                    <!--                                    <h6 class="card-sub-title mb-0">Sales performance revenue based by country</h6>-->

                                </div>
                                <div class="chart-container mt-4">
                                    <canvas id="revenue-chart" height="260"></canvas>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">-->
                        <!--                            <div class="mdc-card">-->
                        <!--                                <div class="d-flex d-lg-block d-xl-flex justify-content-between">-->
                        <!--                                    <div>-->
                        <!--                                        <h4 class="card-title">Order Statistics</h4>-->
                        <!--                                        <h6 class="card-sub-title">Customers 58.39k</h6>-->
                        <!--                                    </div>-->
                        <!--                                    <div id="sales-legend" class="d-flex flex-wrap"></div>-->
                        <!--                                </div>-->
                        <!--                                <div class="chart-container mt-4">-->
                        <!--                                    <canvas id="chart-sales" height="260"></canvas>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </main>
    ';
} else {

    $all_users = $operation->countAll('SELECT *FROM users');
    $all_sales_by_year = $operation->retrieveSingle("SELECT SUM(multilplied) AS total FROM (SELECT (qty_obtained*buying_price) AS multilplied FROM `admarc_products` WHERE YEAR(date_created) = '$year') S; ");

    $count_admarc_products = $operation->countAll("SELECT * FROM `products` WHERE YEAR(date_created) = '$year' AND user_id = '$uid'");
    $count_admarc_sales = $operation->countAll("SELECT * FROM `admarc_products` WHERE YEAR(date_created) = '$year' AND from_user = '$uid'");

    $yearSales = $operation->retrieveMany('SELECT 
                                CASE 
                                    WHEN (MONTH(date_created) = 1) 
                                        THEN "Jan" 
                                    WHEN (MONTH(date_created) = 2) 
                                        THEN "Feb" 
                                    WHEN (MONTH(date_created) = 3) 
                                        THEN "Mar" 
                                    WHEN (MONTH(date_created) = 4) 
                                        THEN "Apr" 
                                    WHEN (MONTH(date_created) = 5) 
                                        THEN "May" 
                                    WHEN (MONTH(date_created) = 6) 
                                        THEN "Jun" 
                                    WHEN (MONTH(date_created) = 7) 
                                        THEN "Jul" 
                                    WHEN (MONTH(date_created) = 8) 
                                        THEN "Aug" 
                                    WHEN (MONTH(date_created) = 9) 
                                        THEN "Sep" 
                                    WHEN (MONTH(date_created) = 10) 
                                        THEN "Oct" 
                                    WHEN (MONTH(date_created) = 11) 
                                        THEN "Nov" 
                                    WHEN (MONTH(date_created) = 12) 
                                        THEN "Dec" 
                                    ELSE "" END 
                                AS month_name, MONTH(date_created) month_number, COUNT(*) record_count 
                                FROM admarc_products 
                                WHERE YEAR(date_created)="' . $year . '" 
                                AND from_user="' . $uid . '" 
                                GROUP BY MONTH(date_created),month_name;');

    foreach ($yearSales as $sale) {
        array_push($months, $sale['month_name']);
        array_push($record_count, $sale['record_count']);
    }


    $table = '';
    $i = 1;


    $html = '
        <main class="content-wrapper">
                <div class="mdc-layout-grid">
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--success">
                                <div class="card-inner">
                                    <h5 class="card-title"><small><?= $year ?> </small>Products</h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">' . $count_admarc_products . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">48% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">dvr</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--danger">
                                <div class="card-inner">
                                    <h5 class="card-title"><small>' . $year . '</small> Annual Sales </h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">
                                        K' . number_format($all_sales_by_year['total'], 2) . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">55% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <small class="text-light">MWK</small>
                                        <!--                                        <i class="material-icons ">MWK</i>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4-desktop mdc-layout-grid__cell--span-4-tablet">
                            <div class="mdc-card info-card info-card--primary">
                                <div class="card-inner">
                                    <h5 class="card-title"><small>' . $year . ' Annual Sales </small></h5>
                                    <h5 class="font-weight-light pb-2 mb-1 border-bottom">' . $count_admarc_sales . '</h5>
                                    <!--                                    <p class="tx-12 text-muted">87% target reached</p>-->
                                    <div class="card-icon-wrapper">
                                        <i class="material-icons">trending_up</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                       

                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                            <div class="mdc-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title mb-2 mb-sm-0">Sales Overview in year <?= $year ?></h4>
                                    <div class="d-flex justtify-content-between align-items-center">
                                        <!--                                        <p class="d-none d-sm-block text-muted tx-12 mb-0 mr-2">Goal reached</p>-->
                                        <!--                                        <i class="material-icons options-icon">more_vert</i>-->
                                    </div>
                                </div>
                                <div class="d-block d-sm-flex justify-content-between align-items-center">
                                    <!--                                    <h6 class="card-sub-title mb-0">Sales performance revenue based by country</h6>-->

                                </div>
                                <div class="chart-container mt-4">
                                    <canvas id="revenue-chart" height="260"></canvas>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-4 mdc-layout-grid__cell--span-8-tablet">-->
                        <!--                            <div class="mdc-card">-->
                        <!--                                <div class="d-flex d-lg-block d-xl-flex justify-content-between">-->
                        <!--                                    <div>-->
                        <!--                                        <h4 class="card-title">Order Statistics</h4>-->
                        <!--                                        <h6 class="card-sub-title">Customers 58.39k</h6>-->
                        <!--                                    </div>-->
                        <!--                                    <div id="sales-legend" class="d-flex flex-wrap"></div>-->
                        <!--                                </div>-->
                        <!--                                <div class="chart-container mt-4">-->
                        <!--                                    <canvas id="chart-sales" height="260"></canvas>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                    </div>
                </div>
            </main>
    ';



}

?>
<!DOCTYPE html>
<html lang="en">
<?php include('includes/css.php'); ?>
<body>
<script src="../assets/js/preloader.js"></script>
<div class="body-wrapper">
    <?php include('includes/aside.php'); ?>
    <div class="main-wrapper mdc-drawer-app-content">

        <?php

        include('includes/header.php');

        ?>
        <div class="page-wrapper mdc-toolbar-fixed-adjust">
            <?= $html ?>
            <?php include("includes/footer.php"); ?>
        </div>
    </div>
</div>
<?php include('includes/scripts.php'); ?>
<script type="application/javascript">

    (function ($) {
        'use strict';
        $(function () {

            //Revenue Chart
            if ($("#revenue-chart").length) {
                var revenueChartCanvas = $("#revenue-chart").get(0).getContext("2d");

                var revenueChart = new Chart(revenueChartCanvas, {
                    type: 'bar',
                    data: {
                        labels: <?=json_encode($months)?>,
                        datasets: [{
                            data: <?=json_encode($record_count) ?>,
                            backgroundColor: "rgba(255, 86, 48, 0.3)",
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    drawBorder: false,
                                    zeroLineColor: "rgba(0, 0, 0, 0.09)",
                                    color: "rgba(0, 0, 0, 0.09)"
                                },
                                ticks: {
                                    fontColor: '#bababa',
                                    min: 0,
                                    stepSize: 100,
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    fontColor: '#bababa',
                                    beginAtZero: true
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                barPercentage: 0.4
                            }]
                        },
                        legend: {
                            display: false
                        }
                    }
                });
            }


        });
    })(jQuery);


</script>
</body>
</html> 