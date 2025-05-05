<?php
session_start();

if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=true){
    header("location: logout.php");
    exit;
}
include '../partials/_dbconnect.php';

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Publisher</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Publisher</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <?php 
                            echo '<li><a class="dropdown-item" href="#!">'.$_SESSION["email"].'</a></li>';
                        ?>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#camopaignLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Offer
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="camopaignLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="activeCampaigns.php">Active Offers</a>
                                    <a class="nav-link" href="inactiveCampaigns.php">Inactive Offers</a>
                                </nav>
                            </div>
                            <a class="nav-link" href="topCampaigns.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Top Offers
                            </a>

                            <div class="sb-sidenav-menu-heading">Reports</div>
                            <a class="nav-link" href="conversionReport.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Conversion Report
                            </a>
                            <a class="nav-link" href="setting.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Setting
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Publisher
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Setting</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="row my-4 mx-4">
                                <div class="col">
                                    <h1>Account Manager Details</h1>
                                </div>
                            </div>
                            <div class="row my-1 mx-4">
                                <div class="col">
                                    Manager Name:- Super Admin
                                </div>
                            </div>
                            <div class="row my-1 mx-4">
                                <div class="col">
                                    Manager Email:- Admin@adfliks.com
                                </div>
                            </div>
                            <div class="row my-1 mx-4">
                                <div class="col">
                                    Manager Skype ID:- live:adas.asdasdad
                                </div>
                            </div>
                            <div class="row my-1 mx-4">
                                <div class="col">
                                    Postback:- https://www.example.com/parameter={clickId}
                                </div>
                            </div>
                            <form>
                                <div class="row my-4 mx-4">
                                    <div class="col">
                                        <input type="text" class="form-control" name="updatePostbck" placeholder="update postback">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                            <div class="row mb-3 mx-4">
                                <div class="col">
                                    Note:- Please add {aff_sub} to clickid and {aff_sub2} to affiliateid
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="row my-4 mx-4">
                                <div class="col">
                                    <h1>API Details</h1>
                                </div>
                            </div>
                            <div class="row my-1 mx-4">
                                <div class="col">
                                    Aff ID:- 000
                                </div>
                            </div>
                            <div class="row my-1 mx-4">
                                <div class="col">
                                    API Key:- hfajshfldsjfds
                                </div>
                            </div>
                            <div class="row mb-3 mx-4">
                                <div class="col">
                                    API Url:- https://api.adfliks.com/api.php?aff_id=000
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="row my-4 mx-4">
                                <div class="col">
                                    <h1>Change Password</h1>
                                </div>
                            </div>
                            <form class="mx-4 mb-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">New Password</label>
                                    <input type="text" class="form-control" name="newPassword" placeholder="New Password">
                                    <small id="emailHelp" class="form-text text-muted">choose your password wisely.</small>
                                </div>
                                <div class="form-group my-4">
                                    <label for="exampleInputPassword1">Confirm Password</label>
                                    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password">
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; AdFliks 2024</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
