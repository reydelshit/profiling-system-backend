<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":


        if (isset($_GET['house_id'])) {
            $household_id = $_GET['house_id'];
            $sql = "SELECT * FROM household WHERE house_id = :house_id";
        }

        if (!isset($_GET['house_id'])) {
            $sql = " SELECT * FROM household ORDER BY house_id DESC";
        }


        if (isset($sql)) {
            $stmt = $conn->prepare($sql);

            if (isset($household_id)) {
                $stmt->bindParam(':house_id', $household_id);
            }

            $stmt->execute();
            $household = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($household);
        }


        break;





    case "POST":
        $household = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO household (house_no, house_purok, house_address) VALUES (:house_no, :house_purok, :house_address)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':house_no', $household->house_no);
        $stmt->bindParam(':house_purok', $household->house_purok);
        $stmt->bindParam(':house_address', $household->house_address);


        if ($stmt->execute()) {

            $response = [
                "status" => "success",
                "message" => "household successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "household failed"
            ];
        }

        echo json_encode($response);
        break;

    case "PUT":
        $household = json_decode(file_get_contents('php://input'));
        $sql = "UPDATE household 
            SET 
            house_no = :house_no,
            house_purok = :house_purok,
            house_address = :house_address
        WHERE house_id = :house_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':house_no', $household->house_no);
        $stmt->bindParam(':house_purok', $household->house_purok);
        $stmt->bindParam(':house_address', $household->house_address);
        $stmt->bindParam(':house_id', $household->house_id);

        if ($stmt->execute()) {
            $response = [
                "status" => "success",
                "message" => "Household updated successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "Failed to update household"
            ];
        }

        echo json_encode($response);
        break;

    case "DELETE":
        $household = json_decode(file_get_contents('php://input'));
        $sql = "DELETE FROM household WHERE house_id = :house_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':house_id', $household->house_id);

        if ($stmt->execute()) {
            $response = [
                "status" => "success",
                "message" => "household deleted successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "household delete failed"
            ];
        }

        echo json_encode($response);
        break;
}
