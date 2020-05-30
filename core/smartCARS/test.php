<?php

define('DBASE_USER', 'flycaribbeanva_com');
define('DBASE_PASS', '2Sazi36A');
define('DBASE_NAME', 'flycaribbeanva_com');
define('DBASE_SERVER', 'localhost');
define('DBASE_TYPE', 'mysqli');

$dbConnection;

$dbcreds = array();
$dbcreds['user'] = DBASE_USER;
$dbcreds['pass'] = DBASE_PASS;
$dbcreds['name'] = DBASE_NAME;
$dbcreds['server'] = DBASE_SERVER;

$flightcode = "FCB";
    $flightnumber = "666";
    $depicao = "EDDF";
    $arricao = "EDDW";
    $route = "DCT";
    $aircraft = "124";
    $cruisealtitude = "30000";
    $distance = "20";
    $deptime = "Time";
    $arrtime = "Time";
    $flighttime = "1";
    $ticketprice = "155";
    $type = "P";
    
try {
	$dbConnection = new PDO('mysql:dbname=' . $dbcreds['name'] . ';host=' . $dbcreds['server'] . ';charset=utf8', $dbcreds['user'], $dbcreds['pass']);
}
catch(PDOException $err) {        
	die("Failed to connect to the database.");
} 

echo "Connected successfully\n";

$stmt = $dbConnection->prepare("INSERT INTO phpvms_schedules (id, code, flightnum, depicao, arricao, route, aircraft, flightlevel, distance, deptime, arrtime, flighttime, price, flighttype, enabled) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");

echo "\nafter prepare error info:\n";
print_r($dbConnection->errorInfo());
echo "\nPDO::errorCode(): ", $stmt->errorCode();
echo "\n";

$stmt->execute(array(
    $flightcode,
    $flightnumber,
    $depicao,
    $arricao,
    $route,
    $aircraft,
    $cruisealtitude,
    $distance,
    $deptime,
    $arrtime,
    $flighttime,
    $ticketprice,
    $type
));

print_r($dbConnection->errorInfo());
echo "\nPDO::errorCode(): ", $stmt->errorCode();

$routeid = $dbConnection->lastInsertID();
$stmt->closeCursor();


echo "routeid $routeid \n";
echo "\n test 2 ... \n";


$sql = "INSERT INTO phpvms_schedules (id, code, flightnum, depicao, arricao, route, aircraft, flightlevel, distance, deptime, arrtime, flighttime, price, flighttype, enabled) VALUES (NULL, '$flightcode', '$flightnumber', '$depicao', '$arricao', '$route', '$aircraft', '$cruisealtitude', '$distance', '$deptime', '$arrtime', '$flighttime', '$ticketprice', '$type', 0)";

if ($dbConnection->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

    
    
    

?>
