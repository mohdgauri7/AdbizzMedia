<?php   

include 'partials/_dbconnect.php';
include 'api.php';

$api_key = $_GET['key'];

$sqlAPI = "SELECT * FROM `publishers` where api_key='$api_key'"; 
$resultAPI = mysqli_query($conn, $sqlAPI);
$numAPI = mysqli_num_rows($resultAPI);
if ($numAPI == 1){
    $rowAPI = mysqli_fetch_assoc($resultAPI);

    $pubId = $rowAPI['id'];
    $sql = "SELECT * FROM `approved` where publisherId='$pubId'"; 
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $campId = $row['campaignId'];
        $sql2 = "SELECT * FROM `campaigns` where id='$campId' AND `status` LIKE 'active'"; 
        $result2 = mysqli_query($conn, $sql2);
        $num = mysqli_num_rows($result2);
        if($num == 1){
            $row2 = mysqli_fetch_assoc($result2);

            $offer = new stdClass();
            $offer->id = $row2['id'];
            $offer->offer_id = $row2['advt_offer_id'];
            $offer->title = $row2['name'];
            $offer->description = $row2['description'];
            $offer->preview = $row2['previewUrl'];
            $offer->tracking = "https://adfliks.com/publisher/tracking.php?aff_id=".$pubId."&offer_id=".$campId;
            $offer->os = $row2['os'];
            $offer->geo = $row2['geo'];
            $offer->payout = $row2['standardPayout'];
            $offer->currency = $row2['currency'];

            $data[] = $offer; 
        }
    }
   $response  = [];
   $response['status'] =  1;
   $response['offers'] =  $data;
   echo json_encode($response, JSON_PRETTY_PRINT);

}else{
    echo json_encode("Invalid API Key");
    // echo "Invalid API Key";
}


?>

