<?php
session_start();
if(isset($_SESSION["userid"])) {
    // user not logged in
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/welcome.css">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />
    <title>USPACE | Welcome</title>
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="text-center">
                    <img src="/favicon.png">
                    <h1>USPACE</h1>
                </div>
            </div>
            <div class="col-md-6 welcome-height">
                <ul class="nav nav-tabs">
                    <li class="nav-item" role="presentation">
                        <a id="login-tab" class="nav-link active" role="tablist" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="signup-tab" class="nav-link" role="tablist" data-toggle="tab" href="#signup" role="tab" aria-controls="signup" aria-selected="false">Sign Up</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <div class="border-left border-right border-bottom p-3">
                            <form>
                                <div class="form-group">
                                    <label for="lusername">Username</label>
                                    <input type="text" id="lusername" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="lpassword">Password</label>
                                    <input type="password" id="lpassword" class="form-control">
                                </div>
                                <button type="button" id="blogin" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                        <div class="border-left border-right border-bottom p-3">
                            <form>
                                <div class="form-group">
                                    <label for="sname">Name</label>
                                    <input type="text" id="sname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="susername">Username</label>
                                    <input type="text" id="susername" class="form-control">
                                    <small class="form-text text-muted">A unique username not longer than 20 characters</small>
                                </div>
                                <div class="form-group">
                                    <label for="semail">Email</label>
                                    <input type="email" id="semail" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="spassword">Password</label>
                                    <input type="password" id="spassword" class="form-control">
                                </div>

                                <button type="button" id="bsignup" class="btn btn-primary">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="/js/welcome.js"></script>
</body>

</html>