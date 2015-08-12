<?php
    session_start();
    if(isset($_POST['view'])){
        $_SESSION['id']=$_POST['id'];
        header("Location: sequence.php");
    }
//    if(!isset($_SESSION['user'])){
//        header('Location:index.php');
//    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    
    $collection = $db->Bencana;
    $cursor = $collection->find();
    
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
                        <table class="table table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Radius</th>
                                <th>Aksi</th>
                            </tr>
                        <?php
                            $i=0;
                            foreach ($cursor as $document) {
                                echo "<tr>";
                                echo "<td>".$document['id'],"</td>";
                                echo "<td>".$document['nama'],"</td>";
                                echo "<td>".$document['Lokasi'],"</td>";
                                echo "<td>".$document['Radius'],"</td>";
                                echo "<form action=\"\" method=\"POST\" enctype=\"multipart/form-data\">";
                                echo "<input type=\"hidden\" name=\"id\" value=\"".$document['id'],"\" />";
                                echo "<td><input type=\"submit\" name=\"view\" class=\"btn btn-green\" value=\"View\" /></td>";
                                echo "</form>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
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