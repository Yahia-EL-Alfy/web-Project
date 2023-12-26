<?php
require_once '../backend/db_connection.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Query to check if the user exists in the passenger table
    $passengerQuery = "SELECT * FROM passenger WHERE PassengerMail = ?";
    $passengerStmt = mysqli_prepare($conn, $passengerQuery);
    mysqli_stmt_bind_param($passengerStmt, 's', $email);
    mysqli_stmt_execute($passengerStmt);

    $passengerResult = mysqli_stmt_get_result($passengerStmt);

    if ($passengerResult && mysqli_num_rows($passengerResult) > 0) {
        // User found in the passenger table, verify password
        $passengerUser = mysqli_fetch_assoc($passengerResult);
        if (password_verify($password, $passengerUser['passengerPassword'])) {
            // Store Passenger_ID in a session variable
            session_start();
            $_SESSION['user_id'] = $passengerUser['PassengerID'];

            // Redirect to passenger home
            header('Location: ../passenger home/home.html');
            exit;
            
        } else {
            // Incorrect password
            echo json_encode(['success' => false, 'error' => 'Incorrect password']);
        }
    } else {
        // User not found in the passenger table, check the company table
        $companyQuery = "SELECT * FROM company WHERE companyMail = ?";
        $companyStmt = mysqli_prepare($conn, $companyQuery);
        mysqli_stmt_bind_param($companyStmt, 's', $email);
        mysqli_stmt_execute($companyStmt);

        $companyResult = mysqli_stmt_get_result($companyStmt);

        if ($companyResult && mysqli_num_rows($companyResult) > 0) {
            // User found in the company table, verify password
            $companyUser = mysqli_fetch_assoc($companyResult);
            if (password_verify($password, $companyUser['companyPassword'])) {
                // Store Company_ID in a session variable
                session_start();
                $_SESSION['user_id'] = $companyUser['CompanyID'];

                // Redirect to company home
                header('Location: ../company home/company_home.html');
                exit;
            } else {
                // Incorrect password
                echo json_encode(['success' => false, 'error' => 'Incorrect password']);
            }
        } else {
            // User not found in both tables
            echo json_encode(['success' => false, 'error' => 'User not found']);
        }
    }

    mysqli_stmt_close($passengerStmt);
    mysqli_stmt_close($companyStmt);
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid Request']);
}
?>
