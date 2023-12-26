<?php

// $con=mysql_connect("localhost","root","");

// mysql_select_db("imagine_flight");
require_once '..\backend\db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $tel = trim($_POST['tel']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirmPassword = password_hash($_POST['confirmPassword'], PASSWORD_DEFAULT);
    $userType = $_POST['userType']; // Retrieve user type

    // Check user type and insert data into the appropriate table
    if ($userType === 'customer') {
        // Insert into Passengers table
        $query = "INSERT INTO passenger (PassengerName, PassengerMail, phone, PassengerPassword)
                  VALUES ('$username', '$email', '$tel', '$password')";
    } elseif ($userType === 'company') {
        // Insert into Companies table
        $query = "INSERT INTO company (companyName, companyMail, companyPhone, companyPassword)
                  VALUES ('$username', '$email', '$tel', '$password')";
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid user type']);
        exit;
    }

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        header('Location: ../login/login.html');
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid Request']);
}


// mysql_close($con);

?>
