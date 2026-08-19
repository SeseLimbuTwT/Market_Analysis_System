<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once "includes/db.php";

$sql = "SELECT 
            companies.id,
            companies.name,
            companies.symbol,
            companies.sector,
            companies.description,
            company_prices.price,
            company_prices.previous_price
        FROM companies
        JOIN company_prices
        ON companies.id = company_prices.company_id
        ORDER BY companies.name ASC";

$result = $conn->query($sql);

$companies = [];

while ($row = $result->fetch_assoc()) {

    $change = $row['price'] - $row['previous_price'];

    $percentage = $row['previous_price'] != 0
        ? ($change / $row['previous_price']) * 100
        : 0;

    $row['change'] = $change;
    $row['percentage'] = $percentage;

    $companies[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Companies - Market Analyst</title>

    <link rel="stylesheet" href="css/style.css?v=7">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<div class="dashboard">

    <div class="dashboard-header">

        <div>
            <h1>Companies</h1>

            <p>
                Explore all available companies and their market information.
            </p>
        </div>

        <div class="dashboard-actions">

            <a href="index.php" class="dashboard-button">
                <i class="fa-solid fa-chart-line"></i>
                Dashboard
            </a>

        </div>

    </div>


    <div class="market-section">

        <div class="section-header">

            <div>
                <h2>All Companies</h2>

                <p>
                    Current company prices and market movement
                </p>
            </div>

        </div>


        <div class="market-table-container">

            <table class="market-table">

                <thead>

                    <tr>
                        <th>Company</th>
                        <th>Symbol</th>
                        <th>Sector</th>
                        <th>Current Price</th>
                        <th>Previous Price</th>
                        <th>Change</th>
                        <th>Change %</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php if (count($companies) > 0) { ?>

                    <?php foreach ($companies as $company) { ?>

                        <tr>

                            <td>
                                <strong>
                                    <?php echo htmlspecialchars($company['name']); ?>
                                </strong>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($company['symbol']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($company['sector'] ?? 'N/A'); ?>
                            </td>

                            <td>
                                Rs.
                                <?php echo number_format($company['price'], 2); ?>
                            </td>

                            <td>
                                Rs.
                                <?php echo number_format($company['previous_price'], 2); ?>
                            </td>

                            <td class="<?php echo $company['change'] >= 0 ? 'positive' : 'negative'; ?>">

                                <?php if ($company['change'] > 0) { ?>
                                    ↑
                                <?php } elseif ($company['change'] < 0) { ?>
                                    ↓
                                <?php } ?>

                                Rs.
                                <?php echo number_format(abs($company['change']), 2); ?>

                            </td>

                            <td class="<?php echo $company['percentage'] >= 0 ? 'positive' : 'negative'; ?>">

                                <?php if ($company['percentage'] > 0) { ?>
                                    ↑
                                <?php } elseif ($company['percentage'] < 0) { ?>
                                    ↓
                                <?php } ?>

                                <?php echo number_format(abs($company['percentage']), 2); ?>%

                            </td>

                            <td>

                                <a
                                    href="company.php?id=<?php echo $company['id']; ?>"
                                    class="dashboard-button"
                                >
                                    View
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="8">
                            No companies available.
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