<?php
    session_start();
    if(isset($_POST['break'])){
        unset($_SESSION['coords']);
        session_destroy();
    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    $collection = $db->Bencana;
    $arr = array("id"=>"55dfdce0b53a7");
    $cursor = $collection->find($arr);
    $i=0;
    foreach ($cursor as $document) {
        $rad=$document['Radius'];
        $lat=$document['latitude'];
        $lng=$document['longitude'];
        $lokasi=$document['Lokasi'];
    }
    $coords = null;
     
    if(isset($_POST['coords'])){
//        echo $_POST['coords'];
        if(!isset($_SESSION['coords'])){
            $_SESSION['coords'][0] = $_POST['coords'];
        }else{
            if(!isset($_SESSION['coords'][0])){
                $_SESSION['coords'][0] = $_POST['coords'];
            }else if(!isset($_SESSION['coords'][1])){
                $_SESSION['coords'][1] = $_POST['coords'];
            }else if(!isset($_SESSION['coords'][2])){
                $_SESSION['coords'][2] = $_POST['coords'];
            }else{
                $_SESSION['coords'][2] = $_SESSION['coords'][1];
                $_SESSION['coords'][1] = $_SESSION['coords'][0];
                $_SESSION['coords'][0] = $_POST['coords'];
            }
        }
    }

?>

<!DOCTYPE>
 
<html>
    <head>
     
    <title>Google Map Polygon</title>
     
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
     
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
     <script type="text/javascript" src="js/jquery.js"></script>
     
    <script type="text/javascript" src="js/polygon.min.js"></script>
     
    <script type="text/javascript">
    $(function(){
         // create map
         var Lokasi=new google.maps.LatLng(<?php echo $lat.",".$lng; ?>);
         
 
         var myOptions = {
            zoom: 12,
            center: Lokasi,
            mapTypeId: google.maps.MapTypeId.ROADMAP
         }
         
         map = new google.maps.Map(document.getElementById('main-map'), myOptions);
         
         var marker = new google.maps.Marker({
            position: Lokasi,
            map: map,
            title: '<?php echo $lokasi; ?>'
          });
          var myCity = new google.maps.Circle({
        center:Lokasi,
        radius:<?php echo $rad*1000; ?>,
        strokeColor:"#0000FF",
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor:"#0000FF",
        fillOpacity:0.4,
        clickable:false
        });
        myCity.setMap(map);
         
         
         // attached a polygon creator drawer to the map
         var creator = new PolygonCreator(map);
 
         // reset button
         $('#reset').click(function(){
                creator.destroy();
                creator=null;              
                creator=new PolygonCreator(map);               
         });   
 
         // set polygon data to the form hidden field
         $('#map-form').submit(function () {
            $('#map-coords').val(creator.showData());
         });
         
         <?php if (isset($_SESSION['coords'][0])){ ?>
          // create
         var polygonCoord1 = [<?php
                                $res = substr($_SESSION['coords'][0], 1, -1);
                                $coord = explode(")(", $res);
                                $x=  count($coord);
                                for($i=0;$i<$x;$i++){
                                    echo 'new google.maps.LatLng('.$coord[$i].')';
                                    if($i<$x-1){
                                        echo ",";
                                    }
                                }
                                
                                ?>];
                        polygon1 = new google.maps.Polygon({
                               paths: polygonCoord1,
                               strokeColor: "#00FF00",
                               strokeOpacity: 0.8,
                               strokeWeight: 2,
                               fillColor: "#00FF00",
                               fillOpacity: 0.35,
                               clickable : false   
                               });
                               
         <?php } if (isset($_SESSION['coords'][1])){ ?>
          // create
         var polygonCoord2 = [<?php
                                $res = substr($_SESSION['coords'][1], 1, -1);
                                $coord = explode(")(", $res);
                                $x=  count($coord);
                                for($i=0;$i<$x;$i++){
                                    echo 'new google.maps.LatLng('.$coord[$i].')';
                                    if($i<$x-1){
                                        echo ",";
                                    }
                                }
                                
                                ?>];
                        polygon2 = new google.maps.Polygon({
                               paths: polygonCoord2,
                               strokeColor: "#00FF00",
                               strokeOpacity: 0.8,
                               strokeWeight: 2,
                               fillColor: "#00FF00",
                               fillOpacity: 0.35,
                               clickable : false   
                               });
                               
         <?php } if (isset($_SESSION['coords'][2])){ ?>
          // create
         var polygonCoord3 = [<?php
                                $res = substr($_SESSION['coords'][2], 1, -1);
                                $coord = explode(")(", $res);
                                $x=  count($coord);
                                for($i=0;$i<$x;$i++){
                                    echo 'new google.maps.LatLng('.$coord[$i].')';
                                    if($i<$x-1){
                                        echo ",";
                                    }
                                }
                                
                                ?>];
                            polygon3 = new google.maps.Polygon({
                               paths: polygonCoord3,
                               strokeColor: "#00FF00",
                               strokeOpacity: 0.8,
                               strokeWeight: 2,
                               fillColor: "#00FF00",
                               fillOpacity: 0.35,
                               clickable : false   
                               });
                               
         <?php } ?>
        var d1 = 0;
        var d2 = 0;
        var d3 = 0;
        <?php 
            if(isset($_SESSION['coords'])){
                $x = count($_SESSION['coords']);
                if($x>0){
                    echo "polygon".$x.".setMap(map);";
                    echo "d".$x."=1;";
                }
            }
            
        ?>
        $('#d1').click(function(){
            if(d1==0){    
                polygon1.setMap(map);
                d1=1;
            }else{
                polygon1.setMap(null);
                d1=0;
            }
         });    
         $('#d2').click(function(){
            if(d2==0){    
                polygon2.setMap(map);
                d2=1;
            }else{
                polygon2.setMap(null);
                d2=0;
            }
         });  
         $('#d3').click(function(){
            if(d3==0){    
                polygon3.setMap(map);
                d3=1;
            }else{
                polygon3.setMap(null);
                d3=0;
            }
         });  
          
         
 
         
                     
    });
    </script>
     
 
</head>
<body>
 <div style="margin:auto;  width: 100%; ">
     
        <div id="main-map" style="height: 600px;"></div>
     
        <form action="polygon.php" method="POST" id="map-form">
         
            <input type="hidden" name="coords" id="map-coords" value=""/>
            <input type="text" name="waktu" id="datetimepicker_dark" class="form-control" autocomplete="off"/>
            <input type="submit" value="Save"/>
             
            <input type="button" value="Reset" id="reset"/>
            <input type="button" value="Data 1" id="d1"/>
            <input type="button" value="Data 2" id="d2"/>
            <input type="button" value="Data 3" id="d3"/>
            <input type="submit" name="break" value="Break"/>
        </form>
     
    </div>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    <script src="js/logger.js"></script>
    <script src="js/jquery.datetimepicker.js"></script>
    <script>
        $('#datetimepicker_dark').datetimepicker({theme:'dark'})
    </script>
</body>
</html>

