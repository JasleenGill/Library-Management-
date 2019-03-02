<?php
session_start();

//  DB Connection Variables
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";

//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed: ");

$result_message = "";
$result_styling = "color:red";

if(isset($_POST['submit'])){
    $userCredential = test_input($_POST['email']);
    $userPwd1 = test_input($_POST['password1']);

    if(empty($userCredential) || empty($userPwd1)){ $result_message = "Please, fill all the fields"; }
    else{
        $result_message = "";
        if(is_numeric($userCredential)){
            $query = "SELECT RegistrationId, Password FROM user_info 
                      WHERE RegistrationId = '$userCredential' && Password = '$userPwd1' ";
            $result = mysqli_query($con, $query) or die("query is failed" . mysqli_error($con));

            if(mysqli_num_rows($result) != 0) {
                $row = mysqli_fetch_row($result);

                if ($row[0] == 1){
                    mysqli_close($con);
                    header("Location: ./Admin.php");
                    exit;
                }else{
                    mysqli_close($con);
                    $_SESSION['userIdent'] = $userCredential;
                    header("Location: ./userDashboard.php");
                    exit;
                }
            }else{ $result_message = "Fail to sign in, try again."; }

        }else{
            $query = "SELECT Email, Password FROM user_info 
                  WHERE Email = '$userCredential' && Password = '$userPwd1' ";
            $result = mysqli_query($con, $query) or die("query is failed" . mysqli_error($con));

            if(mysqli_num_rows($result) != 0) {
                $row = mysqli_fetch_row($result);

                if ($row[0] == "admin@travelplan.com"){
                    mysqli_close($con);
                    header("Location: ./Admin.php");
                    exit;
                }else{
                    mysqli_close($con);
                    $_SESSION['userIdent'] = $userCredential;
                    header("Location: ./userDashboard.php");
                    exit;
                }
            }else{ $result_message = "Fail to sign in, try again."; }
        }
    }
}

if (isset($_POST['signUp'])){
    mysqli_close($con);
    header("Location: ./travelForm.php");
    exit;
}

if (isset($_POST['seeTravelPlans'])){
    mysqli_close($con);
    header("Location: ./seeGroups.py");
    exit;
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

mysqli_close($con);
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
            width: 30%;
            background-color: white;
            border-radius: 10px;
        }
        main:hover{
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .button{ font-size: 20px; background-color: white; border: 1px solid darkgreen; }
        .button:hover{ cursor: pointer; color: white; background-color: #4CAF50; border: 1px solid darkgreen transition-duration: 0.3s; }
    </style>
</head>
<body>

<div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
    <h1 style="text-align: center; margin-top: 0; color: white;">XYZ Travel Plan</h1>
</div>
<main>

    <h3 style="text-align: center;font-size: 30px">Login</h3>
    <b style="<?php print $result_styling ?>"><b></b><?php print $result_message ?></b>

    <form method="post">
        <p>Email/Registration ID: <input style="float:right; width: 200px;" type="text" name="email" /></p>
        <p>Password: <input style="float:right; width: 200px;" type="password" name="password1" ></p>

        <input type="submit" name="submit" value="Sign in">
        <input id="btn-signUp" type="submit" name="signUp" value="Sign Up"><br>
        <input id="btn-seeTravelPlans" type="submit" name="seeTravelPlans" value="See Travel Groups">
    </form>
</main>
</body>
</html>
