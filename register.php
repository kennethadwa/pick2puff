<?php
    include ("connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Registration - BENTA.PH</title>
</head>
<form method="POST">
<body class="bg-dark">
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">

                <img src="image/logo.png" alt="">
                <div class="text">
                    <p>BENTA.PH <i>- furniture shop</i></p>
                </div>      
            </div>
                <form>
                <div class="col-md-6 right">
                <div class="input-box">
                   <header>Registration</header>
                   <div class="input-field">
                        <input type="text" class="input" id="fullname" name="fullname" required="" autocomplete="off">
                        <label for="fullname">Full Name</label> 
                    </div> 
                    <div class="input-field">
                        <input type="text" class="input" id="contact" name="contact" required="">
                        <label for="contactnumber">Contact Number</label>
                    </div> 
                    <div class="input-field">
                        <input type="text" class="input" id="address" name="address" required="">
                        <label for="fulldeliveryaddress">Full Delivery Address</label>
                    </div> 
                    <div class="two-forms">
                        <div class="input-field">
                            <input type="text" class="input" id="username" name="username" required="">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field">
                            <input type="text" class="input" id="password" name="password" required="">
                            <label for="password">Password</label>
                        </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><input class="btn btn-dark" type="submit" name="btnsubmit" value="Create Account"></div>
                            </div>
                        </form>
                        </div>
                        <div class="signin">
                            <span>Have an account? <a href="login.php">Go to Login!</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<footer class="py-4 bg-light mt-auto ">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; BENTA.PH 2024</div>
            
        </div>
    </div>
</footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
            <?php
            if(isset($_POST["btnsubmit"])){
                $fullname = $_POST["fullname"];
                $address = $_POST["address"];
                $contact = $_POST["contact"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                
                
                $count = mysqli_num_rows(mysqli_query($con, "select * from accounts where
                username= '$username'"));
                    if($count > 0){ 
                        echo "<span style='color:red'>Username is already exist!</span>";
                    }
                    else{
                        mysqli_query($con, "insert into accounts(fullname, username, password, contact, address)values('$fullname', '$username', '$password', '$contact', '$address')");
                        echo "<script>window.location = 'login.php';</script>";
                    }
            }
            ?>
        </tr>
        </table>
</form>
</html>
