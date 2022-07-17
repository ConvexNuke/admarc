<?php
include('includes/header.php');
$categories = $operation->retrieveMany("SELECT *FROM product_categories ORDER BY category_name ");
//    print_r($categories[1]);


if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category = $_GET['category'];
    $products = $operation->retrieveMany(
        "SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0 AND category_id = '$category'
                AND selling_price > 0
            ");
} else {
    $products = $operation->retrieveMany(
        "SELECT *
                FROM admarc_products 
                WHERE qty_remaining > 0
                AND selling_price > 0
            ");
}
?>


    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_1.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Products</span>
                    </p>
                    <h1 class="mb-0 bread">Products</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10 mb-5 text-center">
                    <ul class="product-category">
                        <?php
                        if (empty($categories)) {
                            echo '<li><a href="shop.php" class="active">All</a></li>';
                        } else {
                            if (isset($_GET['category']) && !empty($_GET['category'])) {
                                echo '<li><a href="shop.php" class="">All</a></li>';
                                foreach ($categories as $category) {
                                    $cat_ = $category['category_id'];
                                    $countCatProducts = $operation->countAll("SELECT *FROM admarc_products WHERE category_id = '$cat_' AND qty_remaining > 0 AND  selling_price > 0");

                                    if ($category['category_id'] == $_GET['category']) {

                                        echo '<li><a href="shop.php?category=' . $category['category_id'] . '" class="active">' . $category['category_name'] . '<small>(' . $countCatProducts . ')</small></a></li>';
                                    } else {
                                        echo '<li><a href="shop.php?category=' . $category['category_id'] . '" class="">' . $category['category_name'] . '<small>(' . $countCatProducts . ')</small></a></li>';
                                    }
                                }
                            } else {

                                echo '<li><a href="#" class="active">All</a></li>';

                                foreach ($categories as $category) {
                                    $cat_ = $category['category_id'];
                                    $countCatProducts = $operation->countAll("SELECT *FROM admarc_products WHERE category_id = '$cat_' AND qty_remaining > 0 AND  selling_price > 0");

                                    echo '<li><a href="shop.php?category=' . $category['category_id'] . '" class="">' . $category['category_name'] . '<small>(' . $countCatProducts . ')</small></a></li>';
                                }
                            }

                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="">
                <?php
                if (empty($products)) {
                    echo '<p class="mt-3 alert alert-warning text-center" style="width: 100%;">No products in selected category!</p>';
                } else {

                    ?>
                    <table style="width:100%" class="" id="news_table">
                        <tr>
                            <td>
                                <div class="row" style="">

                                    <?php


                                    foreach ($products as $product) {
                                        ?>

                                        <div class="col-md-6 col-lg-3 ftco-animate">
                                            <div class="product">
                                                <a href="product-single.php?product=<?= $product['product_id'] ?>"
                                                   class="img-prod"><img
                                                            style="height: 130px; width: 180px; display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;" class="img-fluid"
                                                            src="../admin/assets/images/products/<?= $product['img_url'] ?>"
                                                            alt="Product">
                                                    <div class="overlay"></div>
                                                </a>
                                                <div class="text py-3 pb-4 px-3 text-center">
                                                    <h3><a href="#"><?= $product['product_name'] ?></a></h3>
                                                    <div class="d-flex">
                                                        <div class="pricing">
                                                            <p class="price">
                                                                <span>K<?= number_format($product['selling_price'], 2) ?></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="bottom-area d-flex px-3">
                                                        <div class="m-auto d-flex">
                                                            <a href="product-single.php?product=<?= $product['product_id'] ?>"
                                                               class="add-to-cart d-flex justify-content-center align-items-center text-center">
                                                                <span><i class="ion-ios-information-circle"></i></span>
                                                            </a>
                                                            <a href="#"
                                                               onclick="addToCart('<?= $product['product_id'] ?>', '<?= $product['product_name'] ?>', '<?= $product['selling_price'] ?>', 'inline')"
                                                               id="btn_cart_add<?= $product['product_id'] ?>"
                                                               class="buy-now d-flex justify-content-center align-items-center mx-1">
                                                                <span><i class="ion-ios-cart"></i></span>
                                                            </a>
                                                            <!--                                            <a href="#" class="heart d-flex justify-content-center align-items-center ">-->
                                                            <!--                                                <span><i class="ion-ios-heart"></i></span>-->
                                                            <!--                                            </a>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>
                            </td>

                        </tr>

                    </table>
                    <?php
                }

                ?>

            </div>
            <!--            <div class="row mt-5">-->
            <!--                <div class="col text-center">-->
            <!--                    <div class="block-27">-->
            <!--                        <ul>-->
            <!--                            <li><a href="#">&lt;</a></li>-->
            <!--                            <li class="active"><span>1</span></li>-->
            <!--                            <li><a href="#">2</a></li>-->
            <!--                            <li><a href="#">3</a></li>-->
            <!--                            <li><a href="#">4</a></li>-->
            <!--                            <li><a href="#">5</a></li>-->
            <!--                            <li><a href="#">&gt;</a></li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </section>
<?php
include('includes/footer.php');
?>

<script type="application/javascript">

    $(document).ready(function () {



        var table = $('#news_table').DataTable({
            columnDefs: [
                {bSortable: false, targets: [0]}
            ] ,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aaSorting": []


        });

    });


</script>
