<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        h1,h2,h3,h4,p{
            font-family: Arial, Helvetica, sans-serif;
        }
        main{
            margin: 0 auto;
            margin-top: 30px;
            padding: 20px;
            width: 70%;
            background-color: white;
            border-radius: 10px;
        }
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
        main{
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            width: 30%;
            background-color: white;
            border-radius: 10px;
        }
        .subButton{ font-size: 12px; background-color: white; border: 1px solid black;  border-radius: 5px;}
        .subButton:hover{ cursor: pointer; color: white; background-color: black; border: 1px solid darkgreen transition-duration: 0.3s; }

    </style>
</head>
    <div style="width: 100%; height: 100px;padding-top: 50px; background-color: black; margin-top: 0">
        <a style="text-decoration: none;"href="./index.php">
            <h1 style="text-align: center; margin-top: 0; color: white;">Admin Control Panel</h1>
        </a>
    </div>
    <main>

    <form method="post" action="">
     <div>
        <h2>Click to view User Accounts</h2>
        <input class="subButton" type="submit" value="See Accounts" name="userAcc" /> <br>
        <h2>Click to modify user accounts</h2>
        <input class="subButton" type="submit" value="Modify Accounts" name="modify" /><br>
        <h2>Click to form Groups</h2>
        <input class="subButton" type="submit" value="Generate Group" name="group" /><br>
         <h2>Click to see existing Groups</h2>
         <input class="subButton" type="submit" value="See Groups" name="seeGroups" /><br>
         <h2>Logout</h2>
         <input class="subButton" type="submit" value="LogOut" name="logout"/>
        </div>
    </form>
    </main>


    <?php
    //  Connect to database
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "project2";
    $userName="";
    $password="";


    //  Connecting to DB
    $con = mysqli_connect($host, $user, $password, $dbName) or die("Connection Failed.");

    if (isset($_POST['userAcc'])) {
        echo "<script>window.open('./usersTable.php', 'width=710,height=555,left=160,top=170')</script>";

        }?>

<?php

    if(isset($_POST['seeGroups'])) {
        mysqli_close($con);
        header("Location: ./seeExistingGroups.php");
        exit;
    }

   if(isset($_POST['modify'])) {
       mysqli_close($con);
       header("Location: ./ModifyUserAccounts.php");
       exit;
   }

    if (isset($_POST['group'])){
        mysqli_close($con);

        header("Location: ./formGroups.php");
        exit;
    }

if(isset($_POST['logout'])){
    mysqli_close($con);
    header("Location: ./index.php");
    exit;
}
    mysqli_close($con);

    ?>

</html>