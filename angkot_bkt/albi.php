<?php
    include("../connect.php");
    $tipe_wisata = $_GET['tipe_wisata'];
  
    $result =" Select distinct angkot.id, angkot.destination, angkot.track, angkot.cost, angkot.number, angkot.route_color, angkot.geom, ST_X(ST_Centroid(angkot.geom)) AS lon, ST_Y(ST_CENTROID(angkot.geom)) As lat, angkot_color.color FROM
    angkot JOIN angkot_color ON angkot.id_color=angkot_color.id JOIN detail_tourism ON detail_tourism.id_angkot=angkot.id
    JOIN tourism ON tourism.id=detail_tourism.id_tourism JOIN tourism_type ON tourism_type.id=tourism.id_type
    where ST_distanceSphere(ST_Centroid(tourism.geom),ST_Centroid (angkot.geom)) < 900 and tourism_type.name='$tipe_wisata'
    ";
//var_dump($result);
//die();
 // $rst = pg_query( $result);
  $wow = pg_query( $result);
  //var_dump($wow);
  //die();
      $dataarray = [];
      while($row = pg_fetch_array($wow))
      {
        $id_angkot=$row['id'];
        $number=$row['number'];
        $destination=$row['destination'];
        $track=$row['track'];
        $number=$row['number'];
        $route_color=$row['route_color'];
        $cost=$row['cost'];
        $lon=$row['lon'];
        $lat=$row['lat'];
        $dataarray[]=array('id'=>$id_angkot,'number'=>$number, 'destination'=>$destination, 'track'=>$track,'number'=>$number,'route_color'=>$route_color,'cost'=>$cost,'lon'=>$lon,'lat'=>$lat);
      }
      echo json_encode ($dataarray);
 
?>