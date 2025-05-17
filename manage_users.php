<?php
// Start session and check if admin is logged in
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

// Handle deletion
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];  // Get the user ID from the URL
    if ($conn->query("DELETE FROM job WHERE name='$userId'") === TRUE) {  // Use 'id' for deletion
        echo "<script>alert('User deleted successfully.'); window.location.href='manage_users.php';</script>";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Fetch users
$users = $conn->query("SELECT * FROM job");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body{
            font-size:22px;
            font-weight:600;
            display:grid;
            padding-top: 60px;
            overflow-x: hidden;
            background: linear-gradient(150deg, #979696c8, #e4e3e3, rgb(151, 147, 147));
            font-family:'Franklin Gothic Medium',  Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2px 0 0 0;
        }

        table, th, td {
            text-align:center;
            border: 2px ;
            border-color:gray;
            border-style:ridge;
        }

        th, td {
            padding: 20px;
            text-align: center;
        }

        th {
            background:black;

            color: white;
        }

        tr:nth-child(even) {
            background-color: gray;
        }

        .action-btn {
            text-align:center;
            justify-content:center;
            padding: 15px 40px;
            color: white;
            background-color: #5cb85c;
            border:none;
            cursor: pointer;
            text-decoration: none;
            z-index: 1;
        }
        .action-btn:hover{
            color:black;
            border-radius:10px;
            background: linear-gradient(45deg,rgb(148, 146, 146),rgb(222, 222, 227),rgb(113, 110, 110));

        }

        .delete-btn {
            background-color: #d5534f;
        }
        h1{
            line-height:10%;
            text-align:center;
            justify-content:center;
            margin:2%;
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            letter-spacing:1rcm;
            text-decoration:underline;

        }
    </style>
</head>
<body>

    <h1>Manage Users</h1>

    <table>
        <thead>
            <tr>
        <!-- Adding ID column -->
                <th>Name</th>
                <th>Age</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
             <!-- Displaying the user ID -->
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['age']; ?></td>
                <td><?php echo $user['email'];?></td>
                <td>
                    <a href="manage_users.php?delete=<?php echo $user['name']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    // Close the connection
    $conn->close();
    ?>

</body>
</html>
