<!-- partial:partials/_sidebar.php -->
<aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
    <div class="mdc-drawer__header">
        <a href="index.php" class="brand-logo text-light font-weight-bolder">
            <!--            <img height="100" width="150" src="../assets/images/logo.svg" alt="logo">-->
            ADMARC ADMIN
        </a>
    </div>
    <div class="mdc-drawer__content">
        <div class="user-info">
            <p class="name"><?= $logged_user['fname'] ?></p>
            <p class="email"><?= $logged_user['email'] ?></p>
        </div>
        <div class="mdc-list-group">
            <nav class="mdc-list mdc-drawer-menu">
                <div class="mdc-list-item mdc-drawer-item">
                    <a class="mdc-drawer-link" href="index.php">
                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                           aria-hidden="true">home</i>
                        Dashboard
                    </a>
                </div>
                <?php
                if ($logged_user['user_role'] == 'admin') {
                    ?>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="users.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">track_changes</i>
                            Users
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="branches.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">dashboard</i>
                            Branches
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="admarc_items.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">grid_on</i>
                            ADMARC products
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="admarc_sales.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">pages</i>
                            ADMARC Sales
                        </a>
                    </div>

                    <!--                agent or supplier-->
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="products.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">grid_on</i>
                            Products
                        </a>
                    </div>


                    <?php
                } elseif ($logged_user['user_role'] == 'stock_manager') {
                    ?>


                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="admarc_items.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">grid_on</i>
                            ADMARC products
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="admarc_sales.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">pages</i>
                            ADMARC Sales
                        </a>
                    </div>

                    <?php
                } elseif ($logged_user['user_role'] == 'agent' || $logged_user['user_role'] == 'supplier') {


                    ?>


                    <!--                agent or supplier-->
                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="products.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">grid_on</i>
                            Products
                        </a>
                    </div>

                    <div class="mdc-list-item mdc-drawer-item">
                        <a class="mdc-drawer-link" href="my_sales.php">
                            <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                               aria-hidden="true">pages</i>
                            My Sales
                        </a>
                    </div>

                    <?php
                }
                ?>

                <!--
                                <div class="mdc-list-item mdc-drawer-item">
                                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                                       data-target="ui-sub-menu">
                                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                           aria-hidden="true">dashboard</i>
                                        UI Features
                                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                                    </a>
                                    <div class="mdc-expansion-panel" id="ui-sub-menu">
                                        <nav class="mdc-list mdc-drawer-submenu">
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/ui-features/buttons.php">
                                                    Buttons
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/ui-features/typography.php">
                                                    Typography
                                                </a>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <div class="mdc-list-item mdc-drawer-item">
                                    <a class="mdc-drawer-link" href="pages/tables/basic-tables.php">
                                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                           aria-hidden="true">grid_on</i>
                                        Tables
                                    </a>
                                </div>
                                <div class="mdc-list-item mdc-drawer-item">
                                    <a class="mdc-drawer-link" href="pages/charts/chartjs.php">
                                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                           aria-hidden="true">pie_chart_outlined</i>
                                        Charts
                                    </a>
                                </div>
                                <div class="mdc-list-item mdc-drawer-item">
                                    <a class="mdc-expansion-panel-link" href="#" data-toggle="expansionPanel"
                                       data-target="sample-page-submenu">
                                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                           aria-hidden="true">pages</i>
                                        Sample Pages
                                        <i class="mdc-drawer-arrow material-icons">chevron_right</i>
                                    </a>
                                    <div class="mdc-expansion-panel" id="sample-page-submenu">
                                        <nav class="mdc-list mdc-drawer-submenu">
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/blank-page.php">
                                                    Blank Page
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/403.php">
                                                    403
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/404.php">
                                                    404
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/500.php">
                                                    500
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/505.php">
                                                    505
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/login.php">
                                                    Login
                                                </a>
                                            </div>
                                            <div class="mdc-list-item mdc-drawer-item">
                                                <a class="mdc-drawer-link" href="pages/samples/register.php">
                                                    Register
                                                </a>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                                <div class="mdc-list-item mdc-drawer-item">
                                    <a class="mdc-drawer-link"
                                       href="https://www.bootstrapdash.com/demo/material-admin-free/jquery/documentation/documentation.php"
                                       target="_blank">
                                        <i class="material-icons mdc-list-item__start-detail mdc-drawer-item-icon"
                                           aria-hidden="true">description</i>
                                        Documentation
                                    </a>
                                </div>


                                -->
            </nav>
        </div>
        <div class="profile-actions">
            <a href="#" onclick="showUserProfileModal()" >Edit Profile</a>
            <span class="divider"></span>
            <a href="logout.php">Logout</a>
        </div>

    </div>
</aside>
<!-- partial -->

