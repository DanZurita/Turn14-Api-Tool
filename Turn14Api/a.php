<?php

if(isset($_GET["type"])) {
    if($_GET["type"] === "token") {
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.turn14.com/v1/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  // Insert your client_id and client_seceret in the space below 
// Ex: 'client_id' => '(Your Client ID HERE)'
  CURLOPT_POSTFIELDS => array('grant_type' => 'client_credentials','client_id' => '','client_secret' => ''),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
    }
    else if($_GET["type"] === "brand_data" && isset($_GET["id"]) && isset($_GET["page"]) && isset($_GET["token"])) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.turn14.com/v1/items/data/brand/".$_GET["id"]."?page=".$_GET["page"]."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_GET["token"].''
            ),
        ));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
    }

    else if($_GET["type"] === "brand_pricing_data" && isset($_GET["id"]) && isset($_GET["page"]) && isset($_GET["token"])) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.turn14.com/v1/pricing/brand/".$_GET["id"]."?page=".$_GET["page"]."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$_GET["token"].''
            ),
        ));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
    }
    else if($_GET["type"] === "brand_item_data" && isset($_GET["id"]) && isset($_GET["page"]) && isset($_GET["token"])) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.turn14.com/v1/items/brand/".$_GET["id"]."?page=".$_GET["page"]."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$_GET["token"].''
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}

else {


        //code...
        $json = file_get_contents('php://input');
        $data = json_decode($json);

    
    // $data = $_POST["data"];
    // echo $json;
    die();

    $delimiter = ","; 
    $filename = "EXPORT" . date('Y-m-d') . ".csv"; 

    $f = fopen('php://memory', 'w'); 

    // these will be the columns in excel
    $fields = array('id','brand','partDescription', 'productName', 'description', 'purchaseCost', 'priceList1', 'weight', 'length', 'width', 'height', 'imageUrl'); 
    fputcsv($f, $fields, $delimiter); 

    foreach($data as $row){ 
        // $status = ($row['active'] == 1)?'published':'unpublished';  incase you might want to use this for map or ... price
        $lineData = array($row['id'],"uknown",$row['descriptions'][0]["description"], $row['descriptions'][0]["description"], $row['descriptions'][0]["description"], $row['purchaseCost'], $row['pricing'], "unknown", "unknown", "unknown", "unknown", $row['files'][0]["links"][0]["url"]); //row data that will map to the columns
        fputcsv($f, $lineData, $delimiter); 
    } 

    fseek($f, 0); 

    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); //function to download the file
    fpassthru($f); 

}
exit; 
?>
