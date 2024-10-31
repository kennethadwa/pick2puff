<?php
include("../connect.php");

// Check if the session variable for email is set and if the user has account_type == 1
if (!isset($_SESSION["email"]) || $_SESSION["account_type"] != 1) {
    echo "<script>window.location = 'login.php';</script>";
    exit(); // It's a good practice to exit after redirection
}

// Set the page variable
$pg = isset($_GET["pg"]) ? $_GET["pg"] : "main";
ob_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Admin panel for PICK 2 PUFF" />
    <meta name="author" content="PICK 2 PUFF" />
    <title>Admin - PICK 2 PUFF</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css-shop/styles.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif !important;
            background-color: #f8f9fa !important;
        }

        .navbar {
            background-color: #343a40 !important;
        }

        .navbar-nav .nav-link {
            color: #ffffff !important;
        }

        .navbar-nav .nav-link:hover {
            color: #adb5bd !important;
        }

        .navbar-toggler {
            border: none;
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

        header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('assets/admin-background.jpg') center/cover no-repeat;
            color: #ffffff !important;
        }

        .section-content {
            background-color: #ffffff !important;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        footer {
            background-color: #343a40 !important;
            color: #adb5bd !important;
        }

        footer a {
            color: #adb5bd !important;
            text-decoration: none;
        }

        footer a:hover {
            color: #ffffff !important;
        }

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <?php
    $email = $_SESSION['email'];
    $q = mysqli_query($con, "SELECT * FROM accounts WHERE email='$email'");
    if ($r = mysqli_fetch_array($q)) {
    ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="index.php">Admin - PICK 2 PUFF</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php?pg=main">Dashboard</a></li>
                    </ul>
                    <ul class="navbar-nav mb-2 mb-lg-0 ms-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $r['email']; ?></a>
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
                                <li><a class="dropdown-item active" href="#">Management</a></li>
                                <li><a class="dropdown-item" href="index.php?pg=categories">Categories</a></li>
                                <li><a class="dropdown-item" href="index.php?pg=items">Items</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
        <div class="container px-3 px-lg-5 my-5">
                <div class="text-center text-white"></br>
                    <h1 class="display-2 fw-bolder" style="font-family: 'Pacifico', cursive; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 4px 4px 0 #000;">PICK 2 PUFF</h1>
                    <p class="lead fw-normal text-white-100 mb-0" style="font-family: 'Open Sans', sans-serif; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">Online Ordering System</p></br></br></br></br>
                </div>
            </div>
        </header>
        
        <!-- Section-->
        <section class="py-5 " style="background-color: #495057;">
            <div class="container section-content">
                <?php
                if ($pg == "main") include("main.php");
                if ($pg == "update") include("update.php");
                if ($pg == "transaction") include("transaction.php");
                if ($pg == "categories") include("categories.php");
                if ($pg == "items") include("items.php");
                if ($pg == "edit_item") include("edit_item.php");
                if ($pg == "view_details") include("view_details.php");
                ?>
            </div>
        <?php
    }
        ?>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container text-center">
                <p class="text-white m-0 text-center">Copyright &copy; PICK 2 PUFF 2024</p>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js-shop/scripts.js"></script>
</body>

</html>