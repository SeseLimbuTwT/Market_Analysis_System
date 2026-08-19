<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$isCompanies = ($currentPage === 'companies.php' || $currentPage === 'company.php');
?>

<nav>
    <h2>Market Analyst</h2>

    <a href="index.php" class="<?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">
        <i class="fa-solid fa-chart-line"></i> Dashboard
    </a>
    <a href="companies.php" class="<?php echo $isCompanies ? 'active' : ''; ?>">
        <i class="fa-solid fa-building"></i> Companies
    </a>
    <a href="utilities.php" class="<?php echo $currentPage === 'utilities.php' ? 'active' : ''; ?>">
        <i class="fa-solid fa-calculator"></i> Utilities
    </a>
    <a href="logout.php">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</nav>

<hr>