<?php
ob_start();
session_start();

// Check previous session untill is destroyed
// if (isset($_SESSION['username'])) {
//     header('Location: settings.php');
// }
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Credit Card Fraud Detecting System</title>

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

        .lPanel {
            float: left;
        }

        @media only screen and (min-width: 600px) {
            .form-control {

                width: 30em;
            }
        }

        @media only screen and (max-width: 600px) {
            .form-control {

                width: 20em;
            }
        }
    </style>

</head>
<h2 style="text-align: center; color:white;">Credit Card Fraud Detection</h2>

<body class="container">
    <!-- Config included -->
    <?php include 'helper/config.php' ?>


    <?php


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $random = $_POST['rand'];

        $get_login_sql = "SELECT * FROM users WHERE email='" . $email . "' AND password='" . $password . "'";

        $login_success = $conn->query($get_login_sql);
        if ($login_success->num_rows == 1) {
            $row = mysqli_fetch_array($login_success);
            $uid = $row['user_id'];

            $_SESSION['usertype'] =  $row['type'];

            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $email;
        } else {
            $_SESSION['loginerror'] = "Invalid login details";
        }
        // Check the session and add into session



        // Redirect to settings page
         header('Location: index.php');
    }


    ?>
    <!-- Login view -->
    <div class="lPanel">
        <form class="form-signin" method="POST" action="">
            <br /><br /><br /><br /><br />
            <h2 class="form-signin-heading" style="color: white;">Admin Sign In</h2><br>
            <?php if (isset($_SESSION['loginerror'])) {
                echo '<span style="color:white">' . $_SESSION['loginerror'] . '</span>';
                unset($_SESSION['loginerror']);
            } ?>
            <label for="inputEmail" class="sr-only"></label>
            <h5 style="color:white">Email Address</h5>
            <input type="email" id="phone" name="email" class="form-control" id="phone" required autofocus>
            <br />
            <input type="hidden" value="<?php echo $rand; ?>" name="rand" id="rand">
            <label for="inputPassword" class="sr-only"></label>
            <h5 style="color:white">Password</h5>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required><br>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</body>
<footer>
    <!-- All the Javascript will be load here... -->
    <script type="text/javascript" src="assets/JS/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="assets/JS/main.js"></script>
    <script type="text/javascript" src="assets/BS/js/bootstrap.min.js"></script>
</footer>

</html>