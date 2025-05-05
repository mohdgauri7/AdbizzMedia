<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include 'partials/_dbconnect.php';

    if($_POST["userType"] == "publisher"){
        $email = $_POST["email"];
        $password = $_POST["password"]; 
         
        $sql = "Select * from publishers where email='$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1){
            while($row = mysqli_fetch_assoc($result)){
                if (password_verify($password, $row['password'])){
                    if($row['status'] == "active"){
                        $showAlert = true;
                        session_start();
                        $_SESSION['isLogin'] = true;
                        $_SESSION['email'] = $email;
                        $_SESSION["pubId"] = $row['id'];
                        header("location: publisher/index.php");
                        
                    }else{
                        $showError = "Access Denied, Inactive Account!";
                    }
                } 
                else{
                    $showError = "Invalid Credentials";
                }
            }
        } 
        else{
            $showError = "User does not exists!";
        }
    }else if($_POST["userType"] == "admin"){
        $email = $_POST["email"];
        $password = $_POST["password"]; 
         
        $sql = "Select * from admins where email='$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1){
            while($row = mysqli_fetch_assoc($result)){
                if (password_verify($password, $row['password'])){
                    if($row['status'] == "active"){
                        $showAlert = true;
                        session_start();
                        $_SESSION['isLogin'] = true;
                        $_SESSION['email'] = $email;
        
                        header("location: admin/index.php");
                        
                    }else{
                        $showError = "Access Denied, Inactive Account!";
                    }
                } 
                else{
                    $showError = "Invalid Credentials";
                }
            }
        } 
        else{
            $showError = "User does not exists!";
        }

    }else if($_POST["userType"] == "superAdmin"){
        $email = $_POST["email"];
        $password = $_POST["password"]; 
         
        $sql = "Select * from users where email='$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1){
            while($row = mysqli_fetch_assoc($result)){
                if (password_verify($password, $row['password'])){
                    if($row['account_status'] == "approved"){
                        $showAlert = true;
                        session_start();
                        $_SESSION['isLogin'] = true;
                        $_SESSION['email'] = $email;
        
                        header("location: superAdmin/index.php");
                        
                    }else{
                        $showError = "Please wait for the account approval, Thanks!";
                    }
                } 
                else{
                    $showError = "Invalid Credentials";
                }
            }
        } 
        else{
            $showError = "User does not exists!";
        }
    }else{
        $showError = "User type didn't matched";
    }
}
    
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Panel</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">

        <?php
        if($showAlert){
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your account is now created and you can login
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
        }
        if($showError){
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> '. $showError.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> ';
        }
        ?>

        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="login.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required/>
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>

                                            <select class="form-control form-control-md my-3" name="userType">
                                                <option value=""> -- Login As -- </option>
                                                <option value="publisher">Publisher</option>
                                                <option value="admin">Admin</option>
                                                <option value="superAdmin">Super Admin</option>
                                            </select>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                                <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <!-- <a class="small" href="password.php">Forgot Password?</a> -->
                                                <a class="small" href="#">Forgot Password?</a>
                                                <button type="submit" class="btn btn-primary">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <!-- <div class="small"><a href="register.php">Need an account? Sign up!</a></div> -->
                                        <div class="small"><a href="#">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto bg-dark">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
