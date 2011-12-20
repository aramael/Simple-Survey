<?php
require_once "../resources/config.php";
try{
	$stmt = $dbh->prepare("SELECT COUNT(*) AS completed FROM subjects WHERE completed = '1'");
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_OBJ);
	$completed = $stmt->fetch();
}catch(PDOException $e){
	echo $e->getMessage();
}
try{
	$stmt = $dbh->prepare("SELECT COUNT(*) AS total FROM subjects");
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_OBJ);
	$total = $stmt->fetch();
}catch(PDOException $e){
	echo $e->getMessage();
}
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows(2);
        data.setValue(0, 0, 'Response');
        data.setValue(0, 1, <?php echo $completed->completed;?>);
        data.setValue(1, 0, 'No Response');
        data.setValue(1, 1, <?php echo $total->total - $completed->completed;?>);
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 450, height: 300, title: 'Response Rate'});
      }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>