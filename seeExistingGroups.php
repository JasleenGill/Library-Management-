<?php
/**
 * Created by PhpStorm.
 * User: humbertorovina
 * Date: 2018-12-09
 * Time: 8:05 AM
 */
//  Connect to database
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";
$userName="";
$password="";


//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed.");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XYZ Travel Plan - Existing Groups</title>
    <style>
        body{ margin: 0; padding: 0; border: 0; background: url("./img/airplane.jpg"); background-size: 100%; }
        h1,h2,h3,h4,p{ font-family: Arial, Helvetica, sans-serif; }
        h1{ font-size: 50px; }
        label{ font-family: Arial, Helvetica, sans-serif; }
        .button{ font-size: 20px; background-color: white; border: 1px solid darkgreen; transition-duration: 0.3s; }
        .button:hover{ cursor: pointer; color: white; background-color: #4CAF50; border: 1px solid darkgreen; }
        .subButton{ font-size: 12px; background-color: white; border: 1px solid black;  border-radius: 5px; transition-duration: 0.3s;}
        .subButton:hover{ cursor: pointer; color: white; background-color: black; border: 1px solid darkgreen;  }
        #btn-signUp{ margin-left: 2%; }
        #btn-seeTravelPlans{ border: none; background-color: white; margin-left: 37%; font-size: 10px; }
        #btn-seeTravelPlans:hover{ color: blue; }
        .sections{ width: 50%; margin: 0 auto; margin-top: 50px; padding: 20px; background-color: white; border-radius: 10px; }
        .sections:hover{ box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); }
        .submitDiv{ width: 30%; }
        .groupsDiv{ margin-bottom: 5%; width: 70%; }
        .hidden{ display: none; }
        .show{ display: block }
        .groups{ box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); width: 95%; padding:5px; margin: 10px; border-radius: 5px; border: 1px solid grey; background-color: white; }
    </style>
</head>
<body>
<div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
    <a style="text-decoration: none;"href="./index.php">
        <h1 style="text-align: center; margin-top: 0; color: white;">Existing Groups</h1>
    </a>
</div>
<main style="margin-bottom: 5%;" class="sections">

    <?php
        $groupIdList = [];

        $query = "SELECT GroupId FROM group_info";
        $result = mysqli_query($con, $query) or die ("query failed" . mysqli_error($con));

        if (mysqli_num_rows($result) == 0){
            echo "<p>No groups created</p>";
        }else{
            while ($row = mysqli_fetch_row($result)) {
                $groupIdList[] = $row[0];
            }

            foreach ($groupIdList as $groupId){
                $query = "SELECT u.Name, u.Email, u.Date, v.PackageName, g.GroupSize FROM user_info u
                      JOIN vacationplan v on u.PackageId = v.PackageId
                      JOIN group_info g on g.GroupId = u.GroupId
                      WHERE u.GroupId = '$groupId'";
                $result = mysqli_query($con, $query) or die ("query failed" . mysqli_error($con));
                $row = mysqli_fetch_row($result);

                $groupSize = mysqli_num_rows($result);
                $groupCapacity = $row[4];
                $emptySpots = $groupCapacity - $groupSize;


                echo "<div class=\"groups\">  <p><b>Group ID: </b> $groupId <b> Date: </b> $row[2] <b> Destiny: </b> $row[3]</p>";

                if($emptySpots > 0){ echo "<p style=\"color:green\"><b> Empty Spot(s): " . $emptySpots . "</b></p>"; }
                else{ echo "<p style=\"color:red\"><b> Empty Spot(s): " . $emptySpots . "</b></p>"; }

                do{
                    echo "<p style=\"text-indent: 1em\">$row[0] ($row[1])</p>";
                }while ($row = mysqli_fetch_row($result));
                echo "</div>";
            }
        }
    ?>

    <button style="margin-left: 42%" class="button" onclick="location.href = 'index.php';">Go back</button>


</main>
</body>
</html>