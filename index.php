<?php
session_start(); // Start the session
include("connect.php");
require_once './config.php';
require_once './vendor/autoload.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['access_token'])) {
        $client->setAccessToken($token['access_token']);

        // Get profile info
        $google_oauth = new \Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        $userinfo = [
            'email' => $google_account_info['email'],
            'first_name' => $google_account_info['givenName'],
            'last_name' => $google_account_info['familyName'],
            'token' => $google_account_info['id'], // Google user ID
        ];

        // Check if Google account already exists in the database
        $sql = "SELECT * FROM accounts WHERE token = '{$userinfo['token']}'";
        $result = mysqli_query($con, $sql);

        if (!$result) {
            die("Query Failed: " . mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) {
            // Existing user
            $userinfo = mysqli_fetch_assoc($result);
            $_SESSION['id'] = $userinfo['id']; // Store the id from the database
        } else {
            // New user, insert into the database
            $sql = "INSERT INTO accounts (fullname, token, account_type) VALUES ('{$userinfo['first_name']} {$userinfo['last_name']}', '{$userinfo['token']}', 2)";
            $result = mysqli_query($con, $sql);

            if (!$result) {
                die("Error creating account: " . mysqli_error($con));
            }

            // Retrieve the id of the newly inserted user
            $_SESSION['id'] = mysqli_insert_id($con); // Get the last inserted ID
            echo "<script>alert('Account Successfully Created!');</script>";
        }

        // Debugging: Print the session variables
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';

        // Redirect after login or account creation
        header("Location: index.php?pg=shop");
        exit();
    } else {
        echo "Authentication failed. Please try again.";
        die();
    }
}

// Check if user is already logged in using other methods
if (!isset($_SESSION['id'])) {
    echo "<script>window.location = 'login.php';</script>";
    exit(); // Make sure to exit after redirection
}

// Retrieve user information
$sql = "SELECT * FROM accounts WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $_SESSION['id']); // Use 'i' for integer parameter
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
    $userinfo = $result->fetch_assoc();
    $_SESSION['account_type'] = $userinfo['account_type']; // Set account type if applicable
} else {
    // Handle case where id does not exist in accounts
    echo "<script>alert('User not found. Please log in again.');</script>";
    header("Location: login.php");
    exit();
}

// Redirect if account_type is not set to 2
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header("Location: login.php");
    exit();
}

// Continue with the rest of your application
$pg = isset($_GET["pg"]) ? $_GET["pg"] : "shop";
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PICK 2 PUFF-Vape Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif !important;
            background-color: #343a40;
            color: black;
        }

        .navbar {
            background-color: #343a40 !important;
        }

        .dropdown-menu {
            background-color: #343a40;
        }

        .dropdown-menu .dropdown-item {
            color: #ffffff !important;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #495057 !important;
        }

        .navbar-light .navbar-nav .nav-link {
            color: #ffffff !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(255, 255, 255, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-brand img {
            filter: brightness(0) invert(1);
        }

        .footer {
            background-color: #343a40 !important;
            color: #adb5bd !important;
        }

        .footer a {
            color: #adb5bd !important;
            text-decoration: none;
        }

        .footer a:hover {
            color: #ffffff !important;
        }

        .section-content {
            background-color: #ffffff !important;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/admin-background.jpg') center/cover no-repeat;
            color: #ffffff !important;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <!-- Age restriction notice -->
    <div class="alert" role="alert" style="background: #343a40; color: white; text-shadow: 2px 2px 10px black; text-align: center; font-size: 1.5rem; font-weight: bold; border-bottom: 2px solid black;">
        You must be 18 years or older to access this site.
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php?pg=shop" style="font-weight: bold; color: white; text-shadow: 2px 2px 10px black; font-size: 1.5rem;">
                PICK 2 PUFF
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($pg == 'shop') ? 'active' : ''; ?>" href="index.php?pg=shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($pg == 'about') ? 'active' : ''; ?>" href="index.php?pg=about">About</a>
                    </li>
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="index.php?pg=shop">All Products</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            $q1 = mysqli_query($con, "SELECT * FROM categories");
                            while ($category = mysqli_fetch_array($q1)) {
                            ?>
                                <li><a class="dropdown-item" href="index.php?pg=shop&categoryid=<?php echo $category['id']; ?>"><?php echo $category['category']; ?></a></li>
                            <?php } ?>
                        </ul>

                    </li>

                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <form class="d-flex" action="index.php?pg=cart" method="POST">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="bi-cart-fill me-1"></i> Cart
                            </button>
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <?php
                        $id = $_SESSION['id'];
                        $q2 = mysqli_query($con, "SELECT * FROM accounts WHERE id=$id");
                        if ($acc = mysqli_fetch_array($q2)) {
                        ?>
                            <ul class="navbar-nav mb-2 mb-lg-0 ms-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $acc['email']; ?></a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item active" href="#">Account</a></li>
                                        <li><a class="dropdown-item" href="index.php?pg=update">Update Account</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li><a class="dropdown-item active" href="#">Transactions</a></li>
                                        <li><a class="dropdown-item" href="index.php?pg=transaction">Transactions List</a></li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="index.php?pg=update">Update Account</a></li>
                                <li><a class="dropdown-item" href="index.php?pg=transaction">Transaction List</a></li>
                                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                            </ul>

                    </li>
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    &nbsp;
                    <li>
                        <div style="width: 40px; height: 40px; padding:0; border-radius: 50%; background: white;">
                            <a href="index.php?pg=chat"><img width="40" height="40" src="https://img.icons8.com/nolan/64/customer-support.png" alt="customer-support" /></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-image p-5 text-center shadow-1-strong rounded mb-0 text-white" style="background-image: url('pics/bg.jpg'); background-size: cover; background-repeat: no-repeat; border: 5px solid black; object-fit:cover;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white"></br>
                <h1 class="display-2 fw-bolder" style="font-family: 'Pacifico', cursive; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 4px 4px 0 #000;">PICK 2 PUFF</h1>
                <p class="lead fw-normal text-white-100 mb-0" style="font-family: 'Open Sans', sans-serif; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">Online Vape Shop</p></br></br></br></br>
            </div>
        </div>
    </header>
    <!-- Section -->
    <section class="py-5" style="background: #1e2a32;
">
        <div class="container">
            <?php
                            if ($pg == "shop") include("shop.php");
                            if ($pg == "about") include("about.php");
                            if ($pg == "update") include("update.php");
                            if ($pg == "cart") include("cart.php");
                            if ($pg == "chat") include("chat.php");
                            if ($pg == "addcart") include("addcart.php");
                            if ($pg == "transaction") include("transaction.php");
                            if ($pg == "viewitemdetails") include("viewitemdetails.php");
                            if ($pg == "viewtransactiondetails") include("viewtransactiondetails.php");
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container text-center">
            <p class="text-white m-0 text-center">Copyright &copy; PICK2PUFF 2024</p>
        </div>
    </footer>
<?php } ?>
<!-- Bootstrap core JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>