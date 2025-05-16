<?php
// Database connection info
$serverName = "LAPTOP-NGLV6NE3\SQLEXPRESS";  
$connectionOptions = [
    "Database" => "Surevice_db",
    "Uid" => "surevice_admin",
    "PWD" => "surevice_db121",
    "CharacterSet" => "UTF-8"
];

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    // Connection failed, show errors
    die(print_r(sqlsrv_errors(), true));
}

echo "Connected successfully!";

// Always close the connection when done
sqlsrv_close($conn);
?>
