<?php
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    // not a POST request
    echo "0";
    exit();
}

session_start();

if(!isset($_SESSION["userid"])) {
    // user is not logged in
    echo "0";
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "0";
    exit();
}

if(!isset($_POST["query"])) {
    // search paramter not found
    echo "0";
    exit();
}

// convert to integer
$user_id = intval($_SESSION["userid"]);

$query = "%" . trim($_POST["query"]) . "%";

$stmt = $conn->prepare("SELECT `id`, `name`, `age`, `username`, `avatar` FROM `user` WHERE `username` LIKE ?");
$stmt->bind_param("s", $query);
$stmt->execute();
$stmt->bind_result($id, $name, $age, $username, $avatar);

$num_results = 0;

//fetch the data row by row
while($stmt->fetch()) {
    // make sure the profile is set up
    // user can search for himself but the result is not clickable
    if($age !== NULL) {
        ?>
        <a class="list-group-item list-group-item-action p-1 <?php echo $id === $user_id ? "result-disabled" : ""; ?>" href="<?php echo $id !== $user_id ? "/viewprofile.php?userid=" . $id : "#"; ?>">
            <div class="d-flex align-items-center">
                <img src="/avatar/<?php echo $avatar; ?>" class="rounded mr-2" width="42" height="42">
                <div>
                    <p class="mb-0 d-block text-truncate"><?php echo htmlspecialchars($name); ?></p>
                    <p class="mb-0 text-muted name-height"><?php echo htmlspecialchars($username); ?></p>
                </div>
            </div>
        </a>
        <?php
        $num_results++;
    }
}

if($num_results === 0) {
    // 0 result
    echo '<li class="list-group-item py-2">No result</li>';
}