<?php
    session_start();
    if(isset($_POST['break'])){
        unset($_SESSION['coords']);
        session_destroy();
    }
    if(isset($_POST['coords'])){
        echo $_POST['coords'];
    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    $collection = $db->Bencana;
    $arr = array("id"=>"55dfcf26e5b28");
    $cursor = $collection->find($arr);
    $i=0;
    foreach ($cursor as $document) {
        $lat=$document['latitude'];
        $lng=$document['longitude'];
        $lokasi=$document['nama'];
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
         
    });
    </script>
     
 
</head>
<body>
 <div style="margin:auto;  width: 100%; ">
     
        <div id="main-map" style="height: 600px;"></div>
     
        <form action="" method="POST" id="map-form">
         
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

