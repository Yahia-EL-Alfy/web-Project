<?php
session_start();
require_once '../backend/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $flightName = $_POST['name'];
    // $flightID = $_POST['id'];
    $itinerary = $_POST['itinerary'];
    $date= $_POST['departureDate'];
    $fees = $_POST['fees'];
    $numPassengers = $_POST['passengers'];
    $takeoffTime = $_POST['takeoff'];
    $landingTime = $_POST['landing'];

    // Assuming the user ID is stored in the session
    $companyID = $_SESSION['user_id'];

    // Insert data into the flights table
    $insertFlightQuery = "INSERT INTO `flights` (flightName, Itinerary, fees, maxPassegers, startTime, endTime, company_id, `date`)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $insertFlightStmt = mysqli_prepare($conn, $insertFlightQuery);

    // Assuming maxPassegers is an integer, adjust the 'ssdissis' accordingly
    mysqli_stmt_bind_param($insertFlightStmt, 'ssdissis', $flightName, $itinerary, $fees, $numPassengers, $takeoffTime, $landingTime, $companyID, $date);

    if (mysqli_stmt_execute($insertFlightStmt)) {
        // Flight added successfully
        // Redirect to company home page
        header("Location: ../company home/company_home.php");
        exit(); // Ensure that no other code is executed after the redirect
    } else {
        // Error in adding the flight
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }

    // Close the statement
    mysqli_stmt_close($insertFlightStmt);

} else {
    // Invalid request method
    echo json_encode(['success' => false, 'error' => 'Invalid Request']);
}
?>
