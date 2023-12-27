<?php
session_start();

// Check if the passenger is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle accordingly
    header("Location: login.php");
    exit();
}

// Replace this with your actual database connection code
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "imagine_flight";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch passenger details from the database using the session passenger_id
$passengerId = $_SESSION['user_id'];

$sql = "SELECT * FROM passenger WHERE passenger_ID = $passengerId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $passengerDetails = $result->fetch_assoc();
} else {
    // Handle the case where the passenger is not found
    echo "Passenger not found!";
    exit();
}

// Close the database connection
$conn->close();

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
      <img src='../Registration/<?php echo $passengerDetails["passengerImage"]; ?>' alt="Passenger Avatar" style="border-radius: 50%;">
      
      <h1>Welcome, <?php echo $passengerDetails['passengerName']; ?></h1>
    </header>

    <nav>
      <ul>
        <li><a href="#">Current Flights</a></li>
        <li><a href="#">Completed Flights</a></li>
        <li><a href="#">Search Flights</a></li>
        <li><a href="passenger_profile.php">Profile</a></li>
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
    </section>
  </div>

  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <!-- Include your script.js file -->
  <script src="script.js"></script>
</body>
</html>



