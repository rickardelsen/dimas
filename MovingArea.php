<?php
    session_start();
    if(!isset($_POST['submit'])){
        header('Location: predictable.php');
    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    echo $_POST['id'];

?>
<!DOCTYPE html>
<html>
  <head>    
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Moving overlays</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #directions-panel {
        height: 100%;
        float: right;
        width: 390px;
        overflow: auto;
      }
      #map-canvas {
        margin-right: 400px;
      }

    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script>

      var dataCounter = 0;
      var dataInterval = 1000;  // every new frame every 1000ms.  Feel free to change this
      var pacman = null;
      var ghost = null;
      var map;
      var timer;
      var bermudaTriangle = null;
      var infoWindow;
      var Time;
      <?php
        $collection = $db->Sequence;
        $arr = array("id-bencana"=>$_POST['id']);
        $cursor = $collection->find($arr);
        $i=0;
        
        foreach ($cursor as $document) {
            if($i==0){
                echo "var triangleCoords = [";
            }else{
                echo "var triangleCoords".$i." = [";
            }
            $coords[$i] = $document['coords'];
            $res = substr($coords[$i], 1, -1);
            $coord = explode(")(", $res);
            $x=  count($coord);
            for($k=0;$k<$x;$k++){
                echo 'new google.maps.LatLng('.$coord[$k].')';
                if($k<$x-1){
                    echo ",";
                }
            }
            echo "];";
            list($trash,$time[$i])=explode(" ",$document['waktu']);
            $i++;
        }
        echo "var data = [";
        for($j=0;$j<$i;$j++){
            if($j==0){
                echo "{time: '".$time[$j].":00', bermudaTriangle:triangleCoords}";
            }else{
                echo "{time: '".$time[$j].":00', bermudaTriangle:triangleCoords".$j."}";
            }
            
            if($j<$i-1){
                echo ",";
            }
        }
        echo "];";
      ?>
      
  
  
      
      function initialize() {
        
        directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
          zoom: 12,
          <?php
            $collection1 = $db->Bencana;
            $arr1 = array("id"=>$_POST['id']);
            $cursor1 = $collection1->find($arr1);
            $i=0;
        
            foreach ($cursor1 as $document1) {
                echo "center: new google.maps.LatLng(".$document1['latitude'].", ".$document1['longitude']."),";
            }
          ?>
          mapTypeId:google.maps.MapTypeId.TERRAIN 
        };
        
        map = new google.maps.Map(document.getElementById('map-canvas'),
          mapOptions
        );
        
//        bermudaTriangle = new google.maps.Polygon({
//            paths: triangleCoords3,
//            strokeColor: '#FF0000',
//            strokeOpacity: 0.8,
//            strokeWeight: 2,
//            fillColor: '#FF0000',
//            fillOpacity: 0.35
//            });
//        bermudaTriangle.setMap(map);
      }
      
      function timelapse() {
        var item = data[dataCounter % data.length];
        Time = item.time;
        
        if (! bermudaTriangle) {// if the marker doesn't exist yet, first create it.
//          ghost = new google.maps.Marker({
//            position: new google.maps.LatLng(item.ghost.lat, item.ghost.lng),
//            icon: ghostIcon(),
//            map: map
//              });
            bermudaTriangle = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map
            
            });
            
            bermudaTriangle.addListener('click', showArrays);
            infoWindow = new google.maps.InfoWindow;
        }
        else {
//          ghost.setPosition(new google.maps.LatLng(item.ghost.lat, item.ghost.lng))
            bermudaTriangle.setPath(item.bermudaTriangle);
            
        }
        setRangeValue((dataCounter%4+1)*100/4);
        showValue(Time);
        dataCounter++;
        timer = setTimeout(timelapse, dataInterval);
        
    }
        function start_timelapse() {
        clearTimeout(timer);           // if you don't add this, the previous timer is still working, you'll get two parallel timeOuts
        timelapse();
        infoWindow.close();
      }

        function stop_timelapse() {
        clearTimeout(timer);           // prevents setTimeout(timelapse, dataInterval); from continuing
      }
      
        function showArrays(event) {
        // Since this polygon has only one path, we can call getPath() to return the
        // MVCArray of LatLngs.
        var vertices = this.getPath();
        var contentString = '<b>Waktu Bencana '+Time+'</b><br><br>';
        contentString += '<b>Batas Koordinat Bencana</b>';

        // Iterate over the vertices.
        for (var i =0; i < vertices.getLength(); i++) {
          var xy = vertices.getAt(i);
          contentString += '<br>' + '<b>Koordinat ' + i + ':</b><br> lat :'+ xy.lat() + '<br> long :' +
              xy.lng();
        }
            contentString +="<br><input type=\"submit\" name=\"edit\" value=\"Detail Bencana\"/>";
        // Replace the info window's content and position.
        infoWindow.setContent(contentString);
        infoWindow.setPosition(event.latLng);

        infoWindow.open(map);
        stop_timelapse();
       }
       
       function showValue(newValue)
        {
	document.getElementById("range").innerHTML=newValue;
        }
        
        function setRangeValue(rangeValue)
        {
            var slidebar = document.getElementById("slidebar");
            slidebar.value=rangeValue;
        }
        
        function slideInput(rangeValue)
        {
         stop_timelapse(); 
         dataCounter = rangeValue-1;
         timelapse();
         infoWindow.close();
         stop_timelapse();
        }
        
  

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
     <input type="button" id="start" value="Start" onclick="start_timelapse()">
    <input type="button" id="stop" value="Stop" onclick="stop_timelapse()">
    <div id="map-canvas" style="width:1000px;height:500px;"></div>
    <input id="slidebar" type="range" style="width:1000px;" step="25" value="0" onchange="slideInput(this.value)"><br/>
    <span id="range">0</span>
  </body>lo
</html>