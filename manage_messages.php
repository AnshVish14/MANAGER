<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: AdminLogin.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch messages from the database
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Messages</title>
    <style>
        body{
            background: linear-gradient(150deg, #979696c8, #e4e3e3, rgb(151, 147, 147));
            color: #000000;
            padding-top: 30px;
            overflow-x: hidden;
        }
        table {
            width: 100%;
            font-size:20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 2px gray;
            border-style:ridge;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }
        h1 {
            font-size:35px;
            text-align:center;
            text-decoration:underline;
            text-shadow:2px 12px 2px gray;
        }
        tr:nth-child(even) {
            background-color: gray;
        }
    </style>
</head>
<body>
    <h1>Messages from Users</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['message']); ?></td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
