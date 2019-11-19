<?php
    include("../connect.php");
    $id_angkot = $_GET['id_angkot'];
    $tipe_wisata = $_GET['tipe_wisata'];
    
    $result = pg_query("SELECT distinct detail_tourism.id_tourism , tourism.name, st_x(st_centroid(tourism.geom)) as lng2, 
    st_y(st_centroid(tourism.geom)) as lat2, detail_tourism.lat, detail_tourism.lng, 
    detail_tourism.description FROM detail_tourism join tourism on 
    tourism.id=detail_tourism.id_tourism join tourism_type ON tourism_type.id=
    tourism.id_type where detail_tourism.id_angkot='$id_angkot' and tourism_type.name='$tipe_wisata'");

    while($baris = pg_fetch_array($result)){
        $id=$baris['id_tourism'];
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