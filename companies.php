<?php
require_once "includes/db.php";

$sql = "SELECT * FROM companies";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Companies - Market Analyst</title>
     <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include "includes/navbar.php"; ?>

<h1>Companies</h1>

<p>Select a company to view its analysis.</p>

<ul>

<?php while ($row = $result->fetch_assoc()) { ?>

    <li>
        <a href="company.php?id=<?php echo $row['id']; ?>">
            <?php echo $row['name']; ?>
            (<?php echo $row['symbol']; ?>)
        </a>
    </li>

<?php } ?>

</ul>

</body>
</html>