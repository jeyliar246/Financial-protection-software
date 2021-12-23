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
    <title>Users | Credit Card Fraud Detection</title>

    <!-- Load all static files -->
    <link rel="stylesheet" type="text/css" href="assets/BS/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">

    <style>
        .container {
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
    include 'helper/navbar_users.php';
    ?>

    <!-- Transaction history -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="text-22px text-center">Registered Customers</p>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <?php

                        echo '
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Account Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead><tbody>
                    ';

                        $email = $_SESSION['username'];


                        $sql = "SELECT * from users where type='user'";
                        $transaction_data = $conn->query($sql);
                        if ($transaction_data->num_rows > 0) {
                            while ($row = $transaction_data->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row["name"] ?></td>
                                    <td><?php echo  $row["email"] ?> </td>
                                    <td><?php 
                                    $id = $row["id"];
                                    $q = $conn->query("select ac_number from credit_card where account_id=(select id from account where user_id = '$id') ");
                                    if ($q->num_rows > 0) {
                                        if ($roww = $q->fetch_assoc()) {
                                            echo  $roww["ac_number"] ;
                                        }
                                    }
                                    ?> </td>
                                    <?php 
                                    $id = $row["id"];
                                    $q = $conn->query("select status from credit_card where account_id=(select id from account where user_id = '$id') ");
                                
                                        $roww = $q->fetch_assoc() ;
                                    if ($roww["status"] == "1") { ?>
                                        <td>Active</td>

                                    <?php
                                    } else {
                                    ?>
                                        <td>Blocked</td>


                                    <?php }

                                    $idd = $row["id"];
                                    $accid = "";
                                    $sqll = "SELECT id from account where user_id='$idd'";
                                    $transaction = $conn->query($sqll);
                                    if ($transaction->num_rows > 0) {
                                        $rows = $transaction->fetch_assoc();
                                        $accid = $rows['id'];
                                    }
                                    ?>

                                    <td>
                                        <a href="history.php?id=<?php echo $accid; ?>"><span class="btn btn-success bg-green"><i class="fa fa-edit"></i> View History </span></a>
                                        <a href="settings.php?id=<?php echo $accid; ?>"><span class="btn btn-primary bg-orange"><i class="fa fa-info"></i> Edit Account</span></a>
                                    </td>
                                </tr>
                        <?php

                            }
                        } else {
                            echo ' </tbody><p class="text-center">No data to show</p>';
                        }
                        ?>
                    </table>
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