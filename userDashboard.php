<?php
session_start();

$userCredential = $_SESSION['userIdent'];

//  DB Connection Variables
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";

//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed: ");

$hiddenClass = "";
$showClass = "hidden";
$htmlOutput = "";


if (is_numeric($userCredential)){
    $query = "SELECT GroupId FROM user_info WHERE RegistrationId = '$userCredential' ";
    $result = mysqli_query($con, $query) or die("query is failed" . mysqli_error($con));
    $row = mysqli_fetch_row($result);
    if (empty($row[0])){ $htmlOutput = "<p><b>Sorry, no group has been assigned to you yet. Come back tomorrow!</b></p><br><button class=\"button\" onclick=\"location.href = 'index.php';\">Go back</button>"; }
    else{ $htmlOutput = getGroupInfo($con, $userCredential); }

}else{
    $query = "SELECT GroupId, RegistrationId FROM user_info WHERE Email = '$userCredential' ";
    $result = mysqli_query($con, $query) or die("query is failed" . mysqli_error($con));
    $row = mysqli_fetch_row($result);
    if (empty($row[0])){ $htmlOutput = "<p><b>Sorry, no group has been assigned to you yet. Come back tomorrow!</b></p><br><button class=\"button\" onclick=\"location.href = 'index.php';\">Go back</button>"; }
    else{ $htmlOutput = getGroupInfo($con, $row[1]); }
}

function getGroupInfo($con, $userId){
    $output = "";

    $query = "SELECT u.GroupId, g.Date, v.PackageName FROM user_info u
                JOIN group_info g ON g.GroupId = u.GroupId
                JOIN vacationplan v ON u.PackageId = v.PackageId
                WHERE RegistrationId = '$userId'";

    $result = mysqli_query($con, $query) or die("query is failed" . mysqli_error($con));
    $row = mysqli_fetch_row($result);

    $groupId = $row[0];

    $output = "<p><b>Group ID: </b>" . $groupId . " <b>Travel Date: </b>" . $row[1] . " <b>Destination: </b>" . $row[2] . "</p>";
    $output .= "<p><b>Group Members: </b></p>";

    $query = "SELECT Name, Email FROM user_info 
                WHERE GroupId = '$groupId'";
    $result = mysqli_query($con, $query) or die("query is failed" . mysqli_error($con));
    while ($row = mysqli_fetch_row($result)) {
        $output .= "<p class=\"travelersList\"> $row[0] ($row[1])<br>";
    }

    $output .= "<br><button class=\"button\" onclick=\"location.href = 'index.php';\">Go back</button>";

    return $output;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XYZ Travel Plan - Login</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            border: 0;
            background: url("./img/airplane.jpg");
            background-size: 100% ;
        }
        h1,h2,h3,h4,p{
            font-family: Arial, Helvetica, sans-serif;
        }
        h1{
            font-size: 50px;
        }
        input[type='submit']{
            margin-left: 30%;
            margin-top: 5%;
            font-size: 20px;
            background-color: white;
            border: 1px solid darkgreen;
        }
        input[type='submit']:hover{
            cursor: pointer;
            color: white;
            background-color: #4CAF50;;
            border: 1px solid darkgreen
            transition-duration: 0.3s;
        }
        #btn-signUp{
            margin-left: 2%;
        }

        #btn-seeTravelPlans{
            border: none;
            background-color: white;
            margin-left: 37%;
            font-size: 10px;
        }

        #btn-seeTravelPlans:hover{
            color: blue;
        }
        main{
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            width: 40%;
            background-color: white;
            border-radius: 10px;
        }
        main:hover{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .button{ font-size: 20px; background-color: white; border: 1px solid darkgreen; }
        .button:hover{ cursor: pointer; color: white; background-color: #4CAF50; border: 1px solid darkgreen transition-duration: 0.3s; }

        .travelersList{text-indent: 1em; }
    </style>
</head>
<body>

<div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
    <h1 style="text-align: center; margin-top: 0; color: white;">XYZ Travel Plan</h1>
</div>
<main>

    <h3 style="font-size: 30px">Hello, traveller!</h3>

    <div class="<?php print $showClass?>">
        <?php print $htmlOutput; ?>
    </div>

</main>
</body>
</html>