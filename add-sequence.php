<?php
    session_start();
    if(!isset($_GET['id']) && !isset($_SESSION['id-bencana'])){
        header('Location: predictable.php');
    }
    else{
        if(isset($_GET['id'])){
            $_SESSION['id-bencana']=$_GET['id'];
            $id = $_GET['id'];
        }else{
            $id = $_SESSION['id-bencana'];
        }
    }
    if(isset($_POST['coords'])){
        echo $_POST['coords'];
    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    $collection = $db->Bencana;
    $arr = array("id"=>$id);
    $cursor = $collection->find($arr);
    $i=0;
    foreach ($cursor as $document) {
        $lat=$document['latitude'];
        $lng=$document['longitude'];
        $lokasi=$document['nama'];
        $nama=$document['nama'];
    }
    $coords = null;
     
    
    
    if(isset($_POST['simpan'])){
        date_default_timezone_set("Asia/Jakarta");
        $pmt = $_POST['param'];
        $x = count($pmt);
        $inset = "db.Sequence.insert({'id':'".uniqid()."','id-bencana':'".$id."','id-jenis':'".$_SESSION['id-jenis']."'";
        for($i=0;$i<$x;$i++){
            $inset .= ",'".$pmt[$i]."':'".$_POST[$pmt[$i]]."'";
        }
        $inset .= ",'coords':'".$_POST['coords']."','waktu':'".strtotime($_POST['waktu'])."','trans_time':'".date('Y-m-d H:i:s')."'});";
        $response = $db->execute($inset);
        header('Location: bencana.php');
    }
    

    $collection = $db->Parameter;
    $arr = array("id"=>$_SESSION['id-jenis']);
    $cursor = $collection->find($arr);
    $i=0;
    foreach ($cursor as $document) {
        $param[$i]=$document['param'];
        $i++;
    }
    $collection = $db->Sequence;
    $arr = array("id-bencana"=>$_SESSION['id-bencana']);
    $cursor = $collection->find($arr);
    $j=0;
    foreach ($cursor as $document) {
        for($x=0;$x<$i;$x++){
            $value[$param[$x]]=$document[$param[$x]];
        }
        $value['coords']=$document['coords'];
        $j++;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>DiMAS</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="" />
<meta name="author" content="http://bootstraptaste.com" />
<!-- css -->
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/fancybox/jquery.fancybox.css" rel="stylesheet">
<link href="css/jcarousel.css" rel="stylesheet" />
<link href="css/flexslider.css" rel="stylesheet" />
<link href="css/style.css" rel="stylesheet" />


<!-- Theme skin -->
<link href="skins/default.css" rel="stylesheet" />
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
          <?php if(isset($value['Radius'])){?>
          var myCity = new google.maps.Circle({
        center:Lokasi,
        radius:<?php echo $value['Radius']*1000; ?>,
        strokeColor:"#0000FF",
        strokeOpacity:0.8,
        strokeWeight:2,
        fillColor:"#0000FF",
        fillOpacity:0.4,
        clickable:false
        });
        myCity.setMap(map);
          <?php } ?>
         
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
         
         <?php if ($j>0){ ?>
          // create
         var polygonCoord = [<?php
                                $res = substr($value['coords'], 1, -1);
                                $coord = explode(")(", $res);
                                $x=  count($coord);
                                for($n=0;$n<$x;$n++){
                                    echo 'new google.maps.LatLng('.$coord[$n].')';
                                    if($n<$x-1){
                                        echo ",";
                                    }
                                }
                                
                                ?>];
                        polygon = new google.maps.Polygon({
                               paths: polygonCoord,
                               strokeColor: "#00FF00",
                               strokeOpacity: 0.8,
                               strokeWeight: 2,
                               fillColor: "#00FF00",
                               fillOpacity: 0.35,
                               clickable : false   
                               });
                        polygon.setMap(map);
                               
         <?php } ?>
         
    });
    </script>
    <script type="text/javascript" src="js/main.js"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>
<div id="wrapper">
	<!-- start header -->
	<header>
         <?php
            include($_SERVER['DOCUMENT_ROOT'] . "/dimas/Menu.php");
        ?>
	</header>
	<!-- end header -->
	<section id="inner-headline">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="breadcrumb">
                            <li><a href="index.php"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i></li>
                            <li class="active">Tambah Sequence</li>
                        </ul>
                    </div>
                </div>
            </div>
	</section>
	<section id="content">
            <div class="container">
		<div class="row">
                   
                    <div class="col-lg-2">
                      
                    </div>
                    <div class="col-lg-8">
                        <h3><?php echo $nama; ?></h3>
                        <form action="" method="POST" enctype="multipart/form-data" id="map-form">
                            <?php
                                $x = count($param);
                                $text="";
                                for($i=0;$i<$x;$i++){
                                    echo "<input type=\"hidden\" name=\"param[]\" value=".$param[$i]." />";
                                }
                                for($i=0;$i<$x;$i++){
                                    if($j>0){
                                        $text=$value[$param[$i]];
                                    }
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"".$param[$i]."\">".str_replace("_", " ", $param[$i])."</label>";
                                    echo "<input type=\"text\" name=\"".$param[$i]."\" id=\"".$param[$i]."\" class=\"form-control\" placeholder=\"".str_replace("_", " ", $param[$i])."\" value=\"".$text."\">";
                                    echo "</div>";
                                }
                            ?>
                            <div id="main-map" style="height: 600px;"></div>
                            <input type="hidden" name="coords" id="map-coords" value=""/>
                            <input type="button" class="btn btn-blue" value="Reset Map" id="reset"/>
                            <div class="form-group">
                                <label for="datetimepicker_dark">Waktu</label>
                                <input type="text" name="waktu" id="datetimepicker_dark" class="form-control" autocomplete="off"/>
                            </div> 
                            <input type="submit" name="simpan" class="btn btn-green" value="Simpan"/>

                            
                            
                            
                            
                        </form>
                    </div>
                    <div class="col-lg-2"></div>
		</div>
            </div>
	</section>
	<footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
<!--                        <div class="widget">
                            <h5 class="widgetheading">Info Lebih Lanjut</h5>
                            <address>
                                <strong>Contact Person: Dian Ramadhani</strong><br>
                                Institut Teknologi Bandung<br>
                                Labtek V Jl. Ganesha 10 Bandung
                            </address>
                            <p>
                                <i class="icon-phone"></i> +62-85265863357 (a.n. Dian Ramadhani) <br/>
                                <i class="icon-phone"></i> +62-22-2508135 (a.n. Fazat Nur Azizah)<br/>
                                Fax: +62-22-2500940 <br/>
                                <i class="icon-envelope-alt"></i> dse@informatika.org <br/>
                                Facebook fan page	: DSE Days
                            </p>
                        </div>-->
                    </div>
                    <div class="col-lg-3">
<!--                        <div class="widget">
                            <h5 class="widgetheading">Pages</h5>
                            <ul class="link-list">
                                <li><a href="index.html">Home</a></li>
                                <li><a href="registrasi.html">Registrasi</a></li>
                                <li><a href="contact.html">Hubungi Kami</a></li>
                            </ul>
                        </div>-->
                    </div>
                    <div class="col-lg-3">
<!--                        <div class="widget">
                            <h5 class="widgetheading">Kegiatan DSE Days</h5>
                            <ul class="link-list">
                                <li>Tutorial on Software Engineering in DevOps Context</li>
                                <li>Konferensi Nasional Rekayasa Data</li>
                                <li>Seminar dan Workshop Pendidikan Rekayasa Perangkat Lunak</li>
                                <li>Tutorial on Data Analytics and Visualization</li>
                            </ul>
                        </div>-->
                    </div>
                    <div class="col-lg-3">
<!--                        <div class="widget">
                            <h5 class="widgetheading">Link</h5>
                            <div class="flickr_badge">
                                <script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=8&amp;display=random&amp;size=s&amp;layout=x&amp;source=user&amp;user=34178660@N03"></script>
                            </div>
                            <div class="clear">
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
	</footer>
</div>
<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
<!-- javascript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/jquery.fancybox-media.js"></script>
<script src="js/google-code-prettify/prettify.js"></script>
<script src="js/portfolio/jquery.quicksand.js"></script>
<script src="js/portfolio/setting.js"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/animate.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.geocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    <script src="js/logger.js"></script>
    <script src="js/jquery.datetimepicker.js"></script>
  <script type="text/javascript">

    $(document).ready(function () {
        $('#myModal').on('shown', function () {
            initialize();
        });
    })
</script>
    <script>
  var iconBase = 'img/home.png';
 
      $(function(){
        $("#geocomplete").geocomplete({
          map: ".map_canvas",
          
          mapOptions: {
            scrollwheel : true
          },
          details: "form ",
          markerOptions: {
           
             icon: iconBase,
            draggable: true
          }
        });
        
        $("#geocomplete").bind("geocode:dragged", function(event, latLng){
          $("input[name=lat]").val(latLng.lat());
          $("input[name=lng]").val(latLng.lng());
          $("#reset").show();
        });
        
        
        $("#reset").click(function(){
          $("#geocomplete").geocomplete("resetMarker");
          $("#reset").hide();
          return false;
        });
        
        $("#find").click(function(){
          $("#geocomplete").trigger("geocode");
        }).click();
      });
      $('#datetimepicker_dark').datetimepicker({theme:'dark'})
    </script>
</body>
</html>