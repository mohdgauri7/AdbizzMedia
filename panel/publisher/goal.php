<?php 
include '../partials/_dbconnect.php';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["click_id"]) && isset($_GET["event"])){

    $click_id = $_GET['click_id'];
    $event = $_GET['event'];

    $sql = "Select * from clicks where click_id='$click_id'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1){
        
        $row = mysqli_fetch_assoc($result);

        $pub_id = $row['pub_id'];
        $pubType = $row['pubType'];
        $camp_id = $row['camp_id'];
        $advertiserId = $row['advertiserId'];
        $campName = $row['campName'];
        $revenue = $row['revenue'];
        $standardPayout = $row['standardPayout'];
        $premiumPayout = $row['premiumPayout'];
        $sensitivePayout = $row['sensitivePayout'];
        $currency = $row['currency'];
        $click_id = $row['click_id'];
        $sub_pub_id = $row['aff_sub2'];
        $gaid = $row['gaid'];
        $ifaid = $row['ifaid'];
        $device_id = $row['device_id'];
        $appName = $row['sub1'];

        if($sub_pub_id == "testoffer"){
            $sql2 = "INSERT INTO `event_conversions` (`id`, `pub_id`, `pubType`, `camp_id`, `advertiserId`, `campName`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `click_id`, `aff_sub2`, `gaid`, `ifaid`, `device_id`, `sub1`, `event`, `dt`) VALUES (NULL, '$pub_id', '$pubType', '$camp_id', '$advertiserId', '$campName', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$click_id', '$sub_pub_id', '$gaid', '$ifaid', '$device_id', '$appName', '$event', current_timestamp())";
            $sql3 = "INSERT INTO `publisher_event_conversions` (`id`, `pub_id`, `pubType`, `camp_id`, `advertiserId`, `campName`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `click_id`, `aff_sub2`, `gaid`, `ifaid`, `device_id`, `sub1`, `event`, `dt`) VALUES (NULL, '$pub_id', '$pubType', '$camp_id', '$advertiserId', '$campName', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$click_id', '$sub_pub_id', '$gaid', '$ifaid', '$device_id', '$appName', '$event', current_timestamp())";
            $result3 = mysqli_query($conn, $sql3);
            $result2 = mysqli_query($conn, $sql2);
        
            if ($result2 && $result3){
                $data = [
                    'status' => 200,
                    'message' => "Testing Successful"
                ];
                echo json_encode($data);
            }
        }else{
            $sql2 = "INSERT INTO `global_conversions` (`id`, `pub_id`, `pubType`, `camp_id`, `advertiserId`, `campName`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `click_id`, `aff_sub2`, `gaid`, `ifaid`, `device_id`, `sub1`, `dt`) VALUES (NULL, '$pub_id', '$pubType', '$camp_id', '$advertiserId', '$campName', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$click_id', '$sub_pub_id', '$gaid', '$ifaid', '$device_id', '$appName', current_timestamp())";
            $result2 = mysqli_query($conn, $sql2);

            $sqlCamp = "Select * from campaigns where id='$camp_id'";
            $resultCamp = mysqli_query($conn, $sqlCamp);
            $rowCamp = mysqli_fetch_assoc($resultCamp);

            $sqlPub = "Select * from publishers where id='$pub_id'";
            $resultPub = mysqli_query($conn, $sqlPub);
            $rowPub = mysqli_fetch_assoc($resultPub);

            $campStatus = $rowCamp['status'];
            $pubPostbackStatus = $rowPub['postback_status'];
            if($campStatus == "active" && $pubPostbackStatus == "active"){
                $sql3 = "INSERT INTO `publisher_event_conversions` (`id`, `pub_id`, `pubType`, `camp_id`, `advertiserId`, `campName`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `click_id`, `aff_sub2`, `gaid`, `ifaid`, `device_id`, `sub1`, `dt`) VALUES (NULL, '$pub_id', '$pubType', '$camp_id', '$advertiserId', '$campName', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$click_id', '$sub_pub_id', '$gaid', '$ifaid', '$device_id', '$appName', current_timestamp())";
                $result3 = mysqli_query($conn, $sql3);
            }
        }

    }else{
        $data = [
            'status' => 400,
            'message' => "Invalied Postback"
        ];
        echo json_encode($data);
    }
}else{
    $data = [
        'status' => 500,
        'message' => "Not Authenticated"
    ];
    echo json_encode($data);
}

?>