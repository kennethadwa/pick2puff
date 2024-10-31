<?php
    include ("../connect.php");
?>
    <section>         
    <div class="container">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="/testing/pics/profile.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                <h5 class="my-3"><?php echo $r['email']; ?></h5>
            </div>
        </div>
        <form method="POST">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-7 text-center">
                            <p class="mb-0">Password</p>
                        </div>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="password" value="<?php echo $r['password']; ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-0">
                        <div class="col-sm-12 text-center">
                            <input class="btn btn-secondary btn-block" type="submit" name="btnupdate" value="Update">
                        </div>
                    </div>
                </div>
            </div>
    </div>

        <?php
            if(isset($_POST["btnupdate"])){
                $password = $_POST["password"];
                mysqli_query($con, "update accounts set password='$password' where email='$email'");
                echo "<script>window.location = 'index.php?pg=update';</script>";
            }
        ?>
    </form>
</section>
