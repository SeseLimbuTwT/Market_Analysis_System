<?php

require_once "includes/db.php";

$sql = "SELECT 
            companies.name,
            companies.symbol,
            company_prices.price,
                 companies.id,
            company_prices.previous_price
         
        FROM companies
        JOIN company_prices
     ON companies.id = company_prices.company_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Market Analyst</title>
     <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include "includes/navbar.php"; ?>
    <h1>Market Analyst</h1>
    <h2>Current Market</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Company</th>
            <th>Symbol</th>
            <th>Current Price</th>
            <th>Previous Price</th>
            <th>Change</th>
            <th>Change %</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <?php
                $change = $row['price'] - $row['previous_price'];
                $percentage = ($change / $row['previous_price']) * 100;
            ?>
            <tr>
                <td>
    <a href="company.php?id=<?php echo $row['id']; ?>">
        <?php echo $row['name']; ?>
    </a>
</td>
                <td><?php echo $row['symbol']; ?></td>
                <td>Rs. <?php echo $row['price']; ?></td>
                <td>Rs. <?php echo $row['previous_price']; ?></td>
                <td><?php echo number_format($change, 2); ?></td>
                <td><?php echo number_format($percentage, 2); ?>%</td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>