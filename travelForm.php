<?php

//  DB Connection Variables
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";

//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed.");

$result_message = "";
$result_styling = "color:red";
$registrationID = 0;

$hiddenClass = "";
$showClass = "hidden";

if(isset($_POST['submit'])){
    $userName = test_input($_POST['name']);
    $userEmail = test_input($_POST['email']);
    $userPwd1 = test_input($_POST['password1']);
    $userPwd2 = test_input($_POST['password2']);
    $userAddress = test_input($_POST['address']);
    $travelDate = date('Y-m-d', strtotime($_POST['travelDate']));
    $travelPlan = test_input($_POST['travelPlan']);

    if (!userExists($userEmail, $con)){
        if ($userPwd1 == $userPwd2){
            //  Generating unique Report ID
            $unique = false;
            while(!$unique){
                $registrationID = intval(mt_rand(0000, 9999)); // Generates random 4 digit ID
                $query = "SELECT RegistrationId FROM user_info WHERE RegistrationId  = '$registrationID'";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) == 0){ $unique = true; }
            }

            // Insert Data to table
            $query = "INSERT INTO `user_info`(`RegistrationId`, `Password`, `Name`, `Address`, `Date`, `Email`, `PackageId`)
                      VALUES ('$registrationID',  '$userPwd1', '$userName', '$userAddress', '$travelDate', '$userEmail', '$travelPlan');";

            $result = mysqli_query($con, $query) or die ("query is failed\n" . mysqli_error($con));

            if (mysqli_affected_rows($con) > 0) {
                $result_message = "User Created Successfully, your registration id is: " . $registrationID;
                $result_styling="color:green";

                $hiddenClass = "hidden";
                $showClass = "";

            } else {
                $result_message = "Not able to create user.";
            }
        }else{ $result_message = "Passwords don't match"; }
    }else{ $result_message = "Email already registered."; }
}

function userExists($userEmail, $con){
    $query = "SELECT Email FROM user_info WHERE Email = '$userEmail'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 0){ return false; }
    else{ return true; }
}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = str_replace("'", "\'", $data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XYZ Travel Plan</title>
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
        input{
            border: 1px solid darkgrey;
        }
        input[type='submit']{
            font-size: 20px;
            background-color: white;
            border: 1px solid darkgreen;
            transition-duration: 0.3s;
        }
        input[type='submit']:hover{
            cursor: pointer;
            color: white;
            background-color: #4CAF50;;
            border: 1px solid darkgreen;
        }
        main{
            margin: 0 auto;
            margin-top: 30px;
            padding: 20px;
            width: 70%;
            background-color: white;
            border-radius: 10px;
        }
        main:hover{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .hidden{ display: none}

        .button{ font-size: 20px; background-color: white; border: 1px solid darkgreen; transition-duration: 0.3s; }
        .button:hover{ cursor: pointer; color: white; background-color: #4CAF50; border: 1px solid darkgreen; }
    </style>
</head>
<body>

<div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
    <a style="text-decoration: none;"href="./index.php">
        <h1 style="text-align: center; margin-top: 0; color: white;">Hello, traveller!</h1>
    </a>
</div>
<main>

    <h3>Please, fill the form to register:</h3>
    <b style="<?php print $result_styling ?>"><b></b><?php print $result_message ?></b></p>
    <div class="<?php print $hiddenClass ?>">
        <form method="post">
                <h4>Your Personal Information</h4>
                <p>Name: <input type="text" name="name" required/></p>
                <p>Email: <input type="email" name="email" required/></p>
                <p>Password: <input type="password" name="password1" required></p>
                <p>Confirm Password: <input type="password" name="password2" required></p>
                <p>Address: <input type="text" name="address" required></p>

                <hr>

                <h4>Your Travel Information (be advised that our trips are all one day long and no more than that)</h4>

                <p>Travel Package:
                <select name="travelPlan">
                    <?php
                    $query = "SELECT * FROM vacationplan";
                    $result = mysqli_query($con, $query);
                    while($row = mysqli_fetch_row($result)){
                        ?>
                        <option value="<?php echo $row[0]?>"><?php echo $row[1] ?></option><br><br>
                        <?php
                    }
                    ?>
                </select></p>

                <p>Travel start date: <input type="date" name="travelDate" required></p>
                <input type="submit" name="submit">
                <button style=" " onclick="location.href = 'index.php';"class="button">Back</button>

        </form>
    </div>
    <div class="<?php print $showClass ?>">
        <button class="button" onclick="location.href = 'index.php';">Go back</button>
    </div>
</main>
</body>
</html>