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

// Handle job deletion
if (isset($_GET['delete'])) {
    $jobId = $_GET['delete'];
    if ($conn->query("DELETE FROM jobs WHERE id='$jobId'") === TRUE) {
        echo "<script>alert('Job deleted successfully.'); window.location.href='manage_jobs.php';</script>";
    } else {
        echo "Error deleting job: " . $conn->error;
    }
}

// Fetch jobs from the database
$jobs = $conn->query("SELECT * FROM jobs");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Jobs</title>
    <style>
        body{
            background: linear-gradient(150deg, #979696c8, #e4e3e3, rgb(151, 147, 147));
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-btn {
            padding: 5px 10px;
            color: white;
            background-color: #5cb85c;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn {
            background-color: #d9534f;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }

        .edit-btn {
            background-color: #5bc0de;
        }

        .edit-btn:hover {
            background-color: #31b0d5;
        }

        .add-btn {
            background-color: #0275d8;
            color: black;
            background:whitesmoke;
            padding: 10px 50px;
            text-decoration: none;
            margin-bottom: 1px;
            display:inline-block;
        }

        .add-btn:hover {
            color:whitesmoke;
            border-radius:10px;
            background-color:gray;
        }
        h1{
            font-size:35px;
            text-align:center;
            text-decoration:underline;
            text-shadow:2px 12px 2px gray;
        }
    </style>
</head>
<body>

    <h1><center>Manage Jobs</center></h1>

    <a href="add_job.php" class="add-btn">Add New Jobs</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Company</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($job = $jobs->fetch_assoc()):?>
            <tr>
                <td><?php echo $job['id']; ?></td>
                <td><?php echo $job['title']; ?></td>
                <td><?php echo $job['description']; ?></td>
                <td><?php echo $job['company']; ?></td>
                <td>
                    <a href="edit_jobs.php?id=<?php echo $job['id']; ?>" class="action-btn edit-btn">Edit</a>
                    <a href="manage_jobs.php?delete=<?php echo $job['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this job?')">Delete</a>
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
