<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":

        $sql = "SELECT * FROM barangay_details ORDER BY barangay_details_id DESC LIMIT 1";


        if (isset($sql)) {
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $officials = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($officials);
        }

        break;

    case "POST":
        $details  = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO barangay_details (barangay_name, barangay_address) VALUES (:barangay_name, :barangay_address)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':barangay_name', $details->barangay_name);
        $stmt->bindParam(':barangay_address', $details->barangay_address);


        if ($stmt->execute()) {

            $response = [
                "status" => "success",
                "message" => "details successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "details failed"
            ];
        }

        echo json_encode($response);
        break;
}
