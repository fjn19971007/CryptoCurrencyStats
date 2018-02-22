<?php
$json = file_get_contents("https://poloniex.com/public?command=returnChartData&currencyPair=USDT_ETH&start=1481522400&end=9999999999&period=14400");
$txt = fopen('ethereum.txt','w+') or die("Cannot open file!");
fwrite($txt, $json);
fclose($txt);

$ethereum_last_price = file_get_contents("https://api.cryptonator.com/api/ticker/eth-usd");
$json = json_decode($ethereum_last_price);
$last_price = round($json->ticker->price, 2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ethereum(ETH) Price Stats</title>
    <meta charset="UTF-8">
    <meta name="keywords" content="Ethereum, ETH, Ethereum price, Ethereum Stats">
    <link href="./css/default.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="./js/chart.js"></script>
    <script>
        $.get('ethereum.txt', function(data) {
            var bch_obj = JSON.parse(data);
            var array = [];
            for(var i = 0; i < bch_obj.length; i++) {
                array.push([new Date(bch_obj[i].date * 1000), bch_obj[i].close]);
            }
            Chart(array, "Last 1 Year Price");
        }, 'text');
    </script>
</head>

<body>
    <header class="header">
        <h1>Ethereum Stats</h1>
        <img src="./images/ethereum.png" alt="ethereum" width="150">
    </header>
    <div class="nav">
        <li class="navlink"><a href="BitcoinStat.php" class="center">Bitcoin</a></li>
        <li class="navlink"><a href="BitcoinCashStat.php" class="center">Bitcoin Cash</a></li>
        <li class="navlink"><a href="LitecoinStat.php" class="center">Litecoin</a></li>
        <li class="navlink"><a href="EthereumStat.php" class="center">Ethereum</a></li>
    </div>
    <div class="price">
        <p class="priceTitle" style="font-size: 30px">Ethereum Price</p><br>
    </div>
    <div class="chart">
        <p id="priceNumber"><?php echo '$' . $last_price ?></p>
        <p style="color: #999999">Last Ethereum Price</p>
        <div class="buttonBar">
            <button class="onClick" name="yearChart" id="yearChart" onclick="changeChart(this, 'ethereum.txt')">1Y</button>
            <button class="chartButton" name="monthChart" id="monthChart" onclick="changeChart(this, 'ethereum.txt')">1M</button>
            <button class="chartButton" name="weekChart" id="weekChart" onclick="changeChart(this, 'ethereum.txt')">1W</button>
            <button class="chartButton" name="dayChart" id="dayChart" onclick="changeChart(this, 'ethereum.txt')">1D</button>
        </div>
        <hr>
        <div id="chart"></div>
        <p style="color: #999999"></p>
    </div>
</body>