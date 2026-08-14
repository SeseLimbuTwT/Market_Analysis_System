<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "includes/db.php";

$sql = "SELECT 
            companies.name,
            companies.symbol,
            companies.id,
            company_prices.price,
            company_prices.previous_price
        FROM companies
        JOIN company_prices
        ON companies.id = company_prices.company_id";

$result = $conn->query($sql);

$totalCompanies = 0;
$totalGainers = 0;
$totalLosers = 0;
$totalMarketValue = 0;

$companies = [];

while ($row = $result->fetch_assoc()) {

    $change = $row['price'] - $row['previous_price'];

    if ($row['previous_price'] != 0) {
        $percentage = ($change / $row['previous_price']) * 100;
    } else {
        $percentage = 0;
    }

    $row['change'] = $change;
    $row['percentage'] = $percentage;

    $companies[] = $row;

    $totalCompanies++;
    $totalMarketValue += $row['price'];

    if ($change > 0) {
        $totalGainers++;
    } elseif ($change < 0) {
        $totalLosers++;
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Market Analyst Dashboard</title>

    <link rel="stylesheet" href="css/style.css?v=3">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<div class="dashboard">

    <!-- Welcome Section -->

    <div class="dashboard-header">

        <div>
            <h1>Market Dashboard</h1>

            <p>
                Welcome back,
                <strong>
                    <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                </strong>
            </p>

            <span>
                Here's your current market overview.
            </span>
        </div>

        <div class="dashboard-actions">

            <a href="utilities.php" class="dashboard-button">
                Utilities
            </a>

            <a href="logout.php" class="logout-button">
                Logout
            </a>

        </div>

    </div>


    <!-- Summary Cards -->

    <div class="dashboard-cards">

        <div class="dashboard-card">

            <h3>Total Companies</h3>

            <p>
                <?php echo $totalCompanies; ?>
            </p>

        </div>


        <div class="dashboard-card">

            <h3>Market Value</h3>

            <p>
                Rs. <?php echo number_format($totalMarketValue, 2); ?>
            </p>

        </div>


        <div class="dashboard-card">

            <h3>Gainers</h3>

            <p>
                <?php echo $totalGainers; ?>
            </p>

        </div>


        <div class="dashboard-card">

            <h3>Losers</h3>

            <p>
                <?php echo $totalLosers; ?>
            </p>

        </div>

    </div>


    <!-- Market Section -->

    <div class="market-section">

        <div class="section-header">

            <div>

                <h2>Current Market</h2>

                <p>
                    Latest available company prices
                </p>

            </div>

            <a href="companies.php">
                View All Companies →
            </a>

        </div>


        <div class="market-table-container">

            <table class="market-table">

                <thead>

                    <tr>

                        <th>Company</th>
                        <th>Symbol</th>
                        <th>Current Price</th>
                        <th>Previous Price</th>
                        <th>Change</th>
                        <th>Change %</th>

                    </tr>

                </thead>


                <tbody>

                <?php foreach ($companies as $row) { ?>

                    <tr>

                        <td>

                            <a href="company.php?id=<?php echo $row['id']; ?>">

                                <?php echo htmlspecialchars($row['name']); ?>

                            </a>

                        </td>


                        <td>

                            <?php echo htmlspecialchars($row['symbol']); ?>

                        </td>


                        <td>

                            Rs. <?php echo number_format($row['price'], 2); ?>

                        </td>


                        <td>

                            Rs. <?php echo number_format($row['previous_price'], 2); ?>

                        </td>


                        <td class="<?php echo $row['change'] >= 0 ? 'positive' : 'negative'; ?>">

                            <?php echo number_format($row['change'], 2); ?>

                        </td>


                        <td class="<?php echo $row['percentage'] >= 0 ? 'positive' : 'negative'; ?>">

                            <?php echo number_format($row['percentage'], 2); ?>%

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>