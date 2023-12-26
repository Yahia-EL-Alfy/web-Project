<?php
session_start();

require_once '../backend/db_connection.php';


$userID = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    // User not authenticated, redirect to login page
    header('Location: ../login/login.html');
    echo("<script>alert('hello')</script>");
    exit;
}


?>

<?php 
// echo($userID);
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.css">
  <title>Passenger Home</title>
</head>
<body>

  <div class="container">
    <header>
      <img src="../panda.png" alt="Passenger Avatar">
      
      <h1>Welcome, Passenger Name!</h1>
    </header>

    <nav>
      <ul>
        <li><a href="#">Current Flights</a></li>
        <li><a href="#">Completed Flights</a></li>
        <li><a href="#">Search Flights</a></li>
        <li><a href="passenger_profile.html">Profile</a></li>
      </ul>
    </nav>

    <section id="flightsList">
      <!-- Display flights as a list -->
      <h2>Current Flights</h2>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Itinerary</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Flight Row -->
          <tr class="flightRow" data-flight-id="1">
            <td>1</td>
            <td>Flight 1</td>
            <td>Itinerary 1</td>
          </tr>
          <!-- Add more rows dynamically from your database -->
        </tbody>
      </table>

      <h2>Completed Flights</h2>
      <table>
        <!-- Add completed flights dynamically -->
      </table>
    </section>
  </div>

  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- Include your script.js file -->
  <script src="script.js"></script>
</body>
</html>



