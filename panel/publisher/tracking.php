<?php 
include '../partials/_dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["aff_id"]) && isset($_GET["offer_id"]) && isset($_GET["aff_sub"])){

    
    $pub_id = $_GET['aff_id'];
    $camp_id = $_GET['offer_id'];
    $click_id = $_GET['aff_sub'];
    $sub_pub_id = $_GET['aff_sub2'];
    $gaid = $_GET['gaid'];
    $ifaid = $_GET['ifaid'];
    $device_id = $_GET['device_id'];
    $appName = $_GET['sub1'];

    $sqlPub = "SELECT * FROM `publishers` where id='$pub_id'";
    $resultPub = mysqli_query($conn, $sqlPub);
    $rowPub = mysqli_fetch_assoc($resultPub);

    $pubType = $rowPub['pubTier'];


    $sqlCamp = "SELECT * FROM `campaigns` where id='$camp_id'";
    $resultCamp = mysqli_query($conn, $sqlCamp);
    $rowCamp = mysqli_fetch_assoc($resultCamp);
    
    $advertiserId = $rowCamp['advertiserId'];
    $campName = $rowCamp['name'];
    $revenue = $rowCamp['revenue'];
    $standardPayout = $rowCamp['standardPayout'];
    $premiumPayout = $rowCamp['premiumPayout'];
    $sensitivePayout = $rowCamp['sensitivePayout'];
    $currency = $rowCamp['currency'];

    $campStatus = $rowCamp['status'];
    


    if($sub_pub_id == "testoffer" && $campStatus == "active"){
        $sql = "INSERT INTO `clicks` (`id`, `pub_id`, `pubType`, `camp_id`, `advertiserId`, `campName`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `click_id`, `aff_sub2`, `gaid`, `ifaid`, `device_id`, `sub1`, `dt`) VALUES (NULL, '$pub_id', '$pubType', '$camp_id', '$advertiserId', '$campName', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$click_id', '$sub_pub_id', '$gaid', '$ifaid', '$device_id', '$appName', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result){
            $isEvent = $rowCamp['postback'];
            if($isEvent == "global"){
                header("location: gpixel.php?click_id=".$click_id);
            }else{
                header("location: goal.php?click_id=".$click_id."&event=".$isEvent);
            }
            
        }else{
            $data = [
                'status' => 400,
                'message' => "Something Went Wrong, Try Again."
            ];
            echo json_encode($data);
        }

    }else if($campStatus == "active"){

        $sqlCheck = "Select * from clicks where click_id='$click_id'";
        $resultCheck = mysqli_query($conn, $sqlCheck);
        $numCheck = mysqli_num_rows($resultCheck);

        if($numCheck == 0){
            $sql = "INSERT INTO `clicks` (`id`, `pub_id`, `pubType`, `camp_id`, `advertiserId`, `campName`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `click_id`, `aff_sub2`, `gaid`, `ifaid`, `device_id`, `sub1`, `dt`) VALUES (NULL, '$pub_id', '$pubType', '$camp_id', '$advertiserId', '$campName', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$click_id', '$sub_pub_id', '$gaid', '$ifaid', '$device_id', '$appName', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
    
                // redirect to advertiser landing url
                $sqlForAdvtId = "SELECT * FROM `campaigns` where id='$camp_id'";
                $resultCampaign = mysqli_query($conn, $sqlForAdvtId);
                $rowCampData = mysqli_fetch_assoc($resultCampaign);
    
                $landingBaseUrl = $rowCampData['landingUrl'];
    
                $sqlForAffSub = "SELECT * FROM `advertisers` where id='$advertiserId'";
                $resultAdvertiser = mysqli_query($conn, $sqlForAffSub);
                $rowAdvertiserData = mysqli_fetch_assoc($resultAdvertiser);
    
                $myPubId = "{affiliateid}";
                $mySubPubId = "{subaffid}";
                $myClickId = "{clickid}";
                $myDeviceId = "{deviceid}";
                $mySub1 = "{sub1}";
    
                $affSubs = $rowAdvertiserData['macros'];
                $affSubs = str_replace($myPubId,$pub_id,$affSubs);
                $affSubs = str_replace($mySubPubId,$sub_pub_id,$affSubs);
                $affSubs = str_replace($myClickId,$click_id,$affSubs);
                $affSubs = str_replace($myDeviceId,$device_id,$affSubs);
                $affSubs = str_replace($mySub1,$appName,$affSubs);
    
                header("location: ".$landingBaseUrl."".$affSubs);
            }
        }else{
            $data = [
                'status' => 0,
                'message' => "Click Id Already Exist, Try Again With Unique Click ID."
            ];
            echo json_encode($data);
        }
    }
}else{
    $data = [
        'status' => 500,
        'message' => "Not Authenticated"
    ];
    echo json_encode($data);
}

?>



