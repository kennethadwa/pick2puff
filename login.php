<?php
session_start();
include("connect.php");
require_once 'vendor/autoload.php'; // Include Composer's autoloader
require_once 'config.php';

// Generate Google login URL
$login_url = $client->createAuthUrl();

if (isset($_POST["btnlogin"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM accounts WHERE email='$email' AND password='$password'"));
    if ($count > 0) {
        $email = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM accounts WHERE email='$email' AND password='$password'"));
        $_SESSION["id"] = $email["id"];
        echo "<script>window.location = 'index.php?pg=shop';</script>";
    } else {
        echo "<script>alert('Invalid email or password!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login - PICK 2 PUFF</title>
</head>
<body class="bg-dark">
<form method="POST"> 
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image" style="background-image: url('./pics/loginbg.jpg'); background-size: cover; object-fit: cover; text-align: center;">
                <img src="pics/logo.png" alt="">
                <div class="text">
                    <h2 style="color: white; font-weight: 600; font-size: 3rem; text-shadow: 3px 3px 8px black;">WELCOME <br> TO <br> PICK 2 PUFF</h2>
                    <p style="font-size: 1rem; text-shadow: 1px 1px 5px black;">Online Vape Shop</p>
                </div>
            </div>

            <div class="col-md-6 right">
                <div class="input-box">
                   <header>
                    Login
                    <br>
                    <p>Don't have an account?<a href="signup.php"> sign up</a></p>
                   </header>


                   <!-- Age restriction notice -->
                   <div class="alert" role="alert" style="background: black; color: red;">
                       You must be 18 years or older to access this site.
                   </div>
                   
                   
                   <div class="input-field">
                        <input type="text" class="input" id="email" name="email" required="" autocomplete="off">
                        <label for="email">Email</label> 
                    </div> 
                   <div class="input-field">
                        <input type="password" class="input" id="password" name="password" required="">
                        <label for="password">Password</label>
                    </div> 
                   <div class="input-field">
                       <input class="btn btn-secondary d-block" type="submit" name="btnlogin" value="Login">
                       <br>
                       <a href="forgot.php">Forgot your password?</a>
                   </div>
                   <div class="text-center mt-5">
                       <a href="<?php echo $login_url; ?>" class="btn" style="background: transparent; font-weight: bold; border: 1px solid black"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 100 100">
<path fill="#78a0cf" d="M13 27A2 2 0 1 0 13 31A2 2 0 1 0 13 27Z"></path><path fill="#f1bc19" d="M77 12A1 1 0 1 0 77 14A1 1 0 1 0 77 12Z"></path><path fill="#cee1f4" d="M50 13A37 37 0 1 0 50 87A37 37 0 1 0 50 13Z"></path><path fill="#f1bc19" d="M83 11A4 4 0 1 0 83 19A4 4 0 1 0 83 11Z"></path><path fill="#78a0cf" d="M87 22A2 2 0 1 0 87 26A2 2 0 1 0 87 22Z"></path><path fill="#fbcd59" d="M81 74A2 2 0 1 0 81 78 2 2 0 1 0 81 74zM15 59A4 4 0 1 0 15 67 4 4 0 1 0 15 59z"></path><path fill="#78a0cf" d="M25 85A2 2 0 1 0 25 89A2 2 0 1 0 25 85Z"></path><path fill="#fff" d="M18.5 51A2.5 2.5 0 1 0 18.5 56A2.5 2.5 0 1 0 18.5 51Z"></path><path fill="#f1bc19" d="M21 66A1 1 0 1 0 21 68A1 1 0 1 0 21 66Z"></path><path fill="#fff" d="M80 33A1 1 0 1 0 80 35A1 1 0 1 0 80 33Z"></path><g><path fill="#ea5167" d="M35.233,47.447C36.447,40.381,42.588,35,50,35c3.367,0,6.464,1.123,8.968,2.996l6.393-6.885 C61.178,27.684,55.83,25.625,50,25.625c-11.942,0-21.861,8.635-23.871,20.001L35.233,47.447z"></path><path fill="#00a698" d="M58.905,62.068C56.414,63.909,53.335,65,50,65c-7.842,0-14.268-6.02-14.934-13.689l-8.909,2.97 C28.23,65.569,38.113,74.125,50,74.125c6.261,0,11.968-2.374,16.27-6.27L58.905,62.068z"></path><path fill="#48bed8" d="M68.5,45.5h-4.189H50.5v9h13.811c-1.073,3.414-3.333,6.301-6.296,8.179l7.245,6.038 c5.483-4.446,8.99-11.233,8.99-18.842c0-1.495-0.142-2.955-0.401-4.375H68.5z"></path><path fill="#fde751" d="M35,50c0-2.183,0.477-4.252,1.316-6.123l-7.818-5.212c-1.752,3.353-2.748,7.164-2.748,11.21 c0,3.784,0.868,7.365,2.413,10.556L36,55C35.634,53.702,35,51.415,35,50z"></path></g><g><path fill="#472b29" d="M50,74.825c-13.757,0-24.95-11.192-24.95-24.95S36.243,24.925,50,24.925 c5.75,0,11.362,2.005,15.804,5.646l0.576,0.472l-7.327,7.892l-0.504-0.377C56.051,36.688,53.095,35.7,50,35.7 c-7.885,0-14.3,6.415-14.3,14.3S42.115,64.3,50,64.3c5.956,0,11.195-3.618,13.324-9.1L50,55.208l-0.008-10.184l24.433-0.008 l0.104,0.574c0.274,1.503,0.421,2.801,0.421,4.285C74.95,63.633,63.758,74.825,50,74.825z M50,26.325 c-12.985,0-23.55,10.564-23.55,23.55S37.015,73.425,50,73.425s23.55-10.564,23.55-23.55c0-1.211-0.105-2.228-0.3-3.458H51.192 L51.2,53.8h14.065l-0.286,0.91C62.914,61.283,56.894,65.7,50,65.7c-8.657,0-15.7-7.043-15.7-15.7S41.343,34.3,50,34.3 c3.19,0,6.245,0.955,8.875,2.768l5.458-5.878C60.238,28.048,55.178,26.325,50,26.325z"></path></g>
</svg>Login with Google</a>
                   </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; PICK 2 PUFF 2024</div>
        </div>
    </div>
</footer>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
