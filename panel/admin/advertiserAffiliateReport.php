<?php
session_start();

if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=true){
    header("location: ../logout.php");
    exit;
}
include '../partials/_dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["advtId"])){
    $advtId = $_GET['advtId'];
}else{
    exit;
}

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
                        <h1 class="mt-4">Affiliate Report</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Advertiser Affiliate Report</li>
                        </ol>
                    
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Advertiser Affiliate Report
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Advertiser</th>
                                            <th>Affiliate</th>
                                            <th>Clicks</th>
                                            <th>Conversions</th>
                                            <th>CR</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Advertiser</th>
                                            <th>Affiliate</th>
                                            <th>Clicks</th>
                                            <th>Conversions</th>
                                            <th>CR</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                            $created_by = $_SESSION["email"];
                                            $sql = "SELECT * FROM `approved` where advertiserId='$advtId' AND createdBy='$created_by'"; 
                                            $result = mysqli_query($conn, $sql);
                                            $approvedPubs = [];
                                            $size = 0;
                                            while($row = mysqli_fetch_assoc($result)){
                                                $size = $size + 1;
                                                $approvedPubs[] = $row['publisherId'];
                                            }
                                            
                                            $sqlAllPubs = "SELECT * FROM `publishers` where createdBy='$created_by'"; 
                                            $resultAllPubs = mysqli_query($conn, $sqlAllPubs);
                                            
                                            while($row = mysqli_fetch_assoc($resultAllPubs)){
                                                $isThisPubApvd = false;
                                                for($ind = 0; $ind < $size; $ind++){
                                                    if($row['id'] == $approvedPubs[$ind]){
                                                        $isThisPubApvd = true;
                                                        break;
                                                    }
                                                }
                                                
                                                if($isThisPubApvd == true){
                                                    $pubId = $row['id'];
                                                
                                                    $pubClicks = 0;
                                                    $pubConversions = 0;
                                                    $pubCr = 0;
    
                                                    $sqlClicks = "SELECT * FROM `clicks` where pub_id='$pubId' AND DATE(dt) = CURDATE()";
                                                    $resultClicks = mysqli_query($conn, $sqlClicks);
                                                    $numClicks = mysqli_num_rows($resultClicks);
                                                    
                                                    $pubClicks = $pubClicks + $numClicks;
    
                                                    $sqlConversion = "SELECT * FROM `global_conversions` where pub_id='$pubId' AND DATE(dt) = CURDATE()";
                                                    $resultConversion = mysqli_query($conn, $sqlConversion);
                                                    $numConversion = mysqli_num_rows($resultConversion);
                                                    
                                                    $pubConversions = $pubConversions + $numConversion;
    
                                                    if($pubConversions > 0){
                                                        $pubCr = ($pubConversions / $pubClicks) * 100;
                                                    }
    
                                                    $sqlAdvt = "SELECT * FROM `advertisers` where id='$advtId'";
                                                    $resultAdvt = mysqli_query($conn, $sqlAdvt);
                                                    $rowAdvt = mysqli_fetch_assoc($resultAdvt);
    
                                                    $sqlPub = "SELECT * FROM `publishers` where id='$pubId'";
                                                    $resultPub = mysqli_query($conn, $sqlPub);
                                                    $rowPub = mysqli_fetch_assoc($resultPub);
    
                                                    
                                                    if($pubClicks > 0){
                                                        echo "<tr>
                                                            <td>".date("d/m/Y")."</td>
                                                            <td>".$rowAdvt['name']."</td>
                                                            <td>".$rowPub['name']."</td>
                                                            <td>".$pubClicks."</td>
                                                            <td>".$pubConversions."</td>
                                                            <td>".number_format($pubCr,2)."%</td>
                                                        </tr>";
                                                    }

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
