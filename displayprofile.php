<?php
if(!isset($conn) || !isset($row)) {
    // the file is not required by index.php or viewprofile.php
    header("Location: index.php");
    exit();
}
?>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-8">
            <img src="/avatar/<?php echo $row["avatar"]; ?>" class="rounded mx-auto d-block" width="200" height="200">
            <div class="text-center">
                <h3 class="mt-2 mb-0"><?php echo htmlspecialchars($row["name"]); ?></h3>
                <p class="text-muted mb-1"><?php echo htmlspecialchars($row["username"]); ?></p>
                <p class="text-muted">Joined on <?php echo $row["joined"]; ?></p>
                <?php
                if(!isset($is_following)) {
                    // this file is required by index.php
                    echo '<a class="btn btn-primary mb-3" href="/editprofile.php"><i class="fas fa-edit"></i> Edit Profile</a>';
                } else {
                    // this file is required by viewprofile.php
                    // display the "Unfollow" button if the user is following this user, or "Follow" button if not
                    if($is_following) {
                        echo '<a class="btn btn-danger mb-3" href="follow.php?mode=0&userid=' . $view_user_id . '"><i class="fas fa-minus"></i> Unfollow</a>';
                    } else {
                        echo '<a class="btn btn-success mb-3" href="follow.php?mode=1&userid=' . $view_user_id . '"><i class="fas fa-plus"></i> Follow</a>';
                    }
                }
                ?>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Bio</h5>
                    <p class="card-text"><?php echo htmlspecialchars($row["bio"]); ?></p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">
                        <i class="fas fa-sm fa-birthday-cake"></i>
                        <?php echo htmlspecialchars($row["age"]); ?>
                        years old
                    </p>
                    <p class="card-text">
                        <i class="fas fa-sm fa-university"></i>
                        <?php echo htmlspecialchars($row["education"]); ?>
                    </p>
                    <p class="card-text">
                        <i class="fas fa-sm fa-biking"></i>
                        <?php echo htmlspecialchars($row["hobbies"]); ?>
                    </p>
                    <p class="card-text">
                        <i class="fas fa-sm fa-language"></i>
                        <?php echo htmlspecialchars($row["languages"]); ?>
                    </p>
                    <p class="card-text">
                        <i class="fas fa-sm fa-envelope"></i>
                        <a href="mailto:<?php echo htmlspecialchars($row["email"]); ?>"><?php echo htmlspecialchars($row["email"]); ?></a>
                    </p>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Working Experience</h5>
                    <p class="card-text"><?php echo htmlspecialchars($row["working_experience"]); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Following (<?php echo count($following); ?>)</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    if (count($following) === 0) {
                        if(!isset($is_following)) {
                            echo '<li class="list-group-item text-muted">To follow a person, go to their profile and press the Follow button</li>';
                        } else {
                            echo '<li class="list-group-item text-muted">Not following anyone</li>';
                        }
                    } else {
                        foreach ($following as $item) {
                        ?>
                        <a class="list-group-item list-group-item-action p-1" href="/viewprofile.php?userid=<?php echo $item["userid"]; ?>">
                            <div class="d-flex align-items-center">
                                <img src="/avatar/<?php echo $item["avatar"]; ?>" class="rounded mr-2" width="42" height="42">
                                <div>
                                    <p class="mb-0 d-block text-truncate"><?php echo htmlspecialchars($item["name"]); ?></p>
                                    <p class="mb-0 text-muted name-height"><?php echo htmlspecialchars($item["username"]); ?></p>
                                </div>
                            </div>
                        </a>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Followers (<?php echo count($followers); ?>)</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    if (count($followers) === 0) {
                        if(!isset($is_following)) {
                            echo '<li class="list-group-item text-muted">You have no followers</li>';
                        } else {
                            echo '<li class="list-group-item text-muted">No followers</li>';
                        }
                    } else {
                        foreach ($followers as $item) {
                            ?>
                            <a class="list-group-item list-group-item-action p-1" href="/viewprofile.php?userid=<?php echo $item["userid"]; ?>">
                                <div class="d-flex align-items-center">
                                    <img src="/avatar/<?php echo $item["avatar"]; ?>" class="rounded mr-2" width="42" height="42">
                                    <div>
                                        <p class="mb-0 d-block text-truncate"><?php echo htmlspecialchars($item["name"]); ?></p>
                                        <p class="mb-0 text-muted name-height"><?php echo htmlspecialchars($item["username"]); ?></p>
                                    </div>
                                </div>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>