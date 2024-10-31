<?php
include("../connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>PICK 2 PUFF - Admin Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Admin Login</h3></div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" name="email" type="text" placeholder="Enter your email" required />
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="password" name="password" type="password" placeholder="Password" required />
                                            <label for="password">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <input class="btn btn-secondary d-block" type="submit" name="btnlogin" value="Login">
                                        </div>
                                    </form>

                                    <?php
                                    if (isset($_POST["btnlogin"])) {
                                        $email = mysqli_real_escape_string($con, $_POST["email"]);
                                        $password = mysqli_real_escape_string($con, $_POST["password"]);
                                        
                                        // Update the query to check email and password together
                                        $query = mysqli_query($con, "SELECT * FROM accounts WHERE email='$email' AND password='$password'");
                                        
                                        if ($query) {
                                            $user = mysqli_fetch_assoc($query); // Fetch the user data

                                            if ($user) {
                                                // Check if account_type is 1
                                                if ($user['account_type'] == 1) {
                                                    $_SESSION["email"] = $email;
                                                    $_SESSION["account_type"] = $user['account_type']; // Store account_type in session
                                                    echo "<script>window.location = 'index.php?pg=main';</script>";
                                                } else {
                                                    echo "<script>alert('Access denied: You are not an admin.'); window.location = 'login.php';</script>";
                                                }
                                            } else {
                                                echo "<script>alert('Invalid email or password.'); window.location = 'login.php';</script>";
                                            }
                                        } else {
                                            echo "<script>alert('Database query failed: " . mysqli_error($con) . "'); window.location = 'login.php';</script>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
