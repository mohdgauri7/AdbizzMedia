<?php

session_start();

if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=true){
    header("location: ../logout.php");
    exit;
}
include '../partials/_dbconnect.php';


$showAlert = false;
$showError = false;
$isLinkGenerated = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["actionType"] == "unblock"){
        $approvePub = $_POST["unblockPubId"];
        $createdBy = $_SESSION['email'];
        $campId = $_SESSION["campId"];

        $sql = "SELECT * FROM `campaigns` where id='$campId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $advtId = $row['advertiserId'];
    
        $sql2 = "INSERT INTO `approved` ( `advertiserId`, `publisherId`, `campaignId`, `createdBy`, `status`, `dt`) VALUES ('$advtId', '$approvePub', '$campId', '$createdBy', 'active', current_timestamp())";
        $addCampaign = mysqli_query($conn, $sql2);
        if($addCampaign){
            $showAlert = true;
        }else{
            $showError = "Something went wrong";
        }
        
    }
    else if($_POST["actionType"] == "block"){
        $blockPub = $_POST["blockPubId"];
        $createdBy = $_SESSION['email'];
        $campId = $_SESSION["campId"];

        $sql = "SELECT * FROM `campaigns` where id='$campId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $advtId = $row['advertiserId'];

        $sql2 = "SELECT * FROM `approved` WHERE `advertiserId` LIKE '$advtId' AND `publisherId` LIKE '$blockPub' AND `campaignId` LIKE '$campId' AND `createdBy` LIKE '$createdBy'";
        // // $sql2 = "SELECT * FROM `approved` where advertiserId='$advtId' AND publisherId='$blockPub' AND campaignId='$campId' AND createdBy='$createdBy'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $approvedCampId = $row2['id'];
        $sql3 = "DELETE FROM `approved` WHERE `id` = '$approvedCampId'";
        $dlt = mysqli_query($conn, $sql3);
        if($dlt){
            $showAlert = true;
        }else{
            $showError = "Something went wrong";
        }
    }else if($_POST["actionType"] == "generateLink"){
        $generateLinkPubId = $_POST['pubId'];
        $isLinkGenerated = true;

    }
}
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["campaignId"])){
    $_SESSION['campId'] = $_GET['campaignId'];
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
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
                <?php
            if($showAlert){
            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Campaign Accessability Updated successfully, Thanks!!!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> ';
            }
            if($showError){
            echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> '. $showError.'
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> ';
            }
        ?>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Campaign</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="publishers.php">Campaigns</a></li>
                            <li class="breadcrumb-item active">View Campaign</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below.
                            </div>
                        </div>

                        <div class="container bg-light ">

                            <form>
                                <?php 
                                    $campId = $_SESSION['campId'];
                                    $sql = "SELECT * FROM `campaigns` where id='$campId'"; 
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);

                                    $status = $row['status'];
                                    if($status == "active"){
                                        $status = "Active";
                                    }else{
                                        $status = "Inactive";
                                    }
                                    
                                    echo '<div class="form-group row mb-3">
                                    <label for="staticName" class="col-sm-2 col-form-label">Name:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticName" value="'.$row["name"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticCategory" class="col-sm-2 col-form-label">Category:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticCategory" value="'.$row["category"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticDescription" class="col-sm-2 col-form-label">Description:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticDescription" value="'.$row["description"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticPreviewUrl" class="col-sm-2 col-form-label">Preview Url:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticPreviewUrl" value="'.$row["previewUrl"].'">
                                    </div>
                                </div>';
                                
                                echo '<div class="form-group row mb-3">
                                    <label for="staticLandingUrl" class="col-sm-2 col-form-label">Landing Url:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticLandingUrl" value="'.$row["landingUrl"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticOS" class="col-sm-2 col-form-label">OS:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticOS" value="'.$row["os"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticGeo" class="col-sm-2 col-form-label">Geo:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticGeo" value="'.$row["geo"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticRevenue" class="col-sm-2 col-form-label">Revenue:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticRevenue" value="'.$row["revenue"].'">
                                    </div>
                                </div>';


                                echo '<div class="form-group row mb-3">
                                    <label for="staticStandardPayout" class="col-sm-2 col-form-label">Standard Payout:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticStandardPayout" value="'.$row["standardPayout"].'">
                                    </div>
                                </div>';


                                echo '<div class="form-group row mb-3">
                                    <label for="staticCurrency" class="col-sm-2 col-form-label">Currency:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticCurrency" value="'.$row["currency"].'">
                                    </div>
                                </div>';



                                echo '<div class="form-group row mb-3">
                                    <label for="staticDailyCap" class="col-sm-2 col-form-label">Daily Cap:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticDailyCap" value="'.$row["dailyCap"].'">
                                    </div>
                                </div>';


                                echo '<div class="form-group row mb-3">
                                    <label for="staticRestrictions" class="col-sm-2 col-form-label">Restrictions:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticRestrictions" value="'.$row["restrictions"].'">
                                    </div>
                                </div>';


                                echo '<div class="form-group row mb-3">
                                    <label for="staticStatus" class="col-sm-2 col-form-label">Status:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticStatus" value="'.$row["status"].'">
                                    </div>
                                </div>';

                                ?>
                            </form>

                            <br>


                            <form action="viewCampaign.php" method="POST">
                                <input type="hidden" name="actionType" value="unblock">
                                <div class="form-group row my-3 mt-5">
                                    <label for="inputMacros" class="col-sm-2 col-form-label">Blocked</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-md my-3" name="unblockPubId">
                                            <option value=""> -- Select To Unblock -- </option>
                                            <?php 
                                                $createdBy = $_SESSION['email'];
                                                $sql = "SELECT * FROM `publishers` where createdBy='$createdBy'";
                                                $result = mysqli_query($conn, $sql);
                                                $myAllPublishers = [];
                                                while($row = mysqli_fetch_assoc($result)){
                                                    $myAllPublishers[] = $row;
                                                
                                                } 

                                                $campId = $_SESSION['campId'];
                                                $sqlForCamp = "SELECT * FROM `approved` where campaignId='$campId'";
                                                $resultApprovedPubs = mysqli_query($conn, $sqlForCamp);
                                                $allApprovedPubsList = [];
                                                while($row2 = mysqli_fetch_assoc($resultApprovedPubs)){
                                                    $allApprovedPubsList[] = $row2; 
                                                } 

                                                $finalApprovedPubs = [];
                                                $finalNotApprovedPubs = [];
                                                

                                                foreach($myAllPublishers as $pub){
                                                    $isApproved = false;
                                                    
                                                    foreach($allApprovedPubsList as $apbdPub){
                                                        if($pub['id'] == $apbdPub['publisherId']){
                                                            $isApproved = true;
                                                            break;
                                                        }
                                                    }
                                                    if($isApproved == true){
                                                        $finalApprovedPubs[] = $pub; 
                                                    }else{
                                                        $finalNotApprovedPubs[] = $pub; 
                                                    }
                                                }

                                                foreach($finalNotApprovedPubs as $pub){
                                                    echo "<option value='".$pub['id']."'>".$pub['name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-3">
                                    <label for="inputMacros" class="col-sm-10 col-form-label"></label>
                                    <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Unblock</button>
                                    </div>
                                </div>
                            </form>
                            <form action="viewCampaign.php" method="POST">
                                <input type="hidden" name="actionType" value="block">
                                <div class="form-group row my-3 mt-5">
                                    <label for="inputMacros" class="col-sm-2 col-form-label">Block</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-md my-3" name="blockPubId">
                                            <option value=""> -- Select To Block -- </option>
                                            <?php 
                                                foreach($finalApprovedPubs as $pub){
                                                    echo "<option value=".$pub['id'].">".$pub['name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-3">
                                    <label for="inputMacros" class="col-sm-10 col-form-label"></label>
                                    <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Block</button>
                                    </div>
                                </div>
                            </form>

                            <form action="viewCampaign.php" method="POST">
                                <input type="hidden" name="actionType" value="generateLink">
                                <div class="form-group row my-3 mt-5">
                                    <label for="inputGenerateLink" class="col-sm-2 col-form-label">Generate Link</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-md my-3" name="pubId">
                                            <option value=""> -- Select Publisher -- </option>
                                            <?php 
                                                foreach($finalApprovedPubs as $pub){
                                                    echo "<option value=".$pub['id'].">".$pub['name']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row my-3">
                                    <label for="inputMacros" class="col-sm-10 col-form-label"></label>
                                    <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Generate</button>
                                    </div>
                                </div>
                            </form>
                            <?php 
                            if($isLinkGenerated){

                                $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                                $clickId1 = substr(str_shuffle($str_result), 0, 25);
                                $clickId2 = substr(str_shuffle($str_result), 0, 25);
                                $clickId3 = substr(str_shuffle($str_result), 0, 25);


                                $campId = $_SESSION['campId'];

                                $publisherTestLink = "http://adfliks.com/publisher/tracking.php?aff_id=".$generateLinkPubId."&offer_id=".$campId."&aff_sub=".$clickId1."&aff_sub2=testoffer";
                                $publisherTrackingLink = "http://adfliks.com/publisher/tracking.php?aff_id=".$generateLinkPubId."&offer_id=".$campId."&aff_sub=".$clickId3."&aff_sub2={affiliate_id}&gaid={google_id}&ifaid={ifa_id}&device_id={device_id}";
                                $advertiserTestLink = "http://adfliks.com/publisher/tracking.php?aff_id=".$generateLinkPubId."&offer_id=".$campId."&aff_sub=".$clickId2."&aff_sub2={affiliate_id}&gaid={google_id}&ifaid={ifa_id}&device_id={device_id}";

                                echo '
                                <form>
                                    <div class="form-group row">
                                        <label for="staticAdvtTestLink" class="col-sm-2 col-form-label">Advertiser Test Link</label>
                                        <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" value="'.$advertiserTestLink.'">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="staticPubTestLink" class="col-sm-2 col-form-label">Publisher Test Link</label>
                                        <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" value="'.$publisherTestLink.'">
                                        </div>
                                    </div>
    
                                    <div class="form-group row">
                                        <label for="staticPubTrackingLink" class="col-sm-2 col-form-label">Publisher Tracking Link</label>
                                        <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" value="'.$publisherTrackingLink.'">
                                        </div>
                                    </div>
                                </form>';
                            }
                            ?>

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
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>




