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

$companies = [];

$totalCompanies = 0;
$totalMarketValue = 0;
$gainers = 0;
$losers = 0;
$unchanged = 0;

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
        $gainers++;
    } elseif ($change < 0) {
        $losers++;
    } else {
        $unchanged++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Market Analyst Dashboard</title>

    <link rel="stylesheet" href="css/style.css?v=5">
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<?php include "includes/navbar.php"; ?>

<div class="dashboard">

    <!-- =========================
         DASHBOARD HEADER
    ========================== -->

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


    <!-- =========================
         MARKET CARDS
    ========================== -->

<div class="market-cards">

    <!-- Total Companies -->

    <div class="market-card">

        <div class="card-icon company-icon">
            <span>+</span>
        </div>

        <div>

            <p>Total Companies</p>

            <h2>
                <?php echo $totalCompanies; ?>
            </h2>

        </div>

    </div>


    <!-- Gainers -->

    <div class="market-card">

        <div class="card-icon gainers-icon">
            ↗
        </div>

        <div>

            <p>Gainers</p>

            <h2 class="positive">
                <?php echo $gainers; ?>
            </h2>

        </div>

    </div>


    <!-- Losers -->

    <div class="market-card">

        <div class="card-icon losers-icon">
            ↘
        </div>

        <div>

            <p>Losers</p>

            <h2 class="negative">
                <?php echo $losers; ?>
            </h2>

        </div>

    </div>


    <!-- Unchanged -->

    <div class="market-card">

        <div class="card-icon unchanged-icon">
            −
        </div>

        <div>

            <p>Unchanged</p>

            <h2>
                <?php echo $unchanged; ?>
            </h2>

        </div>

    </div>

</div>

    <!-- =========================
         CHART SECTION
    ========================== -->

    <div class="chart-section">

        <div class="chart-header">

            <div>

                <h2>Market Overview</h2>

                <p>Compare current company prices</p>

            </div>

            <div class="chart-buttons">

                <button
                    type="button"
                    class="chart-button active"
                    onclick="changeChart('bar', this)">
                    Bar
                </button>

                <button
                    type="button"
                    class="chart-button"
                    onclick="changeChart('line', this)">
                    Line
                </button>

                <button
                    type="button"
                    class="chart-button"
                    onclick="changeChart('pie', this)">
                    Pie
                </button>

            </div>

        </div>


        <div class="chart-container">

            <canvas id="marketChart"></canvas>

        </div>

    </div>


    <!-- =========================
         MARKET TABLE
    ========================== -->

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

                            Rs.
                            <?php echo number_format($row['price'], 2); ?>

                        </td>


                        <td>

                            Rs.
                            <?php echo number_format($row['previous_price'], 2); ?>

                        </td>


                        <td class="<?php echo $row['change'] >= 0 ? 'positive' : 'negative'; ?>">

                            <?php if ($row['change'] > 0) { ?>

                                ↑

                            <?php } elseif ($row['change'] < 0) { ?>

                                ↓

                            <?php } ?>

                            <?php echo number_format(abs($row['change']), 2); ?>

                        </td>


                        <td class="<?php echo $row['percentage'] >= 0 ? 'positive' : 'negative'; ?>">

                            <?php if ($row['percentage'] > 0) { ?>

                                ↑

                            <?php } elseif ($row['percentage'] < 0) { ?>

                                ↓

                            <?php } ?>

                            <?php echo number_format(abs($row['percentage']), 2); ?>%

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- =========================
     CHART JAVASCRIPT
========================== -->

<script>

const companyNames = <?php
    echo json_encode(
        array_column($companies, 'symbol')
    );
?>;

const companyPrices = <?php
    echo json_encode(
        array_map(
            'floatval',
            array_column($companies, 'price')
        )
    );
?>;

let currentChart = null;

function createChart(type) {

    const ctx = document
        .getElementById('marketChart')
        .getContext('2d');

    if (currentChart) {
        currentChart.destroy();
    }

    let chartType = type;

    let chartData = {
        labels: companyNames,

        datasets: [{
            label: 'Current Price',

            data: companyPrices,

            borderWidth: 2,

            borderRadius: 6,

            tension: 0.3
        }]
    };


    if (type === 'pie') {

        chartData = {

            labels: companyNames,

            datasets: [{
                label: 'Current Price',

                data: companyPrices,

                borderWidth: 2
            }]

        };

    }


    currentChart = new Chart(ctx, {

        type: chartType,

        data: chartData,

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: type === 'pie'
                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    display: type !== 'pie',

                    title: {

                        display: true,

                        text: 'Price (Rs.)'

                    }

                },

                x: {

                    display: type !== 'pie'

                }

            }

        }

    });

}


function changeChart(type, button) {

    document
        .querySelectorAll('.chart-button')
        .forEach(btn => {
            btn.classList.remove('active');
        });

    button.classList.add('active');

    createChart(type);

}


// Start with bar chart
createChart('bar');

</script>

</body>

</html>