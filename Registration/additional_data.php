<?php
require_once '..\backend\db_connection.php';


// da msh shghal msh 3arf leh fa ha3ml query agrb :D
// $passengerID = isset($_GET['passengerID']) ? $_GET['passengerID'] : null;
// echo($_GET['passengerID']);
// Check if the passenger ID is not provided
// if ($passengerID === null) {
//     echo json_encode(['success' => false, 'error' => 'Passenger ID not provided']);
//     exit;
// }

$getPassengerIDQuery = "SELECT passenger_ID FROM passenger ORDER BY passenger_ID DESC LIMIT 1";
$getPassengerIDResult = mysqli_query($conn, $getPassengerIDQuery);

// Check if the query was successful
if ($getPassengerIDResult) {
    $row = mysqli_fetch_assoc($getPassengerIDResult);
    $passengerID = $row['passenger_ID'];
} else {
    echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    exit;
}

if ($passengerID === null) {
    echo json_encode(['success' => false, 'error' => 'Passenger ID not provided']);
    exit;
}

// Check if the passenger ID is not provided

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $userType = $_POST['userType'];
    $passengerImage = $_FILES['passengerImage'];
    $passportImage = $_FILES['passportImage'];
    $accountBalance = $_POST['accountBalance'];

    // Check user type (assuming 'customer' for passengers)
    if ($userType === 'customer') {
        // Handle file upload for passenger image
        $targetDir = "uploads/";
        $passengerImageName = basename($passengerImage["name"]);
        $passengerImagePath = $targetDir . $passengerImageName;

        if (move_uploaded_file($passengerImage["tmp_name"], $passengerImagePath)) {
            // Update the passenger record with the passenger image path
            $updatePassengerImageQuery = "UPDATE passenger SET passengerImage = '$passengerImagePath' WHERE passenger_ID = $passengerID";
            $updatePassengerImageResult = mysqli_query($conn, $updatePassengerImageQuery);

            // Check if the update was successful
            if (!$updatePassengerImageResult) {
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Passenger image upload failed.']);
            exit;
        }

        // Handle file upload for passport image
        $passportImageName = basename($passportImage["name"]);
        $passportImagePath = $targetDir . $passportImageName;

        if (move_uploaded_file($passportImage["tmp_name"], $passportImagePath)) {
            // Update the passenger record with the passport image path
            $updatePassportImageQuery = "UPDATE passenger SET pasportImage = '$passportImagePath' WHERE passenger_ID = $passengerID";
            $updatePassportImageResult = mysqli_query($conn, $updatePassportImageQuery);

            // Check if the update was successful
            if (!$updatePassportImageResult) {
                echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Passport image upload failed.']);
            exit;
        }

        // Update the passenger record with the account balance
        $updateBalanceQuery = "UPDATE passenger SET passengerBalance = $accountBalance WHERE passenger_ID = $passengerID";
        $updateBalanceResult = mysqli_query($conn, $updateBalanceQuery);

        // Check if the update was successful
        if (!$updateBalanceResult) {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
            exit;
        }

        // Redirect to another page or display a success message
        header('Location: ../login/login.html');
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid user type']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid Request']);
    exit;
}

?>
