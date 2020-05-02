<?php  
include_once "db.php";    
$data = [];
header('Content-Type: application/json');
$lat  = @$_GET['lat'];
$long = @$_GET['lng'];
$jarak = @$_GET['jarak'];
$harga = @$_GET['harga'];

$sort = "";

if(!empty($harga)) {
    $sort = " kos.harga {$harga}, ";
}

$Q = (new DB())->query("
	SELECT kos.*, user.nama nama_pemilik,
		(6371 * acos(cos(radians({$lat})) 
        * cos(radians(kos.latitude)) * cos(radians(kos.longitude) 
        - radians({$long})) + sin(radians({$lat})) 
        * sin(radians(kos.latitude)))) 
        AS jarak 
    FROM kos 
    LEFT JOIN user ON user.id = kos.id_user
	HAVING jarak <= {$jarak} 
	ORDER BY {$sort} jarak ASC;
");
$data = [];
while($t = mysqli_fetch_array($Q, MYSQLI_ASSOC)) {
	$data[] = $t;
} 
echo json_encode($data); 
?>