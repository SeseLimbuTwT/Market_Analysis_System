<!DOCTYPE html>
<html>
<head>
    <title>Utility Tools - Market Analyst</title>
     <link rel="stylesheet" href="css/style.css">
</head>

<body>

<?php include "includes/navbar.php"; ?>

<h1>Utility Tools</h1>

<!-- Profit / Loss Calculator -->
<h2>Profit / Loss Calculator</h2>

<label>Buying Price:</label>
<input type="number" id="buyPrice">

<br><br>

<label>Selling Price:</label>
<input type="number" id="sellPrice">

<br><br>

<button onclick="calculateProfitLoss()">Calculate</button>

<p id="profitResult"></p>


<hr>


<!-- Percentage Change Calculator -->
<h2>Percentage Change Calculator</h2>

<label>Old Value:</label>
<input type="number" id="oldValue">

<br><br>

<label>New Value:</label>
<input type="number" id="newValue">

<br><br>

<button onclick="calculatePercentage()">Calculate</button>

<p id="percentageResult"></p>


<hr>


<!-- Investment Calculator -->
<h2>Investment Return Calculator</h2>

<label>Investment Amount:</label>
<input type="number" id="investment">

<br><br>

<label>Return Percentage:</label>
<input type="number" id="returnRate">

<br><br>

<button onclick="calculateInvestment()">Calculate</button>

<p id="investmentResult"></p>


<script>

function calculateProfitLoss() {

    let buy = Number(document.getElementById("buyPrice").value);
    let sell = Number(document.getElementById("sellPrice").value);

    let result = sell - buy;

    if (result > 0) {
        document.getElementById("profitResult").innerHTML =
            "Profit: Rs. " + result.toFixed(2);
    }
    else if (result < 0) {
        document.getElementById("profitResult").innerHTML =
            "Loss: Rs. " + Math.abs(result).toFixed(2);
    }
    else {
        document.getElementById("profitResult").innerHTML =
            "No Profit, No Loss";
    }
}


function calculatePercentage() {

    let oldValue = Number(document.getElementById("oldValue").value);
    let newValue = Number(document.getElementById("newValue").value);

    if (oldValue === 0) {
        document.getElementById("percentageResult").innerHTML =
            "Old value cannot be 0.";
        return;
    }

    let change = newValue - oldValue;

    let percentage = (change / oldValue) * 100;

    document.getElementById("percentageResult").innerHTML =
        "Percentage Change: " + percentage.toFixed(2) + "%";
}


function calculateInvestment() {

    let investment = Number(document.getElementById("investment").value);
    let rate = Number(document.getElementById("returnRate").value);

    let profit = investment * rate / 100;

    let finalAmount = investment + profit;

    document.getElementById("investmentResult").innerHTML =
        "Profit: Rs. " + profit.toFixed(2) +
        "<br>Final Amount: Rs. " + finalAmount.toFixed(2);
}

</script>

</body>
</html> 