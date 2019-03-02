<?php
session_start();
class Client {


    var $id;
    var $name;
    var $destiny;
    var $date;
    var $email;

    var $groupId;

    public function __construct($id, $name, $date, $email, $destiny) {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->email = $email;
        $this->destiny = $destiny;
    }

    //getter and setter for group id
    public function setGroupId($groupId){
        $this->groupId = $groupId;
    }

    public function getGroupId(){
        return $this->groupId;
    }
}

//  DB Connection Variables
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";

//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed: ");

// Html supportive variables
$generatedGroups = "";
$message = "";
$messageStyle = "color: red";
$hiddenClass = "";
$showClass = "hidden";

$groupsFinalList;


if (isset($_POST['groupLimitGenerate'])){
    if (empty($_POST['groupSize'])){
        $message = "Please, fill the group size.";
    }
    else{
        $groupSize = test_input($_POST['groupSize']);

        list($htmlOutput, $groupsList) = generateGroups($con, $groupSize);
        $generatedGroups = $htmlOutput;

        $_SESSION["groupsList"] = $groupsList;

        $showClass = "";
        $hiddenClass = "hidden";
    }
}

if (isset($_POST['autoGenerate'])){

    list($htmlOutput, $groupsList) = generateGroups($con, 0);
    $generatedGroups = $htmlOutput;

    $_SESSION["groupsList"] = $groupsList;

    $showClass = "";
    $hiddenClass = "hidden";
}

function generateGroups($con, $groupSize){
    $output = "";

    // List initialization
    $finalGroups = [];
    $destinies = [];
    $dateGroups = [];

    $query = "SELECT u.RegistrationId, u.Name, u.Date, u.Email, v.PackageName, u.GroupId FROM user_info u 
              JOIN vacationplan v on u.PackageId = v.PackageId";

    $result = mysqli_query($con, $query) or die ("query failed" . mysqli_error($con));
    $orphanCount = 0;
    while ($row = mysqli_fetch_row($result)) {
        if ($row[1] != "Admin" && empty($row[5])){
            if (!in_array($row[4], $destinies)) { $destinies[] = $row[4]; }
            $dateGroups[$row[2]][] = new Client($row[0],$row[1], $row[2], $row[3], $row[4]);
            $orphanCount++;
        }
    }

    if ($orphanCount == 0){
        return array("<p>All users have a group.</p><br><button style=\"margin-left: 38%;\" onclick=\"location.href = 'formGroups.php';\"class=\"button\">Try Again</button>", null);
    }

    if ($groupSize > 0){

        foreach ($destinies as $destiny){
            foreach ($dateGroups as $dateGroup){
                $userList = [];
                foreach ($dateGroup as $user){
                    if ($user->{'destiny'} == $destiny){

                        if (sizeof($userList) == $groupSize){
                            $finalGroups[] = $userList;
                            $userList = [];
                        }
                        $userList[] = $user;
                    }
                }
                if (!empty($userList)){ $finalGroups[] = $userList; }
            }
        }

    }else{
        foreach ($destinies as $destiny){
            foreach ($dateGroups as $dateGroup){
                $userList = [];
                $groupId = generateNewGroupId();
                foreach ($dateGroup as $user){
                    if ($user->{'destiny'} == $destiny){
                        $user->setGroupId($groupId);
                        $userList[] = $user;
                    }
                }
                if (!empty($userList)){ $finalGroups[] = $userList; }
            }
        }
    }

    $counter = 1;
    foreach ($finalGroups as $finalGroup){
        $floatStyle = "left";
        if ($counter % 2 == 0) { $floatStyle = "right"; }
        $output .= "<div class=groups style=\"float: " . $floatStyle .  "\">";
        $output .= "<p><b>Group - " . $finalGroup[0]->{'groupId'} . " - " . $finalGroup[0]->{'destiny'}  . " - " . $finalGroup[0]->{'date'} . "</b></p>";
        if ($groupSize > 0){

            $emptySpots = ($groupSize - sizeof($finalGroup));
            if ($emptySpots > 0){
                $output .=  "<p style=\"color:green\"><b> Empty Spot(s): " . $emptySpots . "</b></p>";
            }else{
                $output .=  "<p style=\"color:red\"><b> Empty Spot(s): " . $emptySpots . "</b></p>";
            }

        }else{
            $output .=  "<p><b> Group Size: " . sizeof($finalGroup) . "</b></p>";
        }
        foreach ($finalGroup as $user){
            $output .= "<p style=\"text-indent: 1em\">" . $user->{'name'} . "(" . $user->{'email'}  . ")</p>";
        }
        $counter++;
        $output .= "</div>";
    }

    $output .= "<p style=\"margin: 0 auto; clear: both;\"></p>";
    $output .= "<button style=\"margin-left: 38%; float: left;\" onclick=\"location.href = 'formGroups.php';\"class=\"button\">Try Again</button>";
    $output .= "<form method='post'><input type='submit' name='registerGroups' value='Register Groups' style=\"margin-left: 1%; clear: both;\" class=\"button\"></form>";

    return array($output, $finalGroups);
}

if (isset($_POST['registerGroups'])){

    $groupsFinalList = $_SESSION["groupsList"];

    $success = false;

    foreach ($groupsFinalList as $finalGroup){
        // Getting destiny ID
        $destiny = $finalGroup[0]->{'destiny'};
        $query = "SELECT packageId FROM vacationplan WHERE PackageName = '$destiny'";
        $result = mysqli_query($con, $query) or die ("query failed" . mysqli_error($con));
        $row = mysqli_fetch_row($result);
        $packageId = $row[0];

        // Getting group size, date and id
        $groupActualSize = sizeof($finalGroup);
        $groupTravelDate = $finalGroup[0]->{'date'};
        $groupId = $finalGroup[0]->{'groupId'};

        // Creating group in group_info
        $query = "INSERT INTO  group_info VALUES ('$groupId', '$packageId', '$groupActualSize', '$groupTravelDate')";
        $result = mysqli_query($con, $query) or die ("query failed" . mysqli_error($con));

        // Updating users groupID
        foreach ($finalGroup as $user){
            $userRegistrationId = $user->{'id'};
            $query = "UPDATE user_info SET GroupId = '$groupId' WHERE RegistrationId = '$userRegistrationId'";
            $result = mysqli_query($con, $query) or die ("query failed" . mysqli_error($con));

            if ($result){ $success = true; }
            else{ $success = false; break; }
        }
    }

    if ($success){
        $messageStyle="color:green";
        $message = "Groups Registered successfully.";
    }else{
        $messageStyle="color:red";
        $message = "Error, no row was affected.";
    }
}

function generateNewGroupId(){
    $existingGroupIds = [];

    while(in_array(($groupId = rand(0,10000)), $existingGroupIds)){ }

    return $groupId;
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace("'", "\'", $data);
    return $data;
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XYZ Travel Plan - Login</title>
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
        .sections{ margin: 0 auto; margin-top: 50px; padding: 20px; background-color: white; border-radius: 10px; }
        .sections:hover{ box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); }
        .submitDiv{ width: 30%; }
        .groupsDiv{ margin-bottom: 5%; width: 70%; }
        .hidden{ display: none; }
        .show{ display: block }
        .groups{ min-height: 200px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); width: 45%; padding:5px; margin: 10px; border-radius: 5px; border: 1px solid grey; background-color: white; }
    </style>
</head>
<body>
<div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
    <a style="text-decoration: none;"href="./index.php">
        <h1 style="text-align: center; margin-top: 0; color: white;">XYZ Travel Plan</h1>
    </a>
</div>
<main>
    <div class="<?php print $hiddenClass ?>  submitDiv sections">
        <h2>Please, fill the form:</h2>
        <p style="<?php print $messageStyle ?>"><?php print $message ?></p>
        <form method="post" enctype="multipart/form-data">
            <label>Enter the size of each group:</label>
            <input type="number" name="groupSize">
            <input class="subButton" type="submit" name="groupLimitGenerate" value="Generate">
            <br><br>
            <label>Auto Generated: </label>
            <input class="subButton" type="submit" name="autoGenerate" value="Generate">
        </form>
    </div>

    <div class="sections groupsDiv <?php print $showClass ?>">
        <h2> Generated groups: </h2>
        <?php print $generatedGroups ?>
    </div>

</main>
</body>
</html>