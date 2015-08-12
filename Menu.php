
<?php
    
?>
 <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand logo" href="index.php"><img src="img/logo-itb.png" alt="" /></a>
                    <!--<a class="navbar-brand logo" href="index.php"><img src="img/Logo_Institut_Teknologi_Bandung.png" alt="" /></a>-->
                    <!--<a class="navbar-brand logo" href="index.php"><img src="img/logo-if-abet-computing.png" alt="" /></a>-->
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <?php
                            if(isset($_SESSION['username'])){
                                echo "<li><a href=\"logout.php\">Logout</a></li>";
                            }
                        ?>
                        
                    </ul>
                </div>
            </div>
        </div>