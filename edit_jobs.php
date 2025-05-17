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

// Check if job ID is provided in the URL
if (!isset($_GET['id'])) {
    echo "<script>alert('No job ID provided.'); window.location.href='manage_jobs.php';</script>";
    exit();
}

$jobId = $_GET['id'];

// Fetch job details from the database
$jobQuery = $conn->query("SELECT * FROM jobs WHERE id='$jobId'");

if ($jobQuery->num_rows == 1) {
    $job = $jobQuery->fetch_assoc();
} else {
    echo "<script>alert('Job not found.'); window.location.href='manage_jobs.php';</script>";
    exit();
}

// Handle form submission for updating job details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $company = $conn->real_escape_string($_POST['company']);
    
    // Update query
    $updateQuery = "UPDATE jobs SET title='$title', description='$description', company='$company' WHERE id='$jobId'";
    
    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Job updated successfully.'); window.location.href='manage_jobs.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <style>
        h1{
            font-size:35px;
            text-align:center;
            text-decoration:underline;
        }
        body{
            background: linear-gradient(135deg, #535860, #adb0b8,rgb(96, 91, 91));
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            height: 100vh;
            
        }
        form {
            font-size:25px;
            background:linear-gradient( gray,#868080,#b1acac);
            display: flex;
            flex-direction: column;
            padding: 20px 35px;
            width:60vh;
            height: 100%;
        }

        form label {
            display: block;
            margin-bottom: 3px;
            font-weight: bold;
            margin-left:15px;
            text-decoration:underline;
        }

        form input, form textarea {
            width: 86%;
            background:whitesmoke;
            margin-left:15px;
            padding: 10px;
            justify-content:center;
            align-items:center;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            font-size:16px;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        .submit-btn {
            background-color: black;
            color: whitesmoke;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        .submit-btn:hover {
            background-color:gray;
            color:black;
        }

        .back-btn {
            background-color: red;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #025aa5;
        }
    </style>
</head>
<body>

    <h1>Edit Job</h1>

    <form method="POST">
        <label for="title">Job Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $job['title']; ?>" required>

        <label for="description">Job Description:</label>
        <textarea id="description" name="description" required><?php echo $job['description']; ?></textarea>

        <label for="company">Company:</label>
        <input type="text" id="company" name="company" value="<?php echo $job['company']; ?>" required>

        <input type="submit" value="Update Job" class="submit-btn">
    </form>

    <a href="manage_jobs.php" class="back-btn">Back to Manage Jobs</a>

</body>
</html>
