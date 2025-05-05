<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=true){
    header("location: ../logout.php");
    exit;
}
include '../partials/_dbconnect.php';
include '../api.php';

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Admin</a>
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
                        echo '<li><a class="dropdown-item" href="#!">'.$_SESSION['email'].'</a></li>'; 
                        ?>
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
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

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#advertiserLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Advertiser
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="advertiserLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="addAdvertiser.php">Add Advertiser</a>
                                    <a class="nav-link" href="activeAdvertisers.php">Active Advertisers</a>
                                    <a class="nav-link" href="inactiveAdvertisers.php">Inactive Advertisers</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#publisherLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Publisher
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="publisherLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="addPublisher.php">Add Publisher</a>
                                    <a class="nav-link" href="activePublishers.php">Active Publishers</a>
                                    <a class="nav-link" href="inactivePublishers.php">Inactive Publishers</a>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#camopaignLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Campaigns
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="camopaignLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="addCampaign.php">Add Campaign</a>
                                    <a class="nav-link" href="activeCampaigns.php">Active Campaigns</a>
                                    <a class="nav-link" href="inactiveCampaigns.php">Inactive Campaigns</a>
                                </nav>
                            </div>

                            <div class="sb-sidenav-menu-heading">Reports</div>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Advertiser Report
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Publisher Report
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Campaign Report
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Conversion Report
                            </a>
                            <a class="nav-link" href="tables.html">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Upcoming...
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Admin
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">

                                    <?php 
                                    
                                        $created_by = $_SESSION["email"];
                                        $sql = "SELECT * FROM `clicks` where DATE(dt) = CURDATE()"; 
                                        $result = mysqli_query($conn, $sql);
                                        $clicks = 0;
                                        while($row = mysqli_fetch_assoc($result)){
                                            $pubId = $row['pub_id'];

                                            $sqlMyPubs = "SELECT * FROM `publishers` WHERE `id` = '$pubId' AND `createdBy` LIKE '$created_by'"; 
                                            $resultMyPubs = mysqli_query($conn, $sqlMyPubs);
                                            $numPubs = mysqli_num_rows($resultMyPubs);

                                            $campId = $row['camp_id'];
                                            $sqlMyCamp = "SELECT * FROM `campaigns` WHERE `id` = '$campId' AND `createdBy` LIKE '$created_by'"; 
                                            $resultMyCamp = mysqli_query($conn, $sqlMyCamp);
                                            $numCamp = mysqli_num_rows($resultMyCamp);

                                            if($numPubs > 0 || $numCamp > 0){
                                                $clicks = $clicks + 1;
                                            }
                                        }

                                        echo '<div class="card-body my-3">'.$clicks.' Clicks</div>';
                                    
                                    ?>

                                    
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">

                                    <?php 
                                        
                                        $created_by = $_SESSION["email"];
                                        $sql = "SELECT * FROM `global_conversions` where DATE(dt) = CURDATE()"; 
                                        $result = mysqli_query($conn, $sql);
                                        $conversions = 0;
                                        $revenue = 0;
                                        $payout = 0;
                                        while($row = mysqli_fetch_assoc($result)){
                                            $pubId = $row['pub_id'];

                                            $sqlMyPubs = "SELECT * FROM `publishers` WHERE `id` = '$pubId' AND `createdBy` LIKE '$created_by'"; 
                                            $resultMyPubs = mysqli_query($conn, $sqlMyPubs);
                                            $numPubs = mysqli_num_rows($resultMyPubs);

                                            $campId = $row['camp_id'];
                                            $sqlMyCamp = "SELECT * FROM `campaigns` WHERE `id` = '$campId' AND `createdBy` LIKE '$created_by'"; 
                                            $resultMyCamp = mysqli_query($conn, $sqlMyCamp);
                                            $numCamp = mysqli_num_rows($resultMyCamp);

                                            if($numPubs > 0 || $numCamp > 0){
                                                $conversions = $conversions + 1;


                                                $sqlCamp = "SELECT * FROM `campaigns` WHERE `id` = '$campId'"; 
                                                $resultCamp = mysqli_query($conn, $sqlCamp);
                                                $rowCamp = mysqli_fetch_assoc($resultCamp);
                                                
                                                $revenue = $revenue + $rowCamp['revenue'];
                                                $payout = $payout + $rowCamp['standardPayout'];

                                            }
                                        }

                                        echo '<div class="card-body my-3">'.$conversions.' Conversions</div>';
                                    
                                    ?>
                                    


                                    
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <?php 
                                        echo '<div class="card-body my-3">$ '.number_format($revenue,2).' Revenue</div>';
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <?php 
                                        echo '<div class="card-body my-3">$ '.number_format($payout,2).' Payout</div>';
                                    ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <?php 
                                        $cr = 0;
                                        if($conversions > 0){
                                            $cr = ($conversions / $clicks) * 100;
                                        }
                                        echo '<div class="card-body my-3">'.number_format($cr,2).' % CR</div>';
                                    ?>
                                    
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-white mb-4">
                                    <?php 
                                        $profit = $revenue - $payout;
                                        echo '<div class="card-body my-3">$ '.number_format($profit,2).' Profit</div>';
                                    ?>
                                    
                                </div>
                            </div>
                        </div>

                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Advertiser Report
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Advertiser</th>
                                            <th>Clicks</th>
                                            <th>Conversions</th>
                                            <th>CR</th>
                                            <th>Revenue</th>
                                            <th>Payout</th>
                                            <th>Profit</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Advertiser</th>
                                            <th>Clicks</th>
                                            <th>Conversions</th>
                                            <th>CR</th>
                                            <th>Revenue</th>
                                            <th>Payout</th>
                                            <th>Profit</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $created_by = $_SESSION["email"];
                                            $sql = "SELECT * FROM `advertisers` where createdBy='$created_by'"; 
                                            $result = mysqli_query($conn, $sql);
                                            while($row = mysqli_fetch_assoc($result)){
                                                $advtId = $row['id'];
                                                $sqlCamp = "SELECT * FROM `campaigns` where advertiserId='$advtId'";
                                                $resultCamp = mysqli_query($conn, $sqlCamp);
                                                
                                                $advtClicks = 0;
                                                $advtConversions = 0;
                                                $advtCr = 0;
                                                $advtRevenue = 0;
                                                $advtPayout = 0;
                                                $advtProfit = 0;
                                                while($rowCamp = mysqli_fetch_assoc($resultCamp)){
                                                    $campId = $rowCamp['id'];

                                                    $sqlClicks = "SELECT * FROM `clicks` where camp_id='$campId' AND DATE(dt) = CURDATE()";
                                                    $resultClicks = mysqli_query($conn, $sqlClicks);
                                                    $numClicks = mysqli_num_rows($resultClicks);
                                                    
                                                    $advtClicks = $advtClicks + $numClicks;

                                                    $sqlConversion = "SELECT * FROM `global_conversions` where camp_id='$campId' AND DATE(dt) = CURDATE()";
                                                    $resultConversion = mysqli_query($conn, $sqlConversion);
                                                    $numConversion = mysqli_num_rows($resultConversion);
                                                    
                                                    $advtConversions = $advtConversions + $numConversion;

                                                    $advtRevenue = $advtRevenue + ($numConversion * $rowCamp['revenue']);

                                                    $advtPayout = $advtPayout + ($numConversion * $rowCamp['standardPayout']);
                                                }

                                                if($advtConversions > 0){
                                                    $advtCr = ($advtConversions / $advtClicks) * 100;
                                                    $advtProfit = $advtRevenue - $advtPayout;
                                                }
                                                
                                                if($advtClicks > 0){
                                                    echo "<tr>
                                                        <td>".date("d/m/Y")."</td>
                                                        <td>".$row['name']."</td>
                                                        <td>".$advtClicks."</td>
                                                        <td>".$advtConversions."</td>
                                                        <td>".number_format($advtCr,2)."%</td>
                                                        <td>$ ".number_format($advtRevenue,2)."</td>
                                                        <td>$ ".number_format($advtPayout,2)."</td>
                                                        <td>$ ".number_format($advtProfit,2)."</td>
                                                        <td><a href='advertiserOfferReport.php?advtId=".$advtId."'>All Offers</a> <br> <a href='advertiserAffiliateReport.php?advtId=".$advtId."'>Affiliates</a></td>
                                                    </tr>";
                                                }

                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
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
