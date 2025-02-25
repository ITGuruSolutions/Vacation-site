<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost'; // Replace with actual Hostinger MySQL hostname
$dbname = 'u608171135_test';
$username = 'u608171135_testuser';
$password = 'Ue4:w3qU';


// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Print POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST)) {
        die("No POST data received. Check form method and enctype.");
    }
    
    print_r($_POST); // Debugging: Remove after testing

    // Ensure all expected fields exist
    if (isset($_POST['form_type'], $_POST['fullName'], $_POST['emailAddress'], $_POST['contactNumber'], $_POST['tripDestination'], $_POST['travelDate'])) {

        $formType = $_POST['form_type'];
        $fullName = $_POST['fullName'];
        $emailAddress = $_POST['emailAddress'];
        $contactNumber = $_POST['contactNumber'];
        $tripDestination = $_POST['tripDestination'];
        $travelDate = $_POST['travelDate'];

        // Prepare SQL statement to prevent SQL Injection
        $stmt = $conn->prepare("INSERT INTO bookings (form_type, full_name, email_address, contact_number, trip_destination, travel_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $formType, $fullName, $emailAddress, $contactNumber, $tripDestination, $travelDate);

        if ($stmt->execute()) {
            // Redirect to thank you page
            header("Location: Thankyou.html");
            exit();
        } else {
            echo "<script>alert('Error in booking. Please try again.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        die("Missing form fields. Check your form input names.");
    }
}

$conn->close();
?>
