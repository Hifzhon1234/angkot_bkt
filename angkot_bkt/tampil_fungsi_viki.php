<?php
    include("../connect.php");
    $id_angkot = $_GET['id_angkot'];
    $tipe_kuliner = $_GET['tipe_kuliner'];
    $capacity = $_GET['capacity'];
    
    $result = pg_query("SELECT distinct detail_culinary_place.id_culinary_place, culinary_place.name, st_x(st_centroid(culinary_place.geom)) as lng2, 
st_y(st_centroid(culinary_place.geom)) as lat2, detail_culinary_place.lat, detail_culinary_place.lng, 
detail_culinary_place.description FROM detail_culinary_place join culinary_place on 
culinary_place.id=detail_culinary_place.id_culinary_place join detail_culinary ON detail_culinary.id_culinary_place
=culinary_place.id JOIN culinary ON culinary.id=detail_culinary.id_culinary where detail_culinary_place.id_angkot='$id_angkot' 
and capacity > $capacity and culinary.id=$tipe_kuliner");

//var_dump($result);
//die();

    while($baris = pg_fetch_array($result)){
        $id=$baris['id_culinary_place'];
        $name=$baris['name'];
        $lat=$baris['lat'];
        $lng=$baris['lng'];
        $lat2=$baris['lat2'];
        $lng2=$baris['lng2'];
        $description=$baris['description'];
        $dataarray[]=array('id'=>$id,'name'=>$name,'lat'=>$lat,'lng'=>$lng,'lat2'=>$lat2,'lng2'=>$lng2,'description'=>$description);
    }
    echo json_encode ($dataarray);



?>