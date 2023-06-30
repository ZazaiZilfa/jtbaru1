<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">

            <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown" aria-expanded="false">Nowak Helme</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>

            <p class="text-muted left-user-info">Admin Head</p>

            <ul class="list-inline">
                <li class="list-inline-item">
                    <a href="#" class="text-muted left-user-info">
                        <i class="mdi mdi-cog"></i>
                    </a>
                </li>

                <li class="list-inline-item">
                    <a href="#">
                        <i class="mdi mdi-power"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <?php
            if ($_SESSION['role_id'] = "0" || $_SESSION['role_id'] = "1") : ?>
                <ul id="side-menu">

                    <?php
                    $kodeusermenu = query("SELECT * FROM user_menu ORDER BY urut ASC ");
                    foreach ($kodeusermenu as $row) : ?>


                        <li>
                            <a href="<?= "../" . "#" . $row["url"] ?>" data-bs-toggle="collapse">
                                <!-- <a href="#dashboard" data-bs-toggle="collapse"> -->
                                <i class="<?= $row["icon"] ?>"></i>
                                <span> <?= ucwords($row["menu"]) ?></span>
                                <span class=" menu-arrow"></span>

                            </a>
                            <div class="collapse" id="<?= $row["url"] ?>">
                                <ul class="nav-second-level">
                                    <?php
                                    $menu_id = $row["id"];
                                    if (isset($_SESSION['role_id'])) {
                                        $kodeusersubmenu = query("SELECT * FROM user_sub_menu WHERE menu_id ='$menu_id' AND is_active=1 ORDER BY menu_id ASC ");
                                    } else {
                                        $kodeusersubmenu = query("SELECT * FROM user_sub_menu WHERE menu_id ='$menu_id' AND is_active=1 ORDER BY menu_id ASC ");
                                    }



                                    ?>

                                    <?php foreach ($kodeusersubmenu as $row1) :


                                    ?>

                                        <li>
                                            <a href="<?= "../" . $row["url"] ?>/<?= $row1["url"] ?>"><?= $row1['title'] ?></a>
                                        </li>

                                    <?php endforeach; ?>


                                </ul>


                            </div>
                        </li>
                    <?php endforeach; ?>




                </ul>
            <?php endif; ?>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->