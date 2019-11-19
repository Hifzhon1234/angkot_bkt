<?php
    include("../connect.php");
    $id_angkot = $_GET['id_angkot'];
    $tipe_mesjid = $_GET['tipe_mesjid'];
    $capacity = $_GET['kapasitas'];
    
    $result = pg_query("SELECT distinct detail_worship_place.id_worship_place, worship_place.name, st_x(st_centroid(worship_place.geom)) as lng2, 
    st_y(st_centroid(worship_place.geom)) as lat2, detail_worship_place.lat, detail_worship_place.lng, 
    detail_worship_place.description FROM detail_worship_place join worship_place on 
    worship_place.id=detail_worship_place.id_worship_place join category_worship_place ON category_worship_place.id=
    worship_place.id_category where detail_worship_place.id_angkot='$id_angkot' and category_worship_place.id=$tipe_mesjid and capacity>$capacity");

    while($baris = pg_fetch_array($result)){
        $id=$baris['id_worship_place'];
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