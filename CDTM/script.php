<?php
$json = file_get_contents("php://input");

$object = json_decode($json);

$id_delete = $object->id_del;
echo $id_delete;

define('DATABASE_SERVER', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME', 'cdtmtest');
$connection = null;

try {
    $connection = new PDO(
        "mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME,
        DATABASE_USER,
        DATABASE_PASSWORD
    );
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "mysql:host".DATABASE_SERVER.";dbname=".DATABASE_NAME;
    //echo "Connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $connection = null;
}
$sql_delete = "DELETE FROM employee WHERE id='{$id_delete}'";
//echo $sql_delete;
try {
    $statement = $connection->prepare($sql_delete);
    $statement->execute();
    //echo "Completed";


} catch (PDOException $e) {
}

?>