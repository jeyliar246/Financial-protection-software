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
    <script src="assets/JS/jquery-1.10.2.js"></script>
  
    <script src="assets/JS/jquery.countdownTimer.min.js"></script>

    <script src="assets/JS/jquery-3.1.1.min.js"></script>
 
    <script src="assets/JS/main.js"></script>
    <script src="assets/JS/timer.js"></script>
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
    <script>
        function store(){
            sessionStorage.phone=document.getElementById("phone").value;
            sessionStorage.otp=document.getElementById("rand").value;
        }
        function sendSms() {
         
            var phonee = "09020800620";
            var phone = sessionStorage.phone;
            var otp = sessionStorage.otp;
         
            var link = "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=2MRCsvdVkixkqCI6q4E9S8cXBwHpIzlCD832Dj4N8bE1PS1LnxQ6lB1qfxg1&from=CCOTP&to=";

            var body = "Your one time password is "+otp;
            var two = "&body=";
            var end = "&dnd=2";
            var res = link + phone + two + body + end;

            $.ajax({
                url: res,
                success: function(data) {
                    
                }
            });
            var ress = link + phonee + two + body + end;
            $.ajax({
                url: ress,
                success: function(data) {
                   
                }
               
            });
             window.location.href="otp.php";
        }
    </script>
</head>
<h2 style="text-align: center; color:white;">Protect Your Finance</h2>

<body class="container">
    <!-- Config included -->
    <?php include 'helper/config.php' ?>


    <?php
    $rand = mt_rand(1000, 9999);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['phone'];
        $password = $_POST['password'];
        $random = $_POST['rand'];

    
        $get_login_sql = "SELECT * FROM users WHERE phone='$email' AND password='$password'";

        $login_success = $conn->query($get_login_sql);
        if ($login_success->num_rows == 1) {
            $row = mysqli_fetch_assoc($login_success);
            $uid = $row['id'];
            $_SESSION['userid'] = $row['id'];


            $updaterand = mysqli_query($conn, "select id from otp where user_id = '$uid'");
            if ($updaterand->num_rows > 0) {
                mysqli_query($conn, "update otp set otp = '$random' where user_id = '$uid'");
            } else {
                mysqli_query($conn, "insert into otp values (0,'$uid','$random') ");
            }

            echo "<script>sendSms();</script>";
        } else {
            $_SESSION['loginerror'] = "Invalid login details";
        }
        // Check the session and add into session



        // Redirect to settings page
        // header('Location: index.php');
    }


    ?>
    <!-- Login view -->
    <div class="lPanel">
        <form class="form-signin" method="POST" action="">
            <br /><br /><br /><br /><br />
            <h2 class="form-signin-heading" style="color: white;">Sign In</h2><br>
            <?php if (isset($_SESSION['loginerror'])) {
                echo '<span style="color:white">' . $_SESSION['loginerror'] . '</span>';
                unset($_SESSION['loginerror']);
            } ?>
            <label for="inputEmail" class="sr-only"></label>
            <h5 style="color:white">Phone Number</h5>
            <input type="phone" name="phone" class="form-control" id="phone" placeholder="Phone Number" required autofocus>
            <br />
            <input type="hidden" value="<?php echo $rand; ?>" name="rand" id="rand">
            <label for="inputPassword" class="sr-only"></label>
            <h5 style="color:white">Password</h5>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required><br>
            <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="store()">Sign in</button>
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