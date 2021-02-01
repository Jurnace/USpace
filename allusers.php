<?php
session_start();
if(!isset($_SESSION["userid"])) {
    // user not logged in
    header("Location: welcome.php");
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

$stmt = $conn->prepare("SELECT * FROM `user`");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />
    <title>USPACE | All Users</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark">
        <a class="navbar-brand" href="#">
            <img src="/favicon.png" width="30" height="30" class="d-inline-block align-top" alt="">
            USPACE
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">All Users <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <div class="navbar-nav mx-auto">
                <form class="form-inline position-relative">
                    <input id="search" class="form-control mr-sm-2 search-bar" type="search" placeholder="Search" aria-label="Search">
                    <ul id="result" class="list-group search-box d-none"></ul>
                </form>
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/account.php">Account Settings</a>
                        <a class="dropdown-item" href="/logout.php">Logout</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
    <div class="container mt-2">
        <div class="row">
            <?php
            while($row = $result->fetch_assoc())
            {
                // user has set up his account
                if($row["age"] !== NULL) {
                    ?>
                    <div class="col-6 col-md-3">
                        <div class="card m-1 mb-4">
                            <img src="/avatar.php?img=<?php echo $row["avatar"]; ?>" class="card-img-top img-fluid">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row["name"]); ?></h5>
                                <a href="/viewprofile.php?userid=<?php echo $row["id"]; ?>" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }

            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="/js/index.js"></script>
</body>

</html>