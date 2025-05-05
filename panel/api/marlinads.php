<?php  
/*****************************  Appitate API Integration  *********************************/
//http://api-marlinads.affise.com/3.0/partner/offers
//API-Key: 90079b093959e4689b3438cc7a02d6cb

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://api-marlinads.affise.com/3.0/partner/offers");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$headers = [
    'API-Key: 90079b093959e4689b3438cc7a02d6cb'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$offerList = curl_exec($ch);
curl_close($ch);

$arrayOfferData = json_decode($offerList, true); // true means we want an associative array

if (json_last_error() === JSON_ERROR_NONE) {

    $allOffers = $arrayOfferData['offers'];
    $offerCount = sizeof($allOffers);

    include 'partials/_dbconnect.php';
    $advertiserId = "14";

   
    for ($i = 0; $i < $offerCount; $i++) {

        // echo "advtId: ".$advertiserId."<br>";
        $advt_offer_id = $advertiserId.".".$allOffers[$i]['offer_id'];
        // echo "advt_offer_id: ".$advt_offer_id."<br>";
        $name = $allOffers[$i]['title'];
        // $name = "title";
        // echo "name: ".$name."<br>";
        $category = "Non-Incent";
        // echo "cat: ".$category."<br>";
        $description = $allOffers[$i]['kpi']['en'];
        // $description = "desc";
        // $description = "hello";
        // echo "desc: ".$description."<br>";
        $previewUrl = $allOffers[$i]['preview_url'];
        // $previewUrl = "preview_url";
        // echo "preview: ".$previewUrl."<br>";
        $landingUrl = $allOffers[$i]['link'];
        // $landingUrl = "link";
        // echo "landing: ".$landingUrl."<br>";
        $os = $allOffers[$i]['targeting'][0]['os']['allow'][0]['name'];
        // $os = "os";
        // echo "os: ".$os."<br>";
        $geo = $allOffers[$i]['targeting'][0]['country']['allow'][0];
        // $geo = "country";
        // echo "geo: ".$geo."<br>";
        $revenue = $allOffers[$i]['payments'][0]['revenue'];
        // $revenue = "revenue";
        // echo "revenue: ".$revenue."<br>";
        $standardPayout = $revenue / 2;
        // $standardPayout = 1;
        // echo "std po: ".$standardPayout."<br>";
        $premiumPayout = $revenue * 0.7;
        // $premiumPayout = 2;
        // echo "pre po: ".$premiumPayout."<br>";
        $sensitivePayout = $revenue;
        // $sensitivePayout = 3;
        // echo "sen po: ".$sensitivePayout."<br>";
        $currency = $allOffers[$i]['payments'][0]['currency'];
        // $currency = "currency";
        // echo "currency: ".$currency."<br>";
        $storeId = $allOffers[$i]['bundle_id'];
        // $storeId = "bundle_id";
        // echo "storeId: ".$storeId."<br>";
        $dailyCap = $allOffers[$i]['caps'][0]['value'];
        // $dailyCap = 10;
        // echo "daily cap: ".$dailyCap."<br>";
        $monthlyCap = $dailyCap * 30;
        // echo "monthly cap: ".$monthlyCap."<br>";
        $creatives = $allOffers[$i]['creatives'][0]['url'];
        // $creatives = "creatives";
        // echo "creatives: ".$creatives."<br>";
        $restrictions = $description;
        // echo "restrictions: ".$restrictions."<br>";
        $startDate = date("Y-m-d");
        // echo "startDate: ".$startDate."<br>";
        $endDate = date('Y-m-d', strtotime("now + 1 years"));
        // echo "endDate: ".$endDate."<br>";
        $type = $allOffers[$i]['categories'][0];
        // $type = "categories";
        // echo "type: ".$type."<br>";
        $crManagement = "API";
        // echo "crManagement: ".$crManagement."<br>";
        $redirections = "redirections";
        // echo "redirections: ".$redirections."<br>";
        $postback = $allOffers[$i]['categories'][0];
        // $postback = "categories";
        // echo "postback: ".$postback."<br>";
        $iconUrl = $allOffers[$i]['logo_source'];
        // $iconUrl = "logo_source";
        // echo "iconUrl: ".$iconUrl."<br>";
        $cityNames = "All";
        // echo "cityNames: ".$cityNames."<br>";
        $cityTargeting = "No";
        // echo "cityTargeting: ".$cityTargeting."<br>";
        $impLink = $allOffers[$i]['impressions_link'];
        // $impLink = "impressions_link";
        // echo "impLink: ".$impLink."<br>";
        $creatingBy = "admin@gmail.com";
        // echo "creatingBy: ".$creatingBy."<br>";


        // Escape special characters for SQL
        $advertiserId = $conn->real_escape_string($advertiserId);
        $advt_offer_id = $conn->real_escape_string($advt_offer_id);
        $name = $conn->real_escape_string($name);
        $category = $conn->real_escape_string($category);
        $description = $conn->real_escape_string($description);
        $previewUrl = $conn->real_escape_string($previewUrl);
        $landingUrl = $conn->real_escape_string($landingUrl);
        $os = $conn->real_escape_string($os);
        $geo = $conn->real_escape_string($geo);
        $revenue = $conn->real_escape_string($revenue);
        $standardPayout = $conn->real_escape_string($standardPayout);
        $premiumPayout = $conn->real_escape_string($premiumPayout);
        $sensitivePayout = $conn->real_escape_string($sensitivePayout);
        $currency = $conn->real_escape_string($currency);
        $storeId = $conn->real_escape_string($storeId);
        $dailyCap = $conn->real_escape_string($dailyCap);
        $monthlyCap = $conn->real_escape_string($monthlyCap);
        $creatives = $conn->real_escape_string($creatives);
        $restrictions = $conn->real_escape_string($restrictions);
        $startDate = $conn->real_escape_string($startDate);
        $endDate = $conn->real_escape_string($endDate);
        $type = $conn->real_escape_string($type);
        $crManagement = $conn->real_escape_string($crManagement);
        $redirections = $conn->real_escape_string($redirections);
        $postback = $conn->real_escape_string($postback);
        $iconUrl = $conn->real_escape_string($iconUrl);
        $cityNames = $conn->real_escape_string($cityNames);
        $cityTargeting = $conn->real_escape_string($cityTargeting);
        $impLink = $conn->real_escape_string($impLink);
        $createdBy = $conn->real_escape_string($createdBy);





        $sql = "SELECT * FROM `campaigns` WHERE `advt_offer_id` LIKE '$advt_offer_id'";
        $result = mysqli_query($conn, $sql);

        $num = mysqli_num_rows($result);
        if ($num == 1){
            //update campaign
            $row = mysqli_fetch_assoc($result);
            $sqlUpdate = "UPDATE `campaigns` SET `name` = '$name', `description` = '$description', `previewUrl` = '$previewUrl', `landingUrl` = '$landingUrl', `os` = '$os', `geo` = '$geo', `revenue` = '$revenue', `standardPayout` = '$standardPayout', `premiumPayout` = '$premiumPayout', `sensitivePayout` = '$sensitivePayout', `currency` = '$currency', `storeId` = '$storeId', `dailyCap` = '$dailyCap', `monthlyCap` = '$monthlyCap', `creatives` = '$creatives', `restrictions` = '$restrictions', `type` = '$type', `postback` = '$postback', `iconUrl` = '$iconUrl', `impLink` = '$impLink', `status` = 'active' WHERE `campaigns`.`id` = '".$row['id']."'";
            $result2 = mysqli_query($conn, $sqlUpdate);
        } 
        else{
            $sqlAddCampaign = "INSERT INTO `campaigns` ( `advertiserId`, `advt_offer_id`, `name`, `category`, `description`, `previewUrl`, `landingUrl`, `os`, `geo`, `revenue`, `standardPayout`, `premiumPayout`, `sensitivePayout`, `currency`, `storeId`, `dailyCap`, `monthlyCap`, `creatives`, `restrictions`, `startDate`, `endDate`, `type`, `crManagement`, `redirections`, `postback`, `iconUrl`, `cityNames`, `cityTargeting`, `impLink`, `createdBy`, `dt`) VALUES ('$advertiserId', '$advt_offer_id', '$name', '$category', '$description', '$previewUrl', '$landingUrl', '$os', '$geo', '$revenue', '$standardPayout', '$premiumPayout', '$sensitivePayout', '$currency', '$storeId', '$dailyCap', '$monthlyCap', '$creatives', '$restrictions', '$startDate', '$endDate', '$type', '$crManagement', '$redirections', '$postback', '$iconUrl', '$cityNames', '$cityTargeting', '$impLink', '$creatingBy', current_timestamp())";
            $result3 = mysqli_query($conn, $sqlAddCampaign);
        }
    }

    $sql2 = "SELECT * FROM `campaigns` where advertiserId='$advertiserId' AND `crManagement` LIKE 'API'"; 
    $result2 = mysqli_query($conn, $sql2);
    
    while($row2 = mysqli_fetch_assoc($result2)){

        $isUpdates = false;
        for ($j = 0; $j < $offerCount; $j++) {
            $cur_ofr_id = $advertiserId.".".$allOffers[$j]['offer_id'];
            if($row2['advt_offer_id'] == $cur_ofr_id){
                $isUpdates = true;
                break;
            }
        }
        if($isUpdates == false){
            $sqlUpdateInactive = "UPDATE `campaigns` SET `status` = 'inactive' WHERE `campaigns`.`id` = '".$row2['id']."'";
            mysqli_query($conn, $sqlUpdateInactive);
        }
    }
} else {
    // Handle error
    echo "Failed to decode JSON: " . json_last_error_msg();
}


?>

