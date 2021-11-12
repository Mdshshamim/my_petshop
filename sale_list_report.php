<?php
ob_start();
session_start();

include('include/config.php');

if (!isset($_SESSION['user_type']))
{
    header("location:index.php");
    exit();
}
else if ($_SESSION['user_type'] != 'admin')
{
    header("location:index.php");
    exit();
}

$owners = $db->prepare("SELECT id, name FROM users WHERE user_type='owner'");
$owners->execute();

if (isset($_GET['owner_id']) && !empty($_GET['owner_id']))
{
    $products = $db->prepare("SELECT id, title FROM products WHERE owner_id='$_GET[owner_id]'");
    $products->execute();
}

include('include/header.php');

include('include/sidebar.php');
?>
<div class="main-panel">
    <!-- Navbar -->
    <?php include('include/navbar.php'); ?>
    <!-- End Navbar -->
    <!-- Content Start  -->
    <div class="content">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?php
                if (isset($_SESSION['success']))
                {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> <?= $_SESSION['success'] ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    unset($_SESSION['success']);
                }
                if (isset($_SESSION['error']))
                {
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> <?= $_SESSION['error'] ?>.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                    unset($_SESSION['error']);
                }
                ?>
                <div class="card card-user">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title">Owner Sale Report</h5>
                    </div>
                    <div class="card-body">
                        <form method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="from"></label>
                                        <select name="owner_id" class="form-control">
                                            <option value="">SELECT OWNER</option>
                                            <?php
                                            while ($owner = $owners->fetchObject())
                                            {
                                                ?>
                                                <option value="<?= $owner->id ?>" <?php if (isset($_GET['owner_id']) && $_GET['owner_id'] == $owner->id) echo 'selected' ?>><?= $owner->name ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <input type="submit" value="Search" class="btn btn-warning"
                                           style="margin-top: 2em !important;">
                                    <?php
                                    if (isset($products))
                                    {
                                        ?>
                                        <a href="./sale_list_report_down.php?owner_id=<?= $_GET['owner_id'] ?>"
                                           class="btn btn-primary" target="_blank" style="margin-top: 2em !important;">PDF</a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>

                        <?php if (isset($products)) { ?>
                            <div class="table-responsive">
                                <table class="table table_list" id="table_list">
                                    <thead class="text-primary">
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Product
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Price
                                    </th>

                                    </thead>

                                    <tbody>
                                    <?php

                                    $i = 0;
                                    while ($product = $products->fetchObject())
                                    {
                                        $cart = $db->prepare("SELECT SUM(quantity) as quantity, SUM(cart_price) as cart_price FROM cart WHERE product_id=? AND status=?");
                                        $cart->execute([$product->id, 3]);
                                        $cart = $cart->fetchObject();
                                        ?>
                                        <tr>
                                            <td>
                                                <?= ++$i; ?>
                                            </td>
                                            <td>
                                                <?= $product->title ?>
                                            </td>
                                            <td>
                                                <?= $cart->quantity ?? 0 ?>
                                            </td>
                                            <td>
                                                <?= $cart->cart_price ?? 0 ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('include/footer.php');
    ?>
</div>
</div>

<!--   Core JS Files   -->

<script src="assets/js/core/jquery.min.js"></script>
<script src="assets/js/core/popper.min.js"></script>
<script src="assets/js/core/bootstrap.min.js"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!-- Chart JS -->
<script src="assets/js/plugins/chartjs.min.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/demo/demo.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#side-menu .active').removeClass('active');
        $('#side-menu #n_sale_list_report').addClass('active');

        <?php if(isset($products)){?>
        $('#table_list').DataTable();
        <?php } ?>
    });
</script>

</body>

</html>