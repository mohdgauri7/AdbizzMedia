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
    $advertiserId = $_POST["advertiserId"];
    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];
    $previewUrl = $_POST["previewUrl"];
    $landingUrl = $_POST["landingUrl"];
    $os = $_POST["os"];
    $geo = $_POST["geo"];
    $revenue = $_POST["revenue"];
    $standardPayout = $_POST["standardPayout"];
    $premiumPayout = $_POST["premiumPayout"];
    $sensitivePayout = $_POST["sensitivePayout"];
    $currency = $_POST["currency"];
    $storeId = $_POST["storeId"];
    $dailyCap = $_POST["dailyCap"];
    $monthlyCap = $_POST["monthlyCap"];
    $creatives = $_POST["creatives"];
    $restrictions = $_POST["restrictions"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $type = $_POST["type"];
    $crManagement = $_POST["crManagement"];
    $redirections = $_POST["redirections"];
    $postback = $_POST["postback"];
    $iconUrl = $_POST["iconUrl"];
    $cityNames = $_POST["cityNames"];
    $cityTargeting = $_POST["cityTargeting"];
    $impLink = $_POST["impLink"];

    $creatingBy = $_SESSION['email'];

    $sql = "Select * from campaigns where name='$name'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num > 0){
        $showError = "Name already exists!";
    }else{

        $sql = "INSERT INTO `campaigns` ( `advertiserId`, `name`, `category`, `description`, `previewUrl`, `landingUrl`, `os`, `geo`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `storeId`, `dailyCap`, `monthlyCap`, `creatives`, `restrictions`, `startDate`, `endDate`, `type`, `crManagement`, `redirections`, `postback`, `iconUrl`, `cityNames`, `cityTargeting`, `impLink`, `createdBy`, `dt`) VALUES ('$advertiserId', '$name', '$category', '$description', '$previewUrl', '$landingUrl', '$os', '$geo', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$storeId', '$dailyCap', '$monthlyCap', '$creatives', '$restrictions', '$startDate', '$endDate', '$type', '$crManagement', '$redirections', '$postback', '$iconUrl', '$cityNames', '$cityTargeting', '$impLink', '$creatingBy', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $showAlert = true;
        }else{
            $showError = "Something went wrong!";
        }
    }
    
}

?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Add Campaign</title>
  </head>
    <body class="bg-dark">
        <?php
        if($showAlert){
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your account is now created and you can login
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div> ';
        }
        if($showError){
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $showError.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div> ';
        }
        ?>

        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Campaign</h3></div>
                                    <div class="card-body">
                                        <form action="addCampaign.php" method="post">


                                            <select class="form-control form-control-md my-3" name="advertiserId">
                                                <option value=""> -- Select Advertiser* -- </option>
                                                <?php 
                                                    $sql = "SELECT * FROM `advertisers`";
                                                    $result = mysqli_query($conn, $sql);
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        echo "<option value='".$row["id"]."'>".$row["companyName"]."</option>";
                                                    } 
                                                ?>
                                            </select>


                                            <div class="form-floating mb-3">
                                                <label for="inputName">Name*</label>    
                                                <input class="form-control" id="inputName" type="Text" name="name" placeholder="Campaign Name" required/>
                                            </div>

                                            <select class="form-control form-control-md my-3" name="category">
                                                <option value=""> -- Select Category* -- </option>
                                                <option value="Category One">non-Incent</option>
                                                <option value="Category Two">Incent</option>
                                            </select>

                                            
                                            <div class="form-floating mb-3">
                                                <label for="inputDescription">Description*</label>    
                                                <input class="form-control" id="inputDescription" type="text" name="description" placeholder="Campaign Description" required/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputPreviewUrl">Preview URL*</label>    
                                                <input class="form-control" id="inputPreviewUrl" type="text" name="previewUrl" placeholder="https://example.com" required/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputLandingUrl">Landing URL*</label>    
                                                <input class="form-control" id="inputLandingUrl" type="text" name="landingUrl" placeholder="https://example.com" required/>
                                            </div>


                                            <select class="form-control form-control-md my-3" name="os">
                                                <option value=""> -- Select OS* -- </option>
                                                <option value="AOS">AOS</option>
                                                <option value="iOS">iOS</option>
                                                <option value="Desktop">Desktop</option>
                                            </select>


                                            <div class="form-floating mb-3">
                                                <label for="inputGeo">GEO*</label>    
                                                <input class="form-control" id="inputGeo" type="text" name="geo" placeholder="geos" required/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputRevenue">Revenue*</label>    
                                                <input class="form-control" id="inputRevenue" type="text" name="revenue" placeholder="revenue" required/>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="inputStandardPayout">Standard Payout*</label>    
                                                <input class="form-control" id="inputStandardPayout" type="text" name="standardPayout" placeholder="0.0" required/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputPremiumPayout">Premium Payout*</label>    
                                                <input class="form-control" id="inputPremiumPayout" type="text" name="premiumPayout" placeholder="0.0" required/>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <label for="inputSensitivePayout">Sensitive Payout*</label>    
                                                <input class="form-control" id="inputSensitivePayout" type="text" name="sensitivePayout" placeholder="0.0" required/>
                                            </div>
                                            

                                            <select class="form-control form-control-md my-3" name="currency">
                                                <option value=""> -- Select Currency* -- </option>
                                                <option value="USD">USD</option>
                                                <option value="INR">INR</option>
                                            </select>
                                            
                                            <div class="form-floating mb-3">
                                                <label for="inputStoreId">Store Id</label>    
                                                <input class="form-control" id="inputStoreId" type="text" name="storeId" placeholder="Store ID"/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputDailyCap">Daily Cap*</label>    
                                                <input class="form-control" id="inputDailyCap" type="text" name="dailyCap" placeholder="0" required/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputMonthlyCap">Monthly Cap*</label>    
                                                <input class="form-control" id="inputMonthlyCap" type="text" name="monthlyCap" placeholder="0" required/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputCreatives">Creatives</label>    
                                                <input class="form-control" id="inputCreatives" type="text" name="creatives" placeholder="" />
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputRestrictions">Restrictions</label>    
                                                <input class="form-control" id="inputRestrictions" type="text" name="restrictions" placeholder=""/>
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputStartDate">Start Date</label>    
                                                <input class="form-control" id="inputStartDate" type="date" name="startDate" placeholder="" />
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputEndDate">End Date</label>    
                                                <input class="form-control" id="inputEndDate" type="date" name="endDate" placeholder="" />
                                            </div>


                                            <select class="form-control form-control-md my-3" name="type">
                                                <option value=""> -- Select Type -- </option>
                                                <option value="CPI">CPI</option>
                                                <option value="CPR">CPR</option>
                                                <option value="CPL">CPL</option>
                                                <option value="CPS">CPS</option>
                                                <option value="CPS">CPD</option>
                                            </select>

                                            <select class="form-control form-control-md my-3" name="crManagement">
                                                <option value=""> -- Select CR Management -- </option>
                                                <option value="AUTO">AUTO</option>
                                                <option value="MANUAL">MANUAL</option>
                                            </select>


                                            <div class="form-floating mb-3">
                                                <label for="inputRedirections">Redirections</label>    
                                                <input class="form-control" id="inputRedirections" type="text" name="redirections" placeholder="" />
                                            </div>


                                            <select class="form-control form-control-md my-3" name="postback">
                                                <option value=""> -- Select Postback -- </option>
                                                <option value="global">Global</option>
                                                <option value="install">Install</option>
                                                <option value="event">Event</option>
                                            </select>


                                            <div class="form-floating mb-3">
                                                <label for="inputIconUrl">Icon URL</label>    
                                                <input class="form-control" id="inputIconUrl" type="text" name="iconUrl" placeholder="https://example.com" />
                                            </div>


                                            <div class="form-floating mb-3">
                                                <label for="inputCityName">City Names</label>    
                                                <input class="form-control" id="inputCityName" type="text" name="cityName" placeholder="" />
                                            </div>

                                            <select class="form-control form-control-md my-3" name="cityTargeting">
                                                <option value=""> -- Select City Targeting -- </option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>


                                            <div class="form-floating mb-3">
                                                <label for="inputImpLink">Imp Link</label>    
                                                <input class="form-control" id="inputImpLink" type="text" name="impLink" placeholder="https://example.com" />
                                            </div>

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><button class="btn btn-primary btn-block" type="submit">Create Account</button></div>
                                            </div>


                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><a class="btn btn-danger btn-block" href="index.php">Close</a></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto bg-dark">
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
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>