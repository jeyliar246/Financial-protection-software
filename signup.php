<?php
include 'helper/config.php';

session_start();

if (isset($_SESSION['username'])) {
    // logged in
    // Something will happen here....
} else {
    // not logged in
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account | Credit Card Fraud Detection</title>

    <!-- Load all static files -->
    <link rel="stylesheet" type="text/css" href="assets/BS/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
    <style>
        .container,.row, .panel {
            background: url(assets/bg.png) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;

        }
        </style>
</head>

<body class="container">
    <!-- Config included -->
    <?php
    include 'helper/navbar_create_account.php';
    ?>

    <div class="row">
        <div class="col-sm-12 col-md-12">
            <!-- After submitting the form -->
            <?php


            // To changing status
            if (isset($_POST['submit'])) {
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $amount = $_POST['amount'];
                $trans_limit = $_POST['trans_limit'];
                $prefbranch = $_POST['prefbranch'];
                $password = $_POST['password'];
                $accnum = $_POST['accnum'];
                $phone = $_POST['phone'];
                ?>
            <?php
                $status_sql = "INSERT into users values ('0','$fullname','$email','$password','1','user','$phone')";
                $updated_status = $conn->query($status_sql);
                if ($updated_status) {
                    $user_data_sql = "SELECT id FROM users WHERE email='" . $email . "'";
                    $user_data = $conn->query($user_data_sql);
                    if ($user_data->num_rows == 1) {
                        $user_id = $user_data->fetch_row()[0];

                        $data_sql = "SELECT id FROM branch WHERE name='" . $prefbranch . "'";
                        $data = $conn->query($data_sql);
                        if ($data->num_rows == 1) {
                            $branchid = $data->fetch_row()[0];

                            $status_sql = "INSERT into account values ('0','$user_id','$branchid','1','$amount','$trans_limit')";
                            $updat_status = $conn->query($status_sql);
                            if ($updat_status) {
                                $data_sqls = "SELECT id FROM account WHERE user_id='" . $user_id . "'";
                                $datas = $conn->query($data_sqls);
                                if ($datas->num_rows == 1) {
                                    $accid = $datas->fetch_row()[0];

                                    $sql = "INSERT into credit_card values ('0','[$branchid]','$accnum','$password','$accid','1')";
                                    $tus = $conn->query($sql);
                                    if ($tus) {
                                        echo '<p class="success-message">Successfully saved!!</p>';
                                    }else {
                                        echo '<p class="success-message">Error 6</p>';
                                    }
                                }else {
                                    echo '<p class="success-message">Error 5</p>';
                                }
                            } else {
                                echo '<p class="success-message">Error 4</p>';
                            }
                        }else {
                            echo '<p class="success-message">Error 3</p>';
                        }
                    }else {
                        echo '<p class="success-message">Error 2</p>';
                    }
                } else {

                    echo '<p class="error-message">May be you are doing wrong. Contact with the Service Provider</p>'.mysqli_error($conn);
                }
            }

            ?>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <p class="text-22px text-center">Create New Account</p>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6 col-md-6">
                        <?php

                        echo '&nbsp&nbsp&nbsp&nbsp&nbsp<div style="justify-content:center">
                            <p class="list-head" style="color:white;">Register new User</p>
                            <div class="mini-containers">
                                <div class="nice-border" >
                                    <form method="POST"  class="form-group p-a-sm">
                                        <label style="color:white;">Customer Fullname</label>
                                        <input type="text" name="fullname" class="form-control" 
                                          required/>
                                        <br/>
                                        <label style="color:white;">Email</label>
                                        <input type="text" name="email" class="form-control" 
                                          required/>
                                          <br/>
                                          <label style="color:white;">Account Number</label>
                                        <input type="text" name="accnum" class="form-control" 
                                          required/>
                                          <br/>
                                          <label style="color:white;">Deposit Amount</label>
                                        <input type="text" name="amount" class="form-control" 
                                          required/>
                                          <br/>
                                          <label style="color:white;">Transaction Limit</label>
                                        <input type="text" name="trans_limit" class="form-control" 
                                          required/>
                                          <br/>
                                          <label style="color:white;">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" 
                                          required/><br/>
                                          <label style="color:white;">Select Preffered Branch</label><br />
                                          <select  class="form-control" name="prefbranch">
                                            <option> --select-- </option>
                                            <option value="Anambra">Anambra </option>
                                            <option value="Abuja"> Abuja</option>
                                            <option value="Cross-River"> Cross-River</option>
                                            <option value="Akwa-Ibom"> Akwa-Ibom</option>
                                            <option value="Enugu"> Enugu</option>
                                            <option value="Plateau">Plateau </option>
                                          </select>
                                          <br/>
                                        <label style="color:white;">Password</label>
                                        <input type="password" name="password" class="form-control" 
                                          required/><br>
                                        <input class="btn btn-info btn-block" type="submit" name="submit" value="Save"/>
                                    </form>
                                </div>
                            </div></div>
                        ';

                        echo "<br><br>";
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>


</body>
<footer>
    <!-- All the Javascript will be load here... -->
    <script type="text/javascript" src="assets/JS/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="assets/JS/main.js"></script>
    <script type="text/javascript" src="assets/BS/js/bootstrap.min.js"></script>
</footer>

</html>