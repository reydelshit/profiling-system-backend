<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":


        $sql = "SELECT 
             CASE 
            WHEN TIMESTAMPDIFF(YEAR, resident_birthday, CURDATE()) <= 12 THEN 'Child'
            WHEN TIMESTAMPDIFF(YEAR, resident_birthday, CURDATE()) BETWEEN 13 AND 19 THEN 'Teenager'
            WHEN TIMESTAMPDIFF(YEAR, resident_birthday, CURDATE()) BETWEEN 20 AND 59 THEN 'Adult'
            ELSE 'Senior'
            END AS age_group,
            COUNT(*) AS count 
        FROM 
            resident 
        GROUP BY 
            age_group";


        if (isset($sql)) {
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $pie = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($pie);
        }


        break;
}
