<html>
    <head>
        <script type="text/javascript" src="./main.js"></script>
        
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script type="text/javascript">
          google.load('visualization', '1', {packages: ['gauge']});
          
          function init() {
            drawVisualization(.7);
          }
          
          google.setOnLoadCallback(init);
        </script>
    </head>
    <body>
        
        <div id="visualization" style="width: 600px; height: 300px;"></div>
        
    </body>

</html>