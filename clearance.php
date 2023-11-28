<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":

        $sql = " SELECT * FROM clearance ORDER BY clearance_id DESC";

        if (isset($sql)) {
            $stmt = $conn->prepare($sql);


            $stmt->execute();
            $clearance = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($clearance);
        }


        break;




    case "POST":
        $resident = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO clearance (resident_id, resident_name, resident_address, resident_birthday, resident_purpose, resident_issued, resident_until) VALUES (:resident_id, :resident_name, :resident_address, :resident_birthday, :resident_purpose, :resident_issued, :resident_until)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':resident_id', $resident->resident_id);
        $stmt->bindParam(':resident_name', $resident->resident_name);
        $stmt->bindParam(':resident_address', $resident->resident_address);
        $stmt->bindParam(':resident_birthday', $resident->resident_birthday);
        $stmt->bindParam(':resident_purpose', $resident->resident_purpose);
        $stmt->bindParam(':resident_issued', $resident->resident_issued);
        $stmt->bindParam(':resident_until', $resident->resident_until);


        if ($stmt->execute()) {

            $response = [
                "status" => "success",
                "message" => "clearance successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "clearance failed"
            ];
        }

        echo json_encode($response);
        break;



    case "DELETE":
        $clearance = json_decode(file_get_contents('php://input'));
        $sql = "DELETE FROM clearance WHERE clearance_id = :clearance_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':clearance_id', $clearance->clearance_id);

        if ($stmt->execute()) {
            $response = [
                "status" => "success",
                "message" => "clearance_id deleted successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "clearance_id delete failed"
            ];
        }

        echo json_encode($response);
        break;
}
