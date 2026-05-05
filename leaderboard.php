<!DOCTYPE html>
<?php require_once("asset.php"); ?>
<?php
$leaderboard = mysqli_query($conn,
    "SELECT username, points FROM tbl_user ORDER BY points DESC, username ASC LIMIT 100"
);
 
$myRank  = null;
$myPoints = null;
if (isLevel(10)) {
    $uid = intval($_SESSION['id']);

    $pointsRes = mysqli_query($conn, "SELECT points FROM tbl_user WHERE id = $uid");
    $myPoints  = mysqli_fetch_assoc($pointsRes)['points'];

    $rankRes = mysqli_query($conn, "SELECT COUNT(*) + 1 AS rank_pos FROM tbl_user WHERE points > $myPoints");
    $myRank  = mysqli_fetch_assoc($rankRes)['rank_pos'];
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
    <script>
        document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'auto');
    </script>
</head>
<body>
    <?php require_once "_header.php"; ?>
    <?php require_once "_nav.php"; ?>
    <main>
        <div class="leaderboard-wrap">
            <h1>Leaderboard</h1>
 
            <?php if ($myRank !== null): ?>
                <p class="my-rank">
                    Your rank: <strong>#<?php echo $myRank; ?></strong>
                    Points: <strong><?php echo intval($myPoints); ?></strong>
                </p>
            <?php endif; ?>
 
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Player</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $rank = 1;
                while ($row = mysqli_fetch_assoc($leaderboard)):
                    $isMe = isLevel(10) && $row['username'] === $_SESSION['name'];
                ?>
                    <tr class="<?php
                        if ($isMe) echo ' rank-me';
                    ?>">
                        <td><?php echo $rank; ?></td>
                        <td><?=htmlspecialchars($row['username']); ?><?php if ($isMe) echo ' <span class="you-badge">you</span>'; ?></td>
                        <td><?=intval($row['points']); ?></td>
                    </tr>
                <?php $rank++; endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php require_once "_footer.php"; ?>
</body>
</html>
 