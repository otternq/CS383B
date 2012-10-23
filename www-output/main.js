function drawGuageVisualization(senVal) {
  // Create and populate the data table.
  var data = google.visualization.arrayToDataTable([
    ['Label', 'Value'],
    ['Sentiment', senVal],
  ]);
  
  var options = {
    max: 1,
    min: -1
  };
  
  var chart = new google.visualization.Gauge(document.getElementById('visualization'));
  chart.draw(data, options);
}