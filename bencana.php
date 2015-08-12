<?php
    session_start();
//    if(!isset($_SESSION['user'])){
//        header('Location:index.php');
//    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    
    if(isset($_POST['submit'])){
        date_default_timezone_set("Asia/Jakarta");
        $pmt = $_POST['param'];
        $x = count($pmt);
        $inset = "db.Bencana.insert({'id':'".uniqid()."','jenis':'predictable','nama':'Tornado'";
        for($i=0;$i<$x;$i++){
            $inset .= ",'".$pmt[$i]."':'".$_POST[$pmt[$i]]."'";
        }
        $inset .= ",'latitude':'".$_POST['lat']."','longitude':'".$_POST['lng']."','waktu':'".$_POST['waktu']."','trans_time':'".date('Y-m-d H:i:s')."'});";
        $response = $db->execute($inset);
        header('Location: bencana.php');
    }
    

    $collection = $db->Parameter;
    $arr = array("id"=>"001");
    $cursor = $collection->find($arr);
    $i=0;
    foreach ($cursor as $document) {
        $param[$i]=$document['param'];
        $i++;
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
<style type="text/css">
        body {
            height: 100%;
            background: url('img/ticks.png');

        }

        .box h3{
            text-align:center;
            position:relative;
            top:80px;
        }
        .box {
            width:70%;
            height:200px;
            background:#FFF;
            margin:40px auto;
            border: 5px;
        }


        #mapCanvas {
            width: auto;
            height: 400px;

        }
        .tengah { float: none; margin-left: auto; margin-right: auto; }
        .boxcari { width: 400px }

        footer {
              color: #666;
              background: #222;
              padding: 17px 0 18px 0;
              border-top: 1px solid #000;
          }
          footer a {
              color: #999;
          }
          footer a:hover {
              color: #efefef;
          }
          .wrapper {
              min-height: 100%;
              height: auto !important;
              height: 100%;
              margin: 0 auto -63px;
          }
          .push {
              height: 63px;
          }
          /* not required for sticky footer; just pushes hero down a bit */
          .wrapper > .container {
              padding-top: 60px;
          }
        .profilpic {

            -moz-box-shadow: 0 0 5px 5px #888;
            -webkit-box-shadow: 0 0 5px 5px#888;
            box-shadow: 0 0 5px 5px #888;

        }

        .map_canvas { 
            width: 100%; 
            height: 400px; 
            margin: 10px 0 10px 0;
            border: 10px solid #FFF;
        }

        .map_canvas:after{
            content: "Type in an address in the input above.";
            padding-top: 170px;
            display: block;
            text-align: center;
            font-size: 2em;
            color: #999;
        }
    </style>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>

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
                            <li class="active">Letusan Gunung</li>
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
                        <h3>Letusan Gunung</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <?php
                                $x = count($param);
                                for($i=0;$i<$x;$i++){
                                    echo "<input type=\"hidden\" name=\"param[]\" value=".$param[$i]." />";
                                }
                                for($i=0;$i<$x;$i++){
                                    echo "<div class=\"form-group\">";
                                    echo "<label for=\"".$param[$i]."\">".$param[$i]."</label>";
                                    echo "<input type=\"text\" name=\"".$param[$i]."\" id=\"".$param[$i]."\" class=\"form-control\" placeholder=\"".$param[$i]."\" value=\"\">";
                                    echo "</div>";
                                }
                            ?>
                            <div class="form-group">
                                <label for="geocomplete">Cari Lokasi</label>
                                <input id="geocomplete" type="text" class="form-control" placeholder="Type in an address" value="<?php
                            $latitude = "-6.892131824694046";
                            $longitude = "107.60981023822023";
                            if ($longitude == "107.60981023822023" )
                              {
                              echo "Bandung";
                              }
                              else
                              {
                              echo $r['lat'] . "," . $r['lng'];
                              }
                            ?>" />
                                <input id="find" type="button" class="btn btn-blue" value="Cari" />
                             </div> 
                            

                           

                            <div class="map_canvas"></div>

                            <input type="hidden" id="latitude" name="lat" value="" >
                            <input type="hidden" id="longitude" name="lng" value="" >
                            <fieldset>
                                 <div class="form-group">
                                    <label for="Latitude">Latitude</label>
                                    <input type="text" name="lat" id="Latitude" class="form-control" placeholder="Latitude" value="<?php echo $latitude;?>">
                                 </div>   
                                 <div class="form-group">
                                    <label for="Longitude">Longitude</label>
                                    <input type="text" name="lng" id="Longitude" class="form-control" placeholder="Longitude" value="<?php echo $longitude;?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="formatted_address">Formatted Address</label>
                                    <input type="text" name="formatted_address" id="formatted_address" class="form-control" placeholder="Formatted Address" value="">
                                 </div>
                                
                            </fieldset>
                            <div class="form-group">
                                <label for="datetimepicker_dark">Waktu</label>
                                <input type="text" name="waktu" id="datetimepicker_dark" class="form-control" autocomplete="off"/>
                             </div>  
                            
                           <input class="btn btn-default" type="submit" name="submit" value="Submit"> <br /><br />
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