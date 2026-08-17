<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Utility Tools - Market Analyst</title>

    <link rel="stylesheet" href="css/style.css?v=6">

</head>


<body>

<?php include "includes/navbar.php"; ?>


<div class="utilities-page">


    <!-- =========================
         PAGE HEADER
    ========================== -->

    <div class="utilities-header">

        <div>

            <h1>Utility Tools</h1>

            <p>
                Useful calculators for market analysis and investment decisions.
            </p>

        </div>

    </div>



    <!-- =========================
         UTILITY CARDS
    ========================== -->

    <div class="utility-cards">


        <!-- =========================
             PROFIT / LOSS
        ========================== -->

        <div class="utility-card">

            <div class="utility-icon money-icon">
                <span>Rs</span>
            </div>

            <h2>Profit / Loss Calculator</h2>

            <p class="utility-description">
                Calculate your profit or loss from buying and selling.
            </p>


            <div class="utility-form">

                <label for="buyPrice">
                    Buying Price
                </label>

                <input
                    type="number"
                    id="buyPrice"
                    placeholder="Enter buying price"
                    step="0.01"
                >


                <label for="sellPrice">
                    Selling Price
                </label>

                <input
                    type="number"
                    id="sellPrice"
                    placeholder="Enter selling price"
                    step="0.01"
                >


                <button
                    type="button"
                    onclick="calculateProfitLoss()"
                    class="utility-button"
                >
                    Calculate
                </button>

            </div>


            <div
                id="profitResult"
                class="utility-result"
            ></div>

        </div>



        <!-- =========================
             PERCENTAGE CHANGE
        ========================== -->

        <div class="utility-card">

            <div class="utility-icon percentage-icon">
                %
            </div>

            <h2>Percentage Change</h2>

            <p class="utility-description">
                Find the percentage increase or decrease between two values.
            </p>


            <div class="utility-form">

                <label for="oldValue">
                    Old Value
                </label>

                <input
                    type="number"
                    id="oldValue"
                    placeholder="Enter old value"
                    step="0.01"
                >


                <label for="newValue">
                    New Value
                </label>

                <input
                    type="number"
                    id="newValue"
                    placeholder="Enter new value"
                    step="0.01"
                >


                <button
                    type="button"
                    onclick="calculatePercentage()"
                    class="utility-button"
                >
                    Calculate
                </button>

            </div>


            <div
                id="percentageResult"
                class="utility-result"
            ></div>

        </div>



        <!-- =========================
             INVESTMENT RETURN
        ========================== -->

        <div class="utility-card">

            <div class="utility-icon investment-icon">
                ↗
            </div>

            <h2>Investment Return</h2>

            <p class="utility-description">
                Calculate your expected profit and final investment value.
            </p>


            <div class="utility-form">

                <label for="investment">
                    Investment Amount
                </label>

                <input
                    type="number"
                    id="investment"
                    placeholder="Enter investment amount"
                    step="0.01"
                >


                <label for="returnRate">
                    Return Percentage
                </label>

                <input
                    type="number"
                    id="returnRate"
                    placeholder="Enter return percentage"
                    step="0.01"
                >


                <button
                    type="button"
                    onclick="calculateInvestment()"
                    class="utility-button"
                >
                    Calculate
                </button>

            </div>


            <div
                id="investmentResult"
                class="utility-result"
            ></div>

        </div>


    </div>

</div>



<script>


/* =========================
   PROFIT / LOSS CALCULATOR
========================= */

function calculateProfitLoss() {

    let buy = Number(
        document.getElementById("buyPrice").value
    );

    let sell = Number(
        document.getElementById("sellPrice").value
    );


    if (buy <= 0 || sell <= 0) {

        document.getElementById("profitResult").innerHTML =
            "Please enter valid prices.";

        document.getElementById("profitResult").className =
            "utility-result error";

        return;
    }


    let result = sell - buy;


    if (result > 0) {

        document.getElementById("profitResult").innerHTML =
            "Profit: <strong>Rs. " +
            result.toFixed(2) +
            "</strong>";

        document.getElementById("profitResult").className =
            "utility-result profit";

    }

    else if (result < 0) {

        document.getElementById("profitResult").innerHTML =
            "Loss: <strong>Rs. " +
            Math.abs(result).toFixed(2) +
            "</strong>";

        document.getElementById("profitResult").className =
            "utility-result loss";

    }

    else {

        document.getElementById("profitResult").innerHTML =
            "No Profit, No Loss";

        document.getElementById("profitResult").className =
            "utility-result neutral";

    }

}



/* =========================
   PERCENTAGE CALCULATOR
========================= */

function calculatePercentage() {

    let oldValue = Number(
        document.getElementById("oldValue").value
    );

    let newValue = Number(
        document.getElementById("newValue").value
    );


    if (oldValue === 0) {

        document.getElementById("percentageResult").innerHTML =
            "Old value cannot be 0.";

        document.getElementById("percentageResult").className =
            "utility-result error";

        return;
    }


    let change = newValue - oldValue;

    let percentage = (change / oldValue) * 100;


    if (percentage > 0) {

        document.getElementById("percentageResult").innerHTML =
            "Increase: <strong>+" +
            percentage.toFixed(2) +
            "%</strong>";

        document.getElementById("percentageResult").className =
            "utility-result profit";

    }

    else if (percentage < 0) {

        document.getElementById("percentageResult").innerHTML =
            "Decrease: <strong>" +
            percentage.toFixed(2) +
            "%</strong>";

        document.getElementById("percentageResult").className =
            "utility-result loss";

    }

    else {

        document.getElementById("percentageResult").innerHTML =
            "No Change: <strong>0.00%</strong>";

        document.getElementById("percentageResult").className =
            "utility-result neutral";

    }

}



/* =========================
   INVESTMENT CALCULATOR
========================= */

function calculateInvestment() {

    let investment = Number(
        document.getElementById("investment").value
    );

    let rate = Number(
        document.getElementById("returnRate").value
    );


    if (investment <= 0) {

        document.getElementById("investmentResult").innerHTML =
            "Please enter a valid investment amount.";

        document.getElementById("investmentResult").className =
            "utility-result error";

        return;
    }


    let profit = investment * rate / 100;

    let finalAmount = investment + profit;


    document.getElementById("investmentResult").innerHTML =
        "Return: <strong>Rs. " +
        profit.toFixed(2) +
        "</strong>" +
        "<br>" +
        "Final Amount: <strong>Rs. " +
        finalAmount.toFixed(2) +
        "</strong>";

    document.getElementById("investmentResult").className =
        "utility-result profit";

}

</script>


</body>

</html>