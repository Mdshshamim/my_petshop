<?php
session_start();
include('../back/include/config.php');
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);

$brands = $_GET['brands'];
$types = $_GET['types'];
$minimum_range = $_GET['minimum_range'];
$maximum_range = $_GET['maximum_range'];

if (!empty($brands) && !empty($types))
{
    $products = $db->prepare("SELECT * FROM products INNER JOIN users ON products.owner_id=users.id WHERE brand_id IN (" . $brands . ") AND type_id IN (" . $types . ") AND offer_price >= '$minimum_range' AND offer_price <= '$maximum_range'");
    $products->execute();
} else if (!empty($brands))
{
    $products = $db->prepare("SELECT * FROM products INNER JOIN users ON products.owner_id=users.id WHERE brand_id IN (" . $brands . ") AND offer_price >= '$minimum_range' AND offer_price <= '$maximum_range'");
    $products->execute();
} else if (!empty($types))
{
    $products = $db->prepare("SELECT * FROM products INNER JOIN users ON products.owner_id=users.id WHERE type_id IN (" . $types . ") AND offer_price >= '$minimum_range' AND offer_price <= '$maximum_range'");
    $products->execute();
    // $products->execute([
    //     $types,
    // ]);
} else
{
    $products = $db->prepare("SELECT * FROM products INNER JOIN users ON products.owner_id=users.id WHERE offer_price >= '$minimum_range' AND offer_price <= '$maximum_range'");
    $products->execute();
}

if ($products->rowCount() > 0)
{
    while ($product = $products->fetchObject())
    {
        ?>
        <div class="col-md-4 item-grid1 simpleCart_shelfItem">
            <div class=" mid-pop">
                <div class="pro-img">
                    <img src="./uploads/<?= $product->img1 ?>" class="img-responsive" alt="">
                    <div class="zoom-icon ">
                        <a class="picture" href="images/pc.jpg" rel="title"
                           class="b-link-stripe b-animate-go  thickbox"><i class="glyphicon glyphicon-search icon "></i></a>
                        <a href="product.php?product_id=<?= $product->id ?>"><i
                                    class="glyphicon glyphicon-menu-right icon"></i></a>
                    </div>
                </div>
                <div class="mid-1">
                    <div class="women">
                        <div class="women-top">
                                <span>
                                    <?php
                                    $category = $db->prepare("SELECT name FROM categories WHERE id=?");
                                    $category->execute([
                                        $product->category_id,
                                    ]);
                                    $category = $category->fetchObject();
                                    echo $category->name;
                                    ?>
                                </span>
                            <h6><a href="product.php?product_id=<?= $product->id ?>"><?= $product->title ?></a></h6>
                        </div>
                        <div class="img item_add">
                            <a href="#"><img src="images/ca.png" alt=""></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="mid-2">
                        <?php
                        if ($product->offer_price)
                        {
                            ?>
                            <p>
                                <label>$<?= $product->price ?></label>
                                <em class="item_price">$
                                    <?php
                                    $off_price = ($product->offer_price * $product->price) / 100;
                                    echo($product->price - $off_price);
                                    ?>
                                </em>
                            </p>
                            <?php
                        } else
                        {
                            ?>
                            <p>
                                <em class="item_price">$<?= $product->price ?></em>
                            </p>
                            <?php
                        }
                        ?>
                        <div class="block">
                            <div class="starbox small ghosting"></div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div>
                        <p><?= $product->name ?></p>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }
}