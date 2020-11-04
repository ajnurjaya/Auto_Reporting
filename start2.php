<?php
require __DIR__ .  '/vendor/autoload.php';
use GuzzleHttp\Client;
$httpClient = new GuzzleHttp\Client([
    'proxy' => '10.59.82.2:8080', // by default, Charles runs on localhost port 8888
    'verify' => false, // otherwise HTTPS requests will fail.
]);

$client = new \Google_client();
$client->setApplicationName('sheet-mbp');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig( __DIR__ . '/credentials.json');
$client->setHttpClient($httpClient);




$service= new \Google_service_Sheets($client);
$spreadsheetId = "1zPAwOdW_VD3lR0RbQRV-vbl9nQ4DG_GdTdAKYFJJxKs";

// $range = "Sheet1!A1:B3";
// $response = $service->spreadsheets_values->get($spreadsheetId, $range);
// $values = $response->getValues();

// //var_dump ($values);

// $range2 = 'A1';
// $response2 = $service->spreadsheets_values->get($spreadsheetId, $range2);
// $values2 = $response2->getValues();
// var_dump($values2);
// echo $values2[0][0];


$con2 = mysqli_connect("10.35.105.237","username","password") or die ('error ga bisa konek: ' . mysqli_error());
$hasil = mysqli_select_db($con2, "dbname") or die ('error memilih database: ' .mysqli_error());

for ($j=0; $j < 17 ; $j++) { 
	# code...
	switch ($j) {
		case '0':
			$rtpo = 'Binjai';
			break;
		case '1':
			$rtpo = 'Banda aceh';
			break;
		case '2':
			$rtpo = 'Kabanjahe';
			break;
		case '3':
			$rtpo = 'Kisaran';
			break;
		case '4':
			$rtpo = 'Langsa';
			break;
		case '5':
			$rtpo = 'Lhokseumawe';
			break;
		case '6':
			$rtpo = 'Lubuk pakam';
			break;
		case '7':
			$rtpo = 'Medan Inner';
			break;
		case '8':
			$rtpo = 'Medan Outer';
			break;
		case '9':
			$rtpo = 'Meulaboh';
			break;
		case '10':
			$rtpo = 'Nias';
			break;
		case '11':
			$rtpo = 'Padang Sidempuan';
			break;
		case '12':
			$rtpo = 'Pematang Siantar';
			break;
		case '13':
			$rtpo = 'Rantau Prapat';
			break;
		case '14':
			$rtpo = 'Sibolga';
			break;
		case '15':
			$rtpo = 'Singkil';
			break;
		case '16':
			$rtpo = 'Takengon';
			break;
	}

   $query2 = mysqli_query($con2,"SELECT CURRENT_DATE(),nsa,rtpo,hour(timediff(now(),datetime_start)) as age FROM zp_cell_list WHERE status ='open' and rtpo like '%$rtpo%' and  remark not like 'ex%' and hour(timediff(now(),datetime_start))>=24 order by age DESC");
    $fields_amount = mysqli_field_count($con2);
    $rows_num=mysqli_affected_rows($con2);
	$counter = 0;
	$counter24 = 0;
	$counter2412 = 0;
	$counter12 = 0;
    for ($i=0; $i < $rows_num ; $i++) { 
        $row = mysqli_fetch_row($query2);
		if ($row[3]>=24){
			$counter24 ++;
		} elseif (($row[3]>= 12)&&($row[3]<24)) {
			$counter2412 ++;
		} else{
			$counter12 ++;
		}
		$counter ++;
	}



//script untuk update ke sheet

$range3 = 'A1';
$values = [
    [$row[0],$row[1],$row[2],$counter24]
];
$body = new Google_Service_Sheets_ValueRange([
    'values' => $values
]);
$params = [
    'valueInputOption' => "RAW"
];
$result = $service->spreadsheets_values->append($spreadsheetId, $range3, $body, $params);
var_dump($result);
}


