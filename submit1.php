<?php
$servername = "localhost"; // Change this if using a different server
$username = "root"; // Database username
$password = ""; // Database password
$database = "vacation_booking"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input to prevent SQL Injection
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $destination = htmlspecialchars($_POST["destination"]);
    $contact = htmlspecialchars($_POST["contact"]);
    $travel_date = htmlspecialchars($_POST["date"]);

    // Prepare statement to insert data
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, destination, contact, travel_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $destination, $contact, $travel_date);

    if ($stmt->execute()) {
        // Send Thank You email
        $subject = "Thank You for Your Vacation Booking!";
        $message = "Hello $name,\n\nThank you for booking your vacation with us! We have received your request for a trip to $destination on $travel_date.\n\nWe will get back to you soon!\n\nBest Regards,\nVacation Booking Team";
        $headers = "From: no-reply@vacationbooking.com"; // Change this to a valid sender email

        mail($email, $subject, $message, $headers);

        // Redirect to Thank You Page
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>





<!-- 

CREATE DATABASE vacation_booking;

USE vacation_booking;

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    travel_date DATE NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->
