<<<<<<< HEAD
// version from GitHub
=======
// your local version
>>>>>>> a5acee5
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
<<<<<<< HEAD
=======
            companies.id,
>>>>>>> a5acee5 (updated)
            company_prices.previous_price
        FROM companies
        JOIN company_prices
        ON companies.id = company_prices.company_id";

$result = $conn->query($sql);

<<<<<<< HEAD
$totalCompanies = 0;
$totalGainers = 0;
$totalLosers = 0;
$totalMarketValue = 0;

$companies = [];

=======
$companies = [];

$totalCompanies = 0;
$totalChange = 0;
$gainers = 0;
$losers = 0;

>>>>>>> a5acee5 (updated)
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
<<<<<<< HEAD
    $totalMarketValue += $row['price'];

    if ($change > 0) {
        $totalGainers++;
    } elseif ($change < 0) {
        $totalLosers++;
    }
}
=======
    $totalChange += $change;

    if ($change > 0) {
        $gainers++;
    } elseif ($change < 0) {
        $losers++;
    }
}

$unchanged = $totalCompanies - $gainers - $losers;

>>>>>>> a5acee5 (updated)
?>

<!DOCTYPE html>
<html>

<head>

    <title>Market Analyst Dashboard</title>

    <link rel="stylesheet" href="css/style.css?v=3">

</head>

<body>
<<<<<<< HEAD

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

=======
    <?php include "includes/navbar.php"; ?>
    <h1>Market Analyst</h1>

<div class="market-cards">

    <div class="market-card">
        <div class="card-icon">🏢</div>
        <div>
            <p>Total Companies</p>
            <h2><?php echo $totalCompanies; ?></h2>
        </div>
    </div>

    <div class="market-card">
        <div class="card-icon">📈</div>
        <div>
            <p>Gainers</p>
            <h2 class="positive"><?php echo $gainers; ?></h2>
        </div>
    </div>

    <div class="market-card">
        <div class="card-icon">📉</div>
        <div>
            <p>Losers</p>
            <h2 class="negative"><?php echo $losers; ?></h2>
        </div>
    </div>

    <div class="market-card">
        <div class="card-icon">➖</div>
        <div>
            <p>Unchanged</p>
            <h2><?php echo $unchanged; ?></h2>
        </div>
>>>>>>> a5acee5 (updated)
    </div>

</div>

<<<<<<< HEAD
=======
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
        <?php foreach ($companies as $row) { ?>
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
>>>>>>> a5acee5 (updated)
</body>

</html>