<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":


        $sql = "SELECT 
            CASE 
            WHEN resident_gender = 'male' THEN 'Male' 
            WHEN resident_gender = 'female' THEN 'Female' 
            ELSE 'Other/Undefined' 
            END AS gender,
            COUNT(*) AS count 
            FROM 
                resident 
            GROUP BY 
                resident_gender";


        if (isset($sql)) {
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $pie = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($pie);
        }


        break;
}
