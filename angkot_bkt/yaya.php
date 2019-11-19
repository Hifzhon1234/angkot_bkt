<?php
    include("../connect.php");
    $tipe_hotel = $_GET['tipe_hotel'];
    $marriage_book = $_GET['marriage_book'];
/*    $result=  "SELECT angkot.id, angkot.destination, angkot.track, angkot.cost, angkot.number, angkot.route_color, angkot.geom, ST_X(ST_Centroid(angkot.geom)) AS lon, ST_Y(ST_CENTROID(angkot.geom)) As lat, angkot_color.color from tourism  
    join detail_tourism on tourism.id=detail_tourism.id_tourism join angkot on detail_tourism.id_angkot=angkot.id
    join detail_culinary_place on angkot.id = detail_culinary_place.id_angkot
    join culinary_place on  detail_culinary_place.id_culinary_place=culinary_place.id 
    join detail_culinary on culinary_place.id=detail_culinary.id_culinary_place 
    join angkot_color on angkot.id_color = angkot_color.id
    join culinary on detail_culinary.id_culinary=culinary.id where culinary.name like '%$nama_kulineri%' and
    culinary_place.address like '%$alamat_kulineri%'";
    */  
    $result =" SELECT distinct angkot.id, angkot.number, angkot.destination,angkot.route_color, angkot.track, angkot.cost, angkot_color.color,ST_X(ST_Centroid(angkot.geom )) as lat, ST_Y(ST_Centroid(angkot.geom )) as lon  FROM
     angkot JOIN angkot_color ON angkot.id_color=angkot_color.id JOIN detail_hotel ON angkot.id=detail_hotel.id_angkot
     JOIN hotel ON detail_hotel.id_hotel=hotel.id JOIN hotel_type on hotel_type.id=hotel.id_type
     where ST_distanceSphere(ST_Centroid(hotel.geom),ST_Centroid (angkot.geom)) < 400
     and id_type= '$tipe_hotel' and marriage_book =$marriage_book";
//var_dump($result);
//die();
 // $rst = mysqli_query($conn, $result);
  $wow = pg_query($result);
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