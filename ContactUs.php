<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job portal";  // Fixed the database name to follow standard naming conventions

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$responseMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize the form data
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Validate the form data
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare statement to insert data into the database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $message);
        
            if ($stmt->execute()) {
                echo "<script>alert('Thank you for reaching out. Your message has been submitted.'); window.location.href='a1.html';</script>";
            } else {
                echo "<script>alert('Error: Unable to submit your message. Please try again later.'); window.location.href='contactUs.html';</script>";
            }
            $stmt->close();
        } else {
            echo "<sxript> alert('Error preparing the statement.'); window.location.href='contactUs.htm';</script>";
        }
    } else {
        echo "<script> alert('Please fill in all fields.');window.location.href='contactUs.html';";
    }
}

$conn->close();
?>