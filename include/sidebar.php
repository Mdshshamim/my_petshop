<div class="sidebar" data-color="white" data-active-color="danger">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
    <div class="logo">
        <a href="#" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="assets/img/pet-icon.png">
            </div>
        </a>
        <a href="#" class="simple-text logo-normal">
            Pet Shop
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav" id="side-menu">
            <li id="deshboard">
                <a href="./dashboard.php">
                    <i class="nc-icon nc-bank"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li id="profile">
                <a href="./profile.php">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <p>Profile</p>
                </a>
            </li>

            <?php
            if ($_SESSION['user_type'] == "admin")
            {
                ?>
                <li id="n_promote_list">
                    <a href="./promote_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Promote Request</p>
                    </a>
                </li>
                <li id="n_promote_type_list">
                    <a href="./promote_type_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Promote Types</p>
                    </a>
                </li>
                <li id="n_accounts">
                    <a href="./account_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>All User</p>
                    </a>
                </li>
                <li id="n_payments">
                    <a href="./payments.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Payments</p>
                    </a>
                </li>
                <li id="n_owners">
                    <a href="./owner_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Pet Owners</p>
                    </a>
                </li>
                <li id="n_users">
                    <a href="./user_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li id="n_sub_admins">
                    <a href="./sub_admin_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Sub Admin</p>
                    </a>
                </li>
                <li id="n_subscribtions">
                    <a href="./subscribtion_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Subscriptions</p>
                    </a>
                </li>
                <li id="n_contacts">
                    <a href="./contact_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Contacts List</p>
                    </a>
                </li>
                <li id="n_categories">
                    <a href="./categorie_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li id="n_s_categories">
                    <a href="./s_categorie_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Sub Categories</p>
                    </a>
                </li>
                <li id="n_types">
                    <a href="./type_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Pet Types</p>
                    </a>
                </li>
                <li id="n_brands">
                    <a href="./brand_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Pet Brands</p>
                    </a>
                </li>
                <li>
                    <a href="./product_category_report.php" target="_blank">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Category Report</p>
                    </a>
                </li>
                <li>
                    <a href="./product_sub_category_report.php" target="_blank">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Sub Category Report</p>
                    </a>
                </li>
                <li id="n_order_reports">
                    <a href="./order_report.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Order Report</p>
                    </a>
                </li>
                <li id="n_order_charts">
                    <a href="./order_chart.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Order Chart</p>
                    </a>
                </li>
                <li id="n_sale_list_admin">
                    <a href="./sale_list_admin.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Sale List</p>
                    </a>
                </li>
                <li id="n_sale_list_report">
                    <a href="./sale_list_report.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Sale List Report</p>
                    </a>
                </li>
                <?php
            }

            if ($_SESSION['user_type'] == "admin" || $_SESSION['user_type'] == "owner")
            {
                ?>
                <li id="n_products">
                    <a href="./product_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Products</p>
                    </a>
                </li>
                <?php
            }

            if ($_SESSION['user_type'] == "owner")
            {
                ?>
                <li id="n_order_chart_owners">
                    <a href="./order_chart_owner.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Order Chart</p>
                    </a>
                </li>
                <li id="n_owner_sale_lists">
                    <a href="./sale_list_owner.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Sale List</p>
                    </a>
                </li>
                <?php
            }

            if ($_SESSION['user_type'] == "sub_admin")
            {
                ?>
                <li id="n_owners">
                    <a href="./owner_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Pet Owners</p>
                    </a>
                </li>
                <li id="n_users">
                    <a href="./user_list.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Users</p>
                    </a>
                </li>
                <?php
            }

            if ($_SESSION['user_type'] == "user")
            {
                ?>
                <li id="n_notification">
                    <a href="./notifications.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Notifications
                            <?php
                            $stmt = $db->prepare("SELECT id FROM notifications WHERE user_id='$_SESSION[user_id]' AND status=2");
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            if ($count > 0)
                            {
                                ?>
                                <span class="badge badge-pill badge-warning"><?= $count ?></span>
                                <?php
                            }
                            ?>
                        </p>
                    </a>
                </li>
                <li id="n_user_orders">
                    <a href="./user_orders.php">
                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <?php
            }
            ?>


        </ul>
    </div>
</div>