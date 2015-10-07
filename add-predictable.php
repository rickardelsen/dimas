<?php
    session_start();
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    
    if(isset($_POST['submit'])){
        date_default_timezone_set("Asia/Jakarta");
        $id = uniqid();
        $inset = "db.Predictable.insert({'id':'".$id."','nama':'".$_POST['nama']."','deskripsi':'".$_POST['deskripsi']."','add-time':'".strtotime(date('Y-m-d H:i:s'))."'});";
        $response = $db->execute($inset);
        $x = $_POST['nomor'];
        $param = $_POST['p'];
        for($i=0;$i<$x;$i++){
            if($param[$i]!=""){
                $inset = "db.Parameter.insert({'id':'".$id."','param':'".$param[$i]."'});";
                $response = $db->execute($inset);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Log ITB</title>
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
                            <li class="active">Tambah Predictable</li>
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
                        
                        <h3>Tambah Predictable</h3>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="alert-danger"><?php if(isset($_SESSION['fail'])){echo $_SESSION['fail'];unset($_SESSION['fail']);}?></div>
                            
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Bencana" value="">
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="6"></textarea>
                            </div>
                            <div id="dinamis" class="fee">
                            <input type="hidden" id="number" name="nomor" value="0" />
                    
                            <div class="label"></div>
                            <div class="input">
                                <input type="button" value="Tambah Parameter" onclick="Add()" />
                            </div>
                            </div>
                            <input type="submit" name="submit" value="Tambah" class="btn btn-blue" />
                               
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
<script>
        
        
        function Add(){ 
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            var text = [];
            if(value>1){
                for(j=1;j<value;j++){
                    text[j]=document.getElementById('param'+j).value;
                }
            }
            document.getElementById('number').value = value;
            document.getElementById('dinamis').innerHTML += "<div class=\"form-group\"><label for=\"parameter\">Parameter "+value+"</label>\n\
                <input class=\"form-control\" id=\"param"+value+"\" type=\"text\" name=\"p[]\" value=\"\">\n\
                </div>";
            if(value>1){
                for(j=1;j<value;j++){
                    document.getElementById('param'+j).value=text[j];
                }
            }
        }
    </script>
</body>
</html>