<?php
    include ("connect.php");
?>
    <section>         
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="/BENTA.PH/pics/profile.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?php echo $acc['email']; ?></h5>
                        </div>
                    </div>
                </div>
                <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST">
                                    <div class="row mb-2">
                                        <div class="col-sm-7 text-center">
                                            <p class="mb-0">Full Name</p>
                                        </div>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="fullname" value="<?php echo $acc['fullname']; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-sm-7 text-center">
                                            <p class="mb-0">Full Delivery Address</p>
                                        </div>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="address" value="<?php echo $acc['address']; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-sm-7 text-center">
                                            <p class="mb-0">Contact Number</p>
                                        </div>
                                        <div class="col-sm-5">
                                            <input class="form-control" type="text" name="contact" value="<?php echo $acc['contact']; ?>">
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
                </div>
            </div>
                        <?php
                            if(isset($_POST["btnupdate"])){
                                $fullname = $_POST["fullname"];
                                $address = $_POST["address"];
                                $contact = $_POST["contact"];
                                mysqli_query($con, "update accounts set fullname='$fullname', address='$address', contact='$contact' where id=$id");
                                echo "<script>window.location = 'index.php?pg=update';</script>";
                            }
                        ?>                     
            </form>
        </section>
