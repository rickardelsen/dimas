<?php
    session_start();
    if(!isset($_POST['submit'])){
        header('Location: predictable.php');
    }
    $m = new MongoClient(); // connect
    $db = $m->selectDB("dimas");
    $collection = $db->Sequence;
    $arr = array("id"=>$_POST['id']);
    $cursor = $collection->find($arr);
    $i=0;
    foreach ($cursor as $document) {
        $coords = $document['coords'];
        $res = substr($coords, 1, -1);
        $coord = explode(")(", $res);
        $x=  count($coord);
        for($i=0;$i<$x;$i++){
            echo '['.$coord[$i].']';
            if($i<$x-1){
                echo ",<br />";
            }
        }
    }
?>
