<?php

session_start();

if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=true){
    header("location: ../logout.php");
    exit;
}
include '../partials/_dbconnect.php';


$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["actionType"] == "unblock"){
        $approveAdvt = $_POST["unblockAdvtId"];
        $createdBy = $_SESSION['email'];
        $pubId = $_SESSION["pubId"];

        $sql = "SELECT * FROM `campaigns` where advertiserId='$approveAdvt' AND createdBy='$createdBy'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $campId = $row['id'];
            $sql2 = "INSERT INTO `approved` ( `advertiserId`, `publisherId`, `campaignId`, `createdBy`, `status`, `dt`) VALUES ('$approveAdvt', '$pubId', '$campId', '$createdBy', 'active', current_timestamp())";
            mysqli_query($conn, $sql2);
        }
    }
    else if($_POST["actionType"] == "block"){
        $blockAdvtId = $_POST["blockAdvtId"];
        $createdBy = $_SESSION['email'];
        $pubId = $_SESSION["pubId"];

        $sql = "SELECT * FROM `approved` where advertiserId='$blockAdvtId' AND publisherId='$pubId' AND createdBy='$createdBy'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $approvedCampId = $row['id'];
            $sql2 = "DELETE FROM `approved` WHERE `id` = '$approvedCampId'";
            mysqli_query($conn, $sql2);
        }
    }else if($_POST["actionType"] == "saveCutBack"){
        $pubId = $_SESSION['pubId'];
        $val = $_POST['cutback'];
        $cutback = $val / 100;
        $sql = "UPDATE `publishers` SET `cut_back` = '$cutback' WHERE `publishers`.`id` = '$pubId'";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $showAlert = true;
        }else{
            $showError = "Something went wrong!";
        }


    }
}
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["publisherId"])){
    $_SESSION['pubId'] = $_GET['publisherId'];
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
                <strong>Success!</strong> Macros updated successfully, Thanks!!!
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
                        <h1 class="mt-4">Publisher</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="publishers.php">Publishers</a></li>
                            <li class="breadcrumb-item active">Publisher</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below.
                            </div>
                        </div>

                        <div class="container bg-light ">

                            <form action="viewPublisher.php" method="POST">
                                <?php 
                                    $pubId = $_SESSION['pubId'];
                                    $sql = "SELECT * FROM `publishers` where id='$pubId'"; 
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
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="'.$row["email"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticSkypeId" class="col-sm-2 col-form-label">Skype ID:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticSkypeId" value="'.$row["skypeId"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticNumber" class="col-sm-2 col-form-label">Number</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticNumber" value="'.$row["number"].'">
                                    </div>
                                </div>';
                                
                                echo '<div class="form-group row mb-3">
                                    <label for="staticCountry" class="col-sm-2 col-form-label">Country</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticCountry" value="'.$row["country"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticWebsite" class="col-sm-2 col-form-label">Website:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticWebsite" value="'.$row["website"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticPostback" class="col-sm-2 col-form-label">Postback:</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticPostback" value="'.$row["postback"].'">
                                    </div>
                                </div>';

                                echo '<div class="form-group row mb-3">
                                    <label for="staticEventPostback" class="col-sm-2 col-form-label">Event Postback</label>
                                    <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="staticEventPostback" value="'.$row["eventPostback"].'">
                                    </div>
                                </div>';

                                $cutback = ($row["cut_back"] * 100);

                                echo '<div class="form-group row my-3">
                                    <label for="inputCutBack" class="col-sm-2 col-form-label">Cut Back:</label>
                                    <div class="col-sm-10">
                                    <input type="number" name="cutback" class="form-control" id="inputCutBack" placeholder="cutback in %" value = "'.$cutback.'">
                                    </div>
                                </div>';
                                ?>

                                <input type="hidden" name="actionType" value="saveCutBack">
                                <div class="form-group row my-3">
                                    <label for="inputMacros" class="col-sm-10 col-form-label"></label>
                                    <div class="col-sm-2">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">Save</button>
                                    </div>
                                </div>

                            </form>

                            <br>


                            <form action="viewPublisher.php" method="POST">
                                <input type="hidden" name="actionType" value="unblock">
                                <div class="form-group row my-3 mt-5">
                                    <label for="inputMacros" class="col-sm-2 col-form-label">Blocked</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-md my-3" name="unblockAdvtId">
                                            <option value=""> -- Select To Unblock -- </option>
                                            <?php 
                                                $createdBy = $_SESSION['email'];
                                                $sql = "SELECT * FROM `advertisers` where createdBy='$createdBy'";
                                                $result = mysqli_query($conn, $sql);
                                                $myAllAdvertisers = [];
                                                while($row = mysqli_fetch_assoc($result)){
                                                    $myAllAdvertisers[] = $row;
                                                
                                                } 

                                                $pubId = $_SESSION['pubId'];
                                                $sqlForPub = "SELECT * FROM `approved` where publisherId='$pubId'";
                                                $resultApprovedAdvt = mysqli_query($conn, $sqlForPub);
                                                $allApprovedAdvtList = [];
                                                while($row2 = mysqli_fetch_assoc($resultApprovedAdvt)){
                                                    $allApprovedAdvtList[] = $row2; 
                                                } 

                                                $finalApprovedAdvts = [];
                                                $finalNotApprovedAdvts = [];
                                                

                                                foreach($myAllAdvertisers as $advt){
                                                    $isApproved = false;
                                                    
                                                    foreach($allApprovedAdvtList as $apbdAdvt){
                                                        if($advt['id'] == $apbdAdvt['advertiserId']){
                                                            $isApproved = true;
                                                            break;
                                                        }
                                                    }
                                                    if($isApproved == true){
                                                        $finalApprovedAdvts[] = $advt; 
                                                    }else{
                                                        $finalNotApprovedAdvts[] = $advt; 
                                                    }
                                                }

                                                foreach($finalNotApprovedAdvts as $advt){
                                                    echo "<option value='".$advt['id']."'>".$advt['name']."</option>";
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
                            <form action="viewPublisher.php" method="POST">
                                <input type="hidden" name="actionType" value="block">
                                <div class="form-group row my-3 mt-5">
                                    <label for="inputMacros" class="col-sm-2 col-form-label">Block</label>
                                    <div class="col-sm-10">
                                        <select class="form-control form-control-md my-3" name="blockAdvtId">
                                            <option value=""> -- Select To Block -- </option>
                                            <?php 
                                                foreach($finalApprovedAdvts as $advt){
                                                    echo "<option value=".$advt['id'].">".$advt['name']."</option>";
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




