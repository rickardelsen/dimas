<?php
if(isset($_POST['submit'])){
    echo str_replace(" ", "_", $_POST['tes']);
}
?>
<html>
    <head></head>
    <body>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="tes" />
            <input type="submit" name="submit" value="Submit"/>
        </form>
    </body>
</html>

