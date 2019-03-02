<?php

//  DB Connection Variables
$host = "localhost";
$user = "root";
$password = "";
$dbName = "project2";
$regId= "";
$userName ="";
$userEmail = "";
$userPwd1 = "";
$userPwd2 = "";
$userAddress = "";
$travelDate = "";
$travelPlan = "";
//  Connecting to DB
$con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed.");

$result_message = "";
$result_styling = "color:red";
$registrationID = 0;

if(isset($_POST['update'])){
    $regId= test_input($_POST['regId']);
    $userName = test_input($_POST['name']);
    $userEmail = test_input($_POST['email']);
    $userPwd1 = test_input($_POST['password1']);
    $userPwd2 = test_input($_POST['password2']);
    $userAddress = test_input($_POST['address']);
    $travelDate = date('Y-m-d', strtotime($_POST['travelDate']));
    $travelPlan = test_input($_POST['travelPlan']);
    $groupId = test_input($_POST['groupId']);


    $query = "Update user_info SET Name ='$userName', Address='$userAddress',Date='$travelDate', Email='$userEmail', Password ='$userPwd1',PackageId = '$travelPlan', GroupId = '$groupId' where RegistrationId ='$regId'" ;
    $result = mysqli_query($con, $query) or die ("query is failed\n" . mysqli_error($con));
    if (mysqli_affected_rows($con) > 0) {
        $result_message = "User with  registration id : " . $regId ." Updated Successfully";
        $result_styling="color:green";
    } else {
        $result_message = "Not able to update user account.";
    }

}
if(isset($_POST['find'])){

    $regId= test_input($_POST['regId']);
    $query = "Select * from user_info where RegistrationId = '$regId'";
    $result = mysqli_query($con, $query) or die ("query is failed" . mysqli_error($con));
    if (($row = mysqli_fetch_row($result)) == true) {
        $regId = $row[0];
        $userName= $row[1];
        $userAddress = $row[2];
        $travelDate = $row[3];
        $userEmail=$row[4];
        $travelPlan =$row[5];
        $userPwd1=$row[7];
        $groupId=$row[6];

    }
    else echo "record not found";
}


if(isset($_POST['clear'])){
    $regId= "";
    $userName ="";
    $userEmail = "";
    $userPwd1 = "";
    $userPwd2 = "";
    $userAddress = "";
    $travelDate = "";
    $travelPlan = "";
    $groupId = "";

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
        input[name='back']{
            float: left;
        }
        input[name='back']:hover{
            background-color: rgb(77, 109, 137);
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
        .button{ transition-duration: 0.3s; font-size: 20px; background-color: white; border: 1px solid darkgreen; }
        .button:hover{ cursor: pointer; color: white; background-color: #4CAF50; border: 1px solid darkgreen;  }
    </style>
</head>
<body>


<div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
    <h1 style="text-align: center; margin-top: 0; color: white;">Update User Account!</h1>



</div>
<main>


    <b style="<?php print $result_styling ?>"><b></b><?php print $result_message ?></b></p>

    <form method="post">
        <h4> Personal Information</h4>
        <p>Registration-ID: <input type="text" name="regId" value="<?php echo $regId ?>" required/></p>
        <p>Name: <input type="text" name="name"  value="<?php echo $userName ?>"/></p>
        <p>Email: <input type="email" name="email" value="<?php echo $userEmail ?>"/></p>
        <p>Password: <input type="text" name="password1" value="<?php echo $userPwd1?>"></p>
        <p>Confirm Password: <input type="text" name="password2" value="<?php echo $userPwd2 ?>"/></p>
        <p>Address: <input type="text" name="address" value="<?php echo $userAddress ?>"/> </p>
        <p>Group ID: <input type="text" name="groupId" value="<?php echo $groupId ?>"/> </p>

        <hr>

        <h4>Travel Information</h4>

        <p>Travel Package:
            <select name="travelPlan" value="<?php echo $travelPlan ?>">
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

        <p>Travel start date: <input type="date" name="travelDate" value="<?php echo $travelDate ?>"></p>
        <input type="submit" name="update" value="Update">
        <input type="submit" name="find" value="Find">
        <input type="submit" name="clear" value="Clear">
        <button style=" " onclick="location.href = 'Admin.php';"class="button">Back</button>

    </form>

</main>
</body>
</html>