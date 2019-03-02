<?php
//  DB Connection Variables
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";

//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed: ");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1; URL=./usersTable.php">
    <title>Users table</title>
    <style>
        body{ margin: 0; padding: 2%; border: 0; background:black; background-size: 100%; }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<?php

    $query = "Select * from user_info";
    $result = mysqli_query($con, $query) or die ("query is failed" . mysqli_error($con));
    echo "<table border='1'  align='center' bgcolor= white>";
    echo "<tr><th>RegistrationId</th><th>Name</th><th>Address</th><th>Date</th><th>Email</th><th>PackageId</th><th>GroupId</th><th>Password</th></tr>";
    while (($row = mysqli_fetch_row($result)) == true) {
        echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td><td>$row[7]</td></tr>";
    }

?>

<script>

</script>
</body>
</html>
