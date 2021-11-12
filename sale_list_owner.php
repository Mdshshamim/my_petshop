<?php
ob_start();
session_start();

include('include/config.php');

if (!isset($_SESSION['user_type']))
{
    header("location:index.php");
    exit();
}
else if ($_SESSION['user_type'] != 'owner')
{
    header("location:index.php");
    exit();
}

$select_stmt = $db->prepare("SELECT products.title, cart.quantity, cart.cart_price, orders.address FROM users INNER JOIN products ON users.id=products.owner_id INNER JOIN cart ON products.id=cart.product_id INNER JOIN orders ON cart.order_id=orders.id WHERE products.owner_id='$_SESSION[user_id]' AND cart.status='3'");
$select_stmt->execute();

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
                        <h5 class="card-title">Sale List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table_list">
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
                                    Delivery Location
                                </th>
                                <th>
                                    Price
                                </th>
                                </thead>

                                <tbody>
                                <?php

                                $i = 0;
                                while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC))
                                {
                                    $i++;

                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['title']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['quantity']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['address']; ?>
                                        </td>
                                        <td>
                                            <?= $row['cart_price'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
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
        $('#side-menu #n_owner_sale_lists').addClass('active');
        $('#table_list').DataTable();
    });
</script>

</body>

</html>