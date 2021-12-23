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
    <title>History | ATM Card</title>

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
                    <p class="text-22px text-center">Transaction History</p>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <?php

                        echo '
                        <thead>
                            <tr>
                               
                                <th>Branch Name</th>
                                <th>Amount</th>
                                <th>Transaction Date & Time</th>
                            </tr>
                        </thead><tbody>
                    ';

                     
                            $user_pk = $_GET['id'];
                       

                        $sql = "SELECT * from transaction where account_id='$user_pk'";
                        $transaction_data = $conn->query($sql);
                        if ($transaction_data->num_rows > 0) {
                            while ($row = $transaction_data->fetch_assoc()) {
                                $accid =  $row["account_id"];
                                $brid =  $row["branch_id"];

                                $sql2 = "SELECT user_id from account where id='$accid'";
                                $tran = $conn->query($sql2);
                                if ($tran->num_rows > 0) {
                                    $usid = $tran->fetch_assoc();
                                    $usidmain = $usid['user_id'];

                                    $sql3 = "SELECT name from users where id='$usidmain'";
                                    $trans = $conn->query($sql3);
                                    if ($trans->num_rows > 0) {
                                        $name = $trans->fetch_assoc();
                                        $namemain = $name['name'];

                                        $sql4 = "SELECT name from branch where id='$brid'";
                                        $trans4 = $conn->query($sql4);
                                        if ($trans4->num_rows > 0) {
                                            $brname = $trans4->fetch_assoc();
                                            $brnamemain = $brname['name'];

                                            echo '
                                        
                                            <tr>
                                                
                                                <td>' . $brnamemain . '</td>
                                                <td>' . $row["amount"] . '</td>
                                                <td>' . $row["created_at"] . '</td>
                                            </tr>
                                       
                                    ';
                                        }
                                    }
                                }
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

    <!-- Blocking History -->
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <p class="text-22px text-center">Blocked History</p>
                </div>
                <div class="panel-body">
                <table class="table">
                        <?php

                        echo '
                        <thead>
                            <tr>
                            
                                <th>Branch Name</th>
                                <th>Transaction Date & Time</th>
                            </tr>
                        </thead><tbody>
                    ';

                       
                        

                        $sql = "SELECT * from block_history where account_id='$user_pk'";
                        $transaction_data = $conn->query($sql);
                        if ($transaction_data->num_rows > 0) {
                            while ($row = $transaction_data->fetch_assoc()) {
                                $accid =  $row["account_id"];
                                $brid =  $row["branch_id"];

                                $sql2 = "SELECT user_id from account where id='$accid'";
                                $tran = $conn->query($sql2);
                                if ($tran->num_rows > 0) {
                                    $usid = $tran->fetch_assoc();
                                    $usidmain = $usid['user_id'];

                                    $sql3 = "SELECT name from users where id='$usidmain'";
                                    $trans = $conn->query($sql3);
                                    if ($trans->num_rows > 0) {
                                        $name = $trans->fetch_assoc();
                                        $namemain = $name['name'];

                                        $sql4 = "SELECT name from branch where id='$brid'";
                                        $trans4 = $conn->query($sql4);
                                        if ($trans4->num_rows > 0) {
                                            $brname = $trans4->fetch_assoc();
                                            $brnamemain = $brname['name'];

                                            echo '
                                        
                                            <tr>
                                                
                                                <td>' . $brnamemain . '</td>
                                                <td>' . $row["created_at"] . '</td>
                                            </tr>
                                       
                                    ';
                                        }
                                    }
                                }
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