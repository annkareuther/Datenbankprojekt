<?php
echo "Tabellen erstellen und deren Relationen";
require_once("database.php");

$database = new Database();
$login = [];
if (!$database->prepare_tables()) {
    $login["success"] = false;
    $login["message"] = "Login nicht bereit.";
    echo json_encode($login);
    return false;
}
