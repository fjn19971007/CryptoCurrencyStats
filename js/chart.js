function changeChart(button, txt) {
    var d = new Date();
    var title = "";
    setButtonColor(button);
    switch (button.id) {
        case "yearChart":
            d.setFullYear(d.getFullYear() - 1);
            var unix = Math.round(d / 1000);
            title = "Last 1 Year Price";
            break;
        case "monthChart":
            d.setMonth(d.getMonth() - 1);
            var unix = Math.round(d / 1000);
            title = "Last 1 Month Price";
            break;
        case "weekChart":
            d.setDate(d.getDate() - 7);
            var unix = Math.round(d / 1000);
            title = "Last 1 Week Price";
            break;
        case "dayChart":
            d.setDate(d.getDate() - 1);
            var unix = Math.round(d / 1000);
            title = "Last 1 Day Price";
            break;
        default:
            d.setFullYear(d.getFullYear() - 1);
            var unix = Math.round(d / 1000);
            title = "Last 1 Year Price";
    }
    $.get(txt, function(data) {
        var json = JSON.parse(data);
        var array = timeInterval(unix, json);;
        Chart(array, title);
    }, 'text');
}

function Chart(array, title) {
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'Date');
        data.addColumn('number', 'USD');

        data.addRows(array);

        var options = {
            axes: {
                x: {
                    0: {side: 'top'}
                }
            },
            hAxis: {
                title: title
            },
            vAxis: {
                title: 'USD'
            },
            series: {
                0: { color: '#ffcc6d' }
            },
            height: 400
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart'));

        chart.draw(data, options);
    }
}

function timeInterval(startTime, json) {
    var array = [];
    for(var i = 0; i < json.length; i++) {
        if(json[i].date >= startTime) {
            array.push([new Date(json[i].date * 1000), json[i].close]);
            console.log(new Date(json[i].date * 1000));
        }
    }
    return array;
}

function setButtonColor(button) {
    var allButtons = document.getElementsByClassName('onClick');
    for(var i = 0; i < allButtons.length; i++) {
        allButtons[i].setAttribute("class", "chartButton");
    }
    button.setAttribute("class", "onClick");
}

