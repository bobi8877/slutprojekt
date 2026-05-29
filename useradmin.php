<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
if (!isLevel(100)) {
    header("Location: index.php");
    exit;
}

$message = "";

if (isset($_POST['delete_user'])) {
    $del_id = intval($_POST['user_id']);
    
    if ($del_id === intval($_SESSION['id'])) {
        $message = "You cannot delete your own account.";
    } else {
        mysqli_query($conn, "DELETE FROM tbl_solved WHERE user_id = $del_id");
        mysqli_query($conn, "DELETE FROM tbl_user WHERE id = $del_id");
        $message = "User deleted successfully!";
    }
}
if (isset($_POST['update_user'])) {
    $edit_id = intval($_POST['user_id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $mail = mysqli_real_escape_string($conn, $_POST['mail']);
    $level = intval($_POST['level']);
    $points = intval($_POST['points']);

    $sql = "UPDATE tbl_user SET username='$username', mail='$mail', userlevel=$level, points=$points";

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql .= ", password='$password'";
    }

    $sql .= " WHERE id = $edit_id";

    if (mysqli_query($conn, $sql)) {
        $message = "User updated successfully!";
    } else {
        $message = "Error updating user.";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Administration</title>
    <script src="app.js" defer></script>
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'auto');
    </script>
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    <main>
        
        <?php 
        if (isset($_GET['edit'])):
            $edit_id = intval($_GET['edit']);
            $res = mysqli_query($conn, "SELECT * FROM tbl_user WHERE id = $edit_id");
            if ($row = mysqli_fetch_assoc($res)):
        ?>
        <form method="POST" action="useradmin.php">
            <h1 class="edit-user-title">Edit User: <?= htmlspecialchars($row['username']) ?></h1>
            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">

            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($row['username']) ?>" required>

            <label for="mail">Email</label>
            <input type="email" name="mail" id="mail" value="<?= htmlspecialchars($row['mail']) ?>" required>

            <label for="password">Password (leave blank to keep current)</label>
            <input type="password" name="password" id="password" placeholder="New password (min 8 chars)" pattern=".{8,}">

            <label for="level">User Level (10 = user, 100 = admin)</label>
            <input type="number" name="level" id="level" value="<?= isset($row['userlevel']) ? $row['userlevel'] : 10 ?>" required>

            <label for="points">Points</label>
            <input type="number" name="points" id="points" value="<?= isset($row['points']) ? $row['points'] : 0 ?>" required>

            <input class="submit" type="submit" name="update_user" value="Save Changes">
            <a href="useradmin.php" class="cancel-link">Cancel</a>
        </form>
        
        <?php else: ?>
            <div class="leaderboard-wrap">
                <h1>User not found.</h1>
                <a href="useradmin.php">Go back</a>
            </div>
        <?php endif; ?>

        <?php 
        else: ?>
        <div class="leaderboard-wrap admin-wrap">
            <h1>User Administration</h1>
            
            <?php if ($message) echo "<p class='admin-message'>$message</p>"; ?>

            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Level</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM tbl_user ORDER BY id ASC");
                    while ($row = mysqli_fetch_assoc($res)):
                    ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= isset($row['userlevel']) ? $row['userlevel'] : 10 ?></td>
                        <td><?= isset($row['points']) ? $row['points'] : 0 ?></td>
                        <td>
                            <a href="useradmin.php?edit=<?= $row['id'] ?>" class="action-link">Edit</a>
                            
                            <form method="POST" class="delete-form">
                                <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                <input type="submit" name="delete_user" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
    </main>
    <?php require_once "_footer.php"; ?>    
</body>
</html>