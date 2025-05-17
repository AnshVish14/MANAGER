<?php
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['name'])) {
    header("Location: Login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "job portal";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Using prepared statement to prevent SQL injection
$id = $_SESSION['name'];
$stmt = $conn->prepare("SELECT * FROM job WHERE name = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userName = $row['name'];
    $age = $row['age'];
} else {
    echo "User not found!";
}

$stmt->close();
$conn->close();
?>
<html>
<head>
    <style>
        body{
            background: linear-gradient(140deg, #979696c8, #e4e3e3, rgb(151, 147, 147));
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 90vh;
            margin: -20px 0 50px; 
          
        }
        h1{
            height:30px;
            text-align:center;
            text-decoration:underline;
            font-size:50px;
            font-family:'Times New Roman', Times, serif;
              
        }
        .item{
            text-decoration:underline;
            justify-content:center;
            font-size:40px;
            text-align:left;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;

        }
        footer{
            height:10px;
            font-size:20px;
            margin:10px;
            color:black;
        }
        fieldset{
            border-style:ridge;
            border-color:gray;
            margin:2px;
            font-size:30px;
            padding:21px;
            padding-left:80px;
            padding-right:80px;
            border-width:25px;
            background: linear-gradient(155deg, #979696c8, #e4e3e3, rgb(151, 147, 140), #e4e3e3);

        }
        a{
            color:black;
            text-decoration:none;
            cursor:pointer;

        }
    </style>
</head>
<body><br><br>
<h1>User Profile</h1>
<br><fieldset>
<div> 
<p class="item">Name: <?php echo htmlspecialchars($userName, ENT_QUOTES, 'UTF-8'); ?></p>
<p class="item">Age.: <?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?></p>
</div><br><br><br>

</fieldset>
<footer>
&copy; 2024 Job Portal.Thanks for visiting.
</footer>
</body>
</html>
