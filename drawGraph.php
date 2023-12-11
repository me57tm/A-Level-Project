<?php
require_once("C:\Users\jonat.DESKTOP-6025MRQ\Desktop\H446 PHP DEVELOPMENT\sessionStart.php");
require_once("DBScripts.php");
function graphData(){
	return $_SESSION["graphData"];
}

?>
<html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
		var rawData = [["Time","Score"],<?php echo graphData();?>];
		if (rawData.length == 1){
			document.getElementById("chart_div").innerHTML = "No data to display";
			
		}
		else{
			var chartData = google.visualization.arrayToDataTable(rawData);

			var options = {
			    title: 'Pizza',
			    curveType: 'function',
			    legend: { position: 'bottom' },
			    colors: ['#01BAEF', '#01BAEF', '#003554', '#051923'],
				vAxis: {format: 'percent'}
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

			chart.draw(chartData, options);
		}}

</script>
</html>