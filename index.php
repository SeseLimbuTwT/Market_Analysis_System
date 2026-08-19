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
$topGainer = null;
$topLoser = null;
$totalPercentage = 0;
while ($row = $result->fetch_assoc()) {

    $change = $row['price'] - $row['previous_price'];

    if ($row['previous_price'] != 0) {
        $percentage = ($change / $row['previous_price']) * 100;
    } else {
        $percentage = 0;
    }

    $row['change'] = $change;
    $row['percentage'] = $percentage;
$totalPercentage += $percentage;

if ($topGainer === null || $percentage > $topGainer['percentage']) {
    $topGainer = $row;
}

if ($topLoser === null || $percentage < $topLoser['percentage']) {
    $topLoser = $row;
}
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
$averagePercentage = $totalCompanies > 0
    ? $totalPercentage / $totalCompanies
    : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Market Analyst Dashboard</title>

    <link rel="stylesheet" href="css/style.css?v=7">
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
            <i class="fa-solid fa-building"></i>
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
            <i class="fa-solid fa-arrow-trend-up"></i>
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
            <i class="fa-solid fa-arrow-trend-down"></i>
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
            <i class="fa-solid fa-minus"></i>
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


    <!-- =========================
         MARKET INSIGHTS
    ========================== -->

    <div class="insights-section">

        <div class="section-title">
            <h2>Market Insights</h2>
            <p>Quick analysis of today's market movement</p>
        </div>

        <div class="insights-grid">

            <!-- Top Gainer -->
            <div class="insight-card">
                <div class="insight-icon positive-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>

                <div>
                    <span>Top Gainer</span>

                    <?php if ($topGainer) { ?>

                        <h3>
                            <?php echo htmlspecialchars($topGainer['name']); ?>
                        </h3>

                        <p class="positive">
                            +<?php echo number_format($topGainer['percentage'], 2); ?>%
                        </p>

                    <?php } ?>
                </div>
            </div>


            <!-- Top Loser -->
            <div class="insight-card">
                <div class="insight-icon negative-icon"><i class="fa-solid fa-arrow-trend-down"></i></div>

                <div>
                    <span>Top Loser</span>

                    <?php if ($topLoser) { ?>

                        <h3>
                            <?php echo htmlspecialchars($topLoser['name']); ?>
                        </h3>

                        <p class="negative">
                            <?php echo number_format($topLoser['percentage'], 2); ?>%
                        </p>

                    <?php } ?>
                </div>
            </div>


            <!-- Average Movement -->
            <div class="insight-card">
                <div class="insight-icon"><i class="fa-solid fa-percent"></i></div>

                <div>
                    <span>Average Market Change</span>

                    <h3>
                        <?php echo number_format($averagePercentage, 2); ?>%
                    </h3>

                    <p>
                        Across <?php echo $totalCompanies; ?> companies
                    </p>
                </div>
            </div>

        </div>

    </div>


    <!-- =========================
         MARKET SUMMARY
    ========================== -->

    <div class="summary-section">

        <div class="section-title">
            <h2>Market Summary</h2>
            <p>A quick overview of the current market</p>
        </div>

        <div class="summary-content">

            <div>
                <h3>Market Activity</h3>

                <?php if ($gainers > $losers) { ?>

                    <p>
                        The market is showing a
                        <strong class="positive">positive movement</strong>
                        with more companies gaining than losing.
                    </p>

                <?php } elseif ($losers > $gainers) { ?>

                    <p>
                        The market is showing a
                        <strong class="negative">negative movement</strong>
                        with more companies losing than gaining.
                    </p>

                <?php } else { ?>

                    <p>
                        The market is currently
                        <strong>balanced</strong>,
                        with an equal number of gainers and losers.
                    </p>

                <?php } ?>

            </div>

            <div class="summary-stats">

                <div>
                    <span>Total Companies</span>
                    <strong><?php echo $totalCompanies; ?></strong>
                </div>

                <div>
                    <span>Gainers</span>
                    <strong class="positive"><?php echo $gainers; ?></strong>
                </div>

                <div>
                    <span>Losers</span>
                    <strong class="negative"><?php echo $losers; ?></strong>
                </div>

                <div>
                    <span>Unchanged</span>
                    <strong><?php echo $unchanged; ?></strong>
                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         ABOUT SECTION
    ========================== -->

    <div class="about-section">

        <h2>About Market Analyst</h2>

        <p>
            Market Analyst is a web-based market analysis system
            designed to help users monitor company prices,
            compare market movements and perform useful
            financial calculations.
        </p>

        <p>
            Use the dashboard to monitor the current market,
            explore individual companies and use the available
            analysis tools to support your investment decisions.
        </p>

    </div>


</div>


<!-- =========================
     FOOTER
========================== -->

<footer class="site-footer">

    <div>
        <h3>Market Analyst</h3>

        <p>
            Simple tools for monitoring and analyzing
            market information.
        </p>
    </div>

    <div class="footer-links">

        <a href="index.php">Dashboard</a>
        <a href="companies.php">Companies</a>
        <a href="utilities.php">Utilities</a>
        <a href="logout.php">Logout</a>

    </div>

    <p class="copyright">
        © <?php echo date("Y"); ?> Market Analyst. All rights reserved.
    </p>

</footer>


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