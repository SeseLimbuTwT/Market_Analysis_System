<?php

require_once "includes/db.php";

$id = $_GET['id'];

$sql = "SELECT 
            companies.name,
            companies.symbol,
            companies.sector,
            companies.description,
            company_prices.price,
            company_prices.previous_price
        FROM companies
        JOIN company_prices
        ON companies.id = company_prices.company_id
        WHERE companies.id = $id";

$result = $conn->query($sql);

$company = $result->fetch_assoc();

$sql2 = "SELECT *
         FROM company_financials
         WHERE company_id = $id
         ORDER BY id DESC
         LIMIT 1";

$result2 = $conn->query($sql2);

$financial = $result2->fetch_assoc();

$change = $company['price'] - $company['previous_price'];
$percentage = ($change / $company['previous_price']) * 100;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Company Analysis</title>
     <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php include "includes/navbar.php"; ?>
    <h1><?php echo $company['name']; ?> (<?php echo $company['symbol']; ?>)</h1>

    <p>
        <?php echo $company['description']; ?>
    </p>

    <h2>Price Analysis</h2>

    <p>Current Price: Rs. <?php echo $company['price']; ?></p>

    <p>Previous Price: Rs. <?php echo $company['previous_price']; ?></p>

    <p>Price Change: <?php echo number_format($change, 2); ?></p>

    <p>Percentage Change: <?php echo number_format($percentage, 2); ?>%</p>


    <h2>Financial Analysis</h2>

    <p>Period: <?php echo $financial['period']; ?></p>

    <p>Revenue: Rs. <?php echo number_format($financial['revenue'], 2); ?></p>

    <p>Expenses: Rs. <?php echo number_format($financial['expenses'], 2); ?></p>

    <p>Net Profit: Rs. <?php echo number_format($financial['net_profit'], 2); ?></p>

    <p>Net Loss: Rs. <?php echo number_format($financial['net_loss'], 2); ?></p>
<h2>Price Comparison</h2>

<div style="width: 500px;">

    <p>Previous Price: Rs. <?php echo $company['previous_price']; ?></p>

    <div style="background: #ddd; width: 100%; height: 30px;">
        <div style="
            background: #777;
            width: <?php echo ($company['previous_price'] / $company['price']) * 100; ?>%;
            height: 30px;
        "></div>
    </div>

    <p>Current Price: Rs. <?php echo $company['price']; ?></p>

    <div style="background: #ddd; width: 100%; height: 30px;">
        <div style="
            background: #333;
            width: 100%;
            height: 30px;
        "></div>
    </div>

</div>


<h2>Financial Analysis</h2>

<p>Revenue: Rs. <?php echo number_format($financial['revenue'], 2); ?></p>

<div style="background: #ddd; width: 500px; height: 30px;">
    <div style="
        background: #555;
        width: 100%;
        height: 30px;
    "></div>
</div>

<p>Expenses: Rs. <?php echo number_format($financial['expenses'], 2); ?></p>

<div style="background: #ddd; width: 500px; height: 30px;">
    <div style="
        background: #999;
        width: <?php echo ($financial['expenses'] / $financial['revenue']) * 100; ?>%;
        height: 30px;
    "></div>
</div>
</body>
</html>