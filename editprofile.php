<?php
session_start();

if(!isset($_SESSION["userid"])) {
    // user is not logged in
    header("Location: welcome.php");
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

$stmt = $conn->prepare("SELECT * FROM `user` WHERE `id`=?");
$stmt->bind_param("i", $_SESSION["userid"]);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows !== 1) {
    // user not found
    header("Location: logout.php");
    exit();
}

// fetch every data in the row
$row = $result->fetch_assoc();

// user has not set his age, the "Cancel" button will not be shown
$is_new = $row["age"] === NULL;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="/css/main.css">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.png" />
    <title>USPACE | Edit Profile</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
            <img src="favicon.png" width="30" height="30" class="d-inline-block align-top" alt="brand">
            USPACE
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <?php
                if($is_new) {
                    ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Edit Profile <span class="sr-only">(current)</span></a>
                    </li>
                    <?php
                } else {
                    // show the "Home" link if the user is not new
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Edit Profile <span class="sr-only">(current)</span></a>
                    </li>
                    <?php
                }
                ?>

            </ul>
        </div>
    </nav>
    <div class="container mt-2 mb-3">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" class="form-control" value="<?php echo htmlspecialchars($row["name"]); ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" id="age" class="form-control" value="<?php echo htmlspecialchars($row["age"]); ?>">
                    </div>
                    <div class="form-group">
                        <label for="education">Education</label>
                        <input type="text" id="education" class="form-control" value="<?php echo htmlspecialchars($row["education"]); ?>">
                    </div>
                    <div class="form-group">
                        <label for="hobbies">Hobbies</label>
                        <input type="text" id="hobbies" class="form-control" value="<?php echo htmlspecialchars($row["hobbies"]); ?>">
                    </div>
                    <div class="form-group">
                        <label for="language">Languages</label>
                        <input type="text" id="languages" class="form-control" value="<?php echo htmlspecialchars($row["languages"]); ?>">
                    </div>
                    <div class="form-group">
                        <label for="experience">Working Experience</label>
                        <textarea id="experience" class="form-control" rows="3"><?php echo htmlspecialchars($row["working_experience"]); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea id="bio" class="form-control" rows="5"><?php echo htmlspecialchars($row["bio"]); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="file">Avatar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" accept="image/png,image/gif,image/jpeg">
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                    </div>
                    <div class="row">
                    <?php
                        if(!$is_new) {
                            // show the "Cancel" button if the user is not new
                            ?>
                            <div class="col">
                                <button type="button" id="cancel" class="btn btn-secondary btn-block"><i class="fas fa-times"></i> Cancel</button>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col ml-auto">
                            <button type="button" id="save" class="btn btn-primary btn-block"><i class="fas fa-check"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="/js/editprofile.js"></script>
</body>

</html>