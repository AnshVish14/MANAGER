<?php
session_start();
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

$userId = $_SESSION['name'];  // Assuming user ID is stored in the session

// Fetch all job applications for the logged-in user
$stmt = $conn->prepare("SELECT a.job_id, a.cover_letter, a.applied_at, j.title 
                        FROM applications a 
                        JOIN jobs j ON a.job_id = j.id 
                        WHERE a.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Loop through each application
    while ($row = $result->fetch_assoc()) {
        $jobTitle = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
        $coverLetter = htmlspecialchars($row['cover_letter'], ENT_QUOTES, 'UTF-8');
        $appliedAt = htmlspecialchars($row['applied_at'], ENT_QUOTES, 'UTF-8');
        
        
    }
} else {
    echo "<p>No applications found!</p>";
}

$stmt->close();
$conn->close();
?>
<html>
<head>
    <style>
        body{
            background: linear-gradient(150deg, #979696c8, #e4e3e3, rgb(151, 147, 147));
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            height: 75vh;
            margin: -20px 0 50px;
        }
        h1{
            font-size:35px;
            text-decoration:underline;
        }
        p{
            margin:1px;
            font-size:20px;
        }
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 1px 0 0 0;
            padding:30px;
            font-size:22px;
            box-shadow:2px 8px 10px 0 gray;
        }

        table, th, td {
            text-align:center;
            border: 3px ;
            border-color:gray;
            border-style:ridge;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }
        th{
            background:linear-gradient(154deg,black,#101);
            color:whitesmoke;
        }
        td{
            font-size:25px;
        }
    </style>
</head>
<body>
    <h1>Applied Job</h1>
    <p>This may help you to see the job you applied</p><br>
    <table>
        <th>Job Title:</th>
        <th>Applicant Name:</th>
        <th>Applied Date/Time:</th>
    <tr>
        <td><?php echo htmlspecialchars($jobTitle, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($coverLetter, ENT_QUOTES, 'UTF-8' )?></td>
        <td><?php echo htmlspecialchars($appliedAt, ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    </table>
</body>
</html>
