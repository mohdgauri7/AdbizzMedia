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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">

                                    <?php 
                                    $myPubId = $_SESSION["pubId"]; 
                                    $sqlClicks = "Select * from clicks where pub_id='$myPubId' AND DATE(dt) = CURDATE()";
                                    $resultClicks = mysqli_query($conn, $sqlClicks);
                                    $clicks = mysqli_num_rows($resultClicks);
                                    
                                    
                                    echo '<div class="card-body my-3">'.$clicks.' Clicks</div>';
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <?php 
                                    $sqlConv = "Select * from publisher_global_conversions where pub_id='$myPubId' AND DATE(dt) = CURDATE()";
                                    $resultConv = mysqli_query($conn, $sqlConv);
                                    $conversions = mysqli_num_rows($resultConv);
                                    
                                    echo '<div class="card-body my-3">'.$conversions.' Conversions</div>';
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <?php
                                    if($clicks == 0){
                                        $convRate = 0;
                                    } else{
                                        $convRate = ($conversions / $clicks) * 100;
                                    }
                                    
                                    echo '<div class="card-body my-3">'.number_format($convRate, 2).'% CR</div>';
                                    
                                    ?>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">

                                    <?php 
                                    
                                    $sqlPub = "Select * from publishers where id='$myPubId'";
                                    $resultPub = mysqli_query($conn, $sqlPub);
                                    $rowPub = mysqli_fetch_assoc($resultPub);
                                    $cutBack = 1-$rowPub['cut_back'];

                                    $rev = 0;
                                    while($row = mysqli_fetch_assoc($resultConv)){
                                        $campId = $row['camp_id'];

                                        $sqlCamp = "Select * from campaigns where id='$campId'";
                                        $resultCamp = mysqli_query($conn, $sqlCamp);
                                        $rowCamp = mysqli_fetch_assoc($resultCamp);
                                        
                                        $po = $rowCamp['standardPayout'];
                                        $rev = $rev + $po;    
                                        
                                    }
                                    echo '<div class="card-body my-3">$ '.number_format($rev, 2).' Revenue</div>';
                                    
                                    ?>
                                </div>
                            </div>
                        </div>

                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Today's Report
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Offer ID</th>
                                            <th>Name</th>
                                            <th>Clicks</th>
                                            <th>Conversion</th>
                                            <th>CR</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Offer ID</th>
                                            <th>Name</th>
                                            <th>Clicks</th>
                                            <th>Conversion</th>
                                            <th>CR</th>
                                            <th>Revenue</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        <?php 
                                            $pubId = $_SESSION["pubId"];
                                            $sql = "SELECT * FROM `approved` where publisherId='$pubId'"; 
                                            $result = mysqli_query($conn, $sql);
                                            
                                            while($row = mysqli_fetch_assoc($result)){
                                                $campId = $row['campaignId'];
                                                $sql2 = "SELECT * FROM `campaigns` where id='$campId'"; 
                                                $result2 = mysqli_query($conn, $sql2);
                                                $row2 = mysqli_fetch_assoc($result2);

                                                $sqlClicks = "SELECT * FROM `clicks` where pub_id='$pubId' AND camp_id='$campId' AND DATE(dt) = CURDATE()";
                                                $resultClicks = mysqli_query($conn, $sqlClicks);
                                                $clicks = mysqli_num_rows($resultClicks);

                                                $sqlConversion = "SELECT * FROM `publisher_global_conversions` where pub_id='$pubId' AND camp_id='$campId' AND DATE(dt) = CURDATE()";
                                                $resultConversion = mysqli_query($conn, $sqlConversion);
                                                $conversions = mysqli_num_rows($resultConversion);

                                                $cr = 0;
                                                $revenue = 0;
                                                if($conversions > 0){
                                                    $cr = ($conversions / $clicks) * 100;
                                                    $revenue = $conversions * $row2['standardPayout'];
                                                }
                                                if($clicks > 0){
                                                    echo "<tr>
                                                        <td>".$row2['id']."</td>
                                                        <td>".$row2['name']."</td>
                                                        <td>".$clicks."</td>
                                                        <td>".$conversions."</td>
                                                        <td>".$cr."%</td>
                                                        <td>".$revenue."%</td>
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
