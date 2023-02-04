<?php
require_once 'classes/Database.php';

$db = new Database();
$conn = $db->getConnection();

echo "Connected successfully";