<?php


include 'DBconnect.php';
$objDB = new DbConnect();
$conn = $objDB->connect();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":

        if (isset($_GET['resident_id'])) {
            $resident_id = $_GET['resident_id'];
            $sql = "SELECT * FROM resident WHERE resident_id = :resident_id";
        }

        if (!isset($_GET['resident_id'])) {
            $sql = " SELECT * FROM resident ORDER BY resident_id DESC";
        }



        if (isset($sql)) {
            $stmt = $conn->prepare($sql);

            if (isset($resident_id)) {
                $stmt->bindParam(':resident_id', $resident_id);
            }

            $stmt->execute();
            $product = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($product);
        }


        break;





    case "POST":
        $resident = json_decode(file_get_contents('php://input'));
        $sql = "INSERT INTO resident (resident_firstname, resident_middlename, resident_lastname, resident_extension, resident_birthday, resident_place_of_birth, resident_nationality, resident_religion, resident_weight, resident_height, resident_father_name, resident_mother_name, resident_houseno, resident_gender, resident_image, resident_type, resident_civilstatus, resident_purok) VALUES (:resident_firstname, :resident_middlename, :resident_lastname, :resident_extension, :resident_birthday, :resident_place_of_birth, :resident_nationality, :resident_religion, :resident_weight, :resident_height, :resident_father_name, :resident_mother_name, :resident_houseno, :resident_gender, :resident_image, :resident_type, :resident_civilstatus, :resident_purok)";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':resident_firstname', $resident->resident_firstname);
        $stmt->bindParam(':resident_middlename', $resident->resident_middlename);
        $stmt->bindParam(':resident_lastname', $resident->resident_lastname);
        $stmt->bindParam(':resident_extension', $resident->resident_extension);
        $stmt->bindParam(':resident_birthday', $resident->resident_birthday);
        $stmt->bindParam(':resident_place_of_birth', $resident->resident_place_of_birth);
        $stmt->bindParam(':resident_nationality', $resident->resident_nationality);
        $stmt->bindParam(':resident_religion', $resident->resident_religion);
        $stmt->bindParam(':resident_weight', $resident->resident_weight);
        $stmt->bindParam(':resident_height', $resident->resident_height);
        $stmt->bindParam(':resident_father_name', $resident->resident_father_name);
        $stmt->bindParam(':resident_mother_name', $resident->resident_mother_name);
        $stmt->bindParam(':resident_houseno', $resident->resident_houseno);


        $stmt->bindParam(':resident_gender', $resident->resident_gender);
        $stmt->bindParam(':resident_image', $resident->resident_image);
        $stmt->bindParam(':resident_type', $resident->resident_type);
        $stmt->bindParam(':resident_civilstatus', $resident->resident_civilstatus);
        $stmt->bindParam(':resident_purok', $resident->resident_purok);


        if ($stmt->execute()) {

            $response = [
                "status" => "success",
                "message" => "resident successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "resident failed"
            ];
        }

        echo json_encode($response);
        break;

    case "PUT":
        $resident = json_decode(file_get_contents('php://input'));
        $sql = "UPDATE resident 
        SET 
            resident_firstname = :resident_firstname,
            resident_middlename = :resident_middlename,
            resident_lastname = :resident_lastname,
            resident_extension = :resident_extension,
            resident_birthday = :resident_birthday,
            resident_place_of_birth = :resident_place_of_birth,
            resident_nationality = :resident_nationality,
            resident_religion = :resident_religion,
            resident_weight = :resident_weight,
            resident_height = :resident_height,
            resident_father_name = :resident_father_name,
            resident_mother_name = :resident_mother_name,
            resident_houseno = :resident_houseno,
            resident_gender = :resident_gender,
            resident_image = :resident_image,
            resident_type = :resident_type,
            resident_civilstatus = :resident_civilstatus,
            resident_purok = :resident_purok
        WHERE resident_id = :resident_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':resident_id', $resident->resident_id);
        $stmt->bindParam(':resident_firstname', $resident->resident_firstname);
        $stmt->bindParam(':resident_middlename', $resident->resident_middlename);
        $stmt->bindParam(':resident_lastname', $resident->resident_lastname);
        $stmt->bindParam(':resident_extension', $resident->resident_extension);
        $stmt->bindParam(':resident_birthday', $resident->resident_birthday);
        $stmt->bindParam(':resident_place_of_birth', $resident->resident_place_of_birth);
        $stmt->bindParam(':resident_nationality', $resident->resident_nationality);
        $stmt->bindParam(':resident_religion', $resident->resident_religion);
        $stmt->bindParam(':resident_weight', $resident->resident_weight);
        $stmt->bindParam(':resident_height', $resident->resident_height);
        $stmt->bindParam(':resident_father_name', $resident->resident_father_name);
        $stmt->bindParam(':resident_mother_name', $resident->resident_mother_name);
        $stmt->bindParam(':resident_houseno', $resident->resident_houseno);


        $stmt->bindParam(':resident_gender', $resident->resident_gender);
        $stmt->bindParam(':resident_image', $resident->resident_image);
        $stmt->bindParam(':resident_type', $resident->resident_type);
        $stmt->bindParam(':resident_civilstatus', $resident->resident_civilstatus);
        $stmt->bindParam(':resident_purok', $resident->resident_purok);

        if ($stmt->execute()) {

            $response = [
                "status" => "success",
                "message" => "resident updated successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "resident update failed"
            ];
        }

        echo json_encode($response);
        break;

    case "DELETE":
        $resident = json_decode(file_get_contents('php://input'));
        $sql = "DELETE FROM resident WHERE resident_id = :resident_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':resident_id', $resident->resident_id);

        if ($stmt->execute()) {
            $response = [
                "status" => "success",
                "message" => "resident deleted successfully"
            ];
        } else {
            $response = [
                "status" => "error",
                "message" => "resident delete failed"
            ];
        }

        echo json_encode($response);
        break;
}
