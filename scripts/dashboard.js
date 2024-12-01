window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer", {
        theme: "light2", 
        animationEnabled: true,
        exportEnabled: true,
        zoomEnabled: true,
        title: {
            text: "Difference of Amount Charged & Amount Paid by Customers",
            fontFamily: "Jost, sans-serif",
            fontColor: "#38a095",
        },
        axisX: {
            title: "Date",
            valueFormatString: "DD MMM",
            fontFamily: "Jost, sans-serif",
        },
        axisY: {
            title: "Amount",
            prefix: "₱",
            fontFamily: "Jost, sans-serif"
        },
        legend:{
            cursor: "pointer",
            itemclick: toggleDataSeries,
            fontFamily: "Jost, sans-serif"
	    },
        toolTip: {
            shared: true,
            fontFamily: "Jost, sans-serif",
        },
        backgroundColor: "white",
        data: [{
            type: "splineArea",
            name: "Charge Amount",
            showInLegend: true,
            xValueFormatString: "DD MMM",
            yValueFormatString: "₱#,###.##",
            dataPoints: chartData.map(function(item) {
                return { x: new Date(item.transDate + ' ' + item.transTime), y: parseFloat(item.transChargeAmount) };
            })
        },{
            type: "splineArea",
            name: "Amount Paid",
            showInLegend: true,
            xValueFormatString: "DD MMM",
            yValueFormatString: "₱#,###.##",
            dataPoints: chartData.map(function(item) {
                return { x: new Date(item.transDate + ' ' + item.transTime), y: parseFloat(item.transAmountPaid) };
            })
        }]
    });

    chart.render();

    function toggleDataSeries(e){
        if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
            e.dataSeries.visible = false;
        }
        else{
            e.dataSeries.visible = true;
        }
        chart.render();
    }


    // Use the JSON data in JavaScript to create a chart
    var chart = new CanvasJS.Chart("pieContainer", {
        theme: "light2", 
        animationEnabled: true,
        exportEnabled: true,
        title: {

            text: "Service Distribution",
            fontFamily: "Jost, sans-serif",
            fontColor: "#38a095",
        },
        data: [{
            type: "pie",
            toolTipContent: "{y} (#percent %)",
            dataPoints: dataPoints // No need for PHP echo in an external JS file
        }]
    });

    chart.render();

    var barDataPoints = [];
    barDataPoints.push({ label: "Child", y: barChartData.Child });
    barDataPoints.push({ label: "Teenager", y: barChartData.Teenager });
    barDataPoints.push({ label: "Young Adult", y: barChartData.Young_Adult });
    barDataPoints.push({ label: "Adult", y: barChartData.Adult });
    var chart = new CanvasJS.Chart("barContainer", {
        animationEnabled: true,
        exportEnabled: true,
        theme: "light2", 
        title:{
            text: "Customer Age Distribution",
            fontFamily: "Jost, sans-serif",
            fontColor: "#38a095",
        },
        axisY:{
            title: "Frequency",
            includeZero: true
        },
        axisX:{
            title: "Age Group"
        },
        data: [{
            type: "column", 
            dataPoints: barDataPoints
        }]
    });
    chart.render();

}

