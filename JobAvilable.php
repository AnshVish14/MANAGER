<?php

session_start();

if (!isset($_SESSION['name'])) {
    header('Location: Login.php');  // Redirect to login if the user is not logged in
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

// Fetch available jobs from the database
$jobs = $conn->query("SELECT * FROM jobs");

// Handle job application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];  // Assuming user's ID is stored in session
    $jobId = $_POST['job_id'];
    $coverLetter = $conn->real_escape_string($_POST['cover_letter']);

    // Check if the user has already applied for this job
    $checkApplication = $conn->query("SELECT * FROM applications WHERE user_id='$userId' AND job_id='$jobId'");
    
    if ($checkApplication->num_rows == 0) {
        // Insert application into the database
        $applyQuery = "INSERT INTO applications (user_id, job_id, cover_letter) VALUES ('$userId', '$jobId', '$coverLetter')";

        if ($conn->query($applyQuery) === TRUE) {
            echo "<script>alert('Job application submitted successfully.'); window.location.href='jobAvailable.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('You have already applied for this job.'); window.location.href='JobAvilable.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Available Jobs</title>
    <style>
        body{
            background: linear-gradient(150deg, #979696c8, #e4e3e3, rgb(151, 147, 147));
        }
        h1{
            font-size:45px;
            font-weight:600;
            text-align:center;
            text-decoration:underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2px 0  0;
        }

        table, th, td {
            border: 2px solid gray;
        }

        th, td {
            padding: 17px;
            text-align:left;
        }

        th {
           color:white;
           background:black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .apply-btn {
            background-color:gray;
            color:white;
            padding: 10px 10px;
            text-decoration: none;
            border-radius: 4px;
        }

        .apply-btn:hover {
            background-color:whiitesmoke;
        }

        form {
            margin: 1px 0;
        }

        form textarea {
            width: 85%;
            color:black;
            padding: 4px;
            border: none;
            border-radius: 4px;
            resize: vertical;
            background:whiitesmoke;
        }

        .submit-btn {
            background-color:gray;
            color: white;
            padding: 10px 35px;
            border: none;
            border-radius:10px;
            cursor: pointer;
            margin:3px;
            border-radius: 4px;
        }

        .submit-btn:hover {
            background-color: black;
        }
    </style>
</head>
<body>

    <h1>Available Jobs</h1>

    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Description</th>
                <th>Company</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($job = $jobs->fetch_assoc()): ?>
            <tr>
                <td><?php echo $job['title']; ?></td>
                <td><?php echo $job['description']; ?></td>
                <td><?php echo $job['company']; ?></td>
                <td>
                    <center><form method="POST" action="JobAvilable.php">
                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                        <textarea name="cover_letter" placeholder="Enter your cover letter" required></textarea>
                        <button type="submit" class="submit-btn">Apply</button>
                    </form></center>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
