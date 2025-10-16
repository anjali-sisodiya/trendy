<?php   
include "dbconfig.php";  
$search = $_POST['input'];  
$filter_by = $_POST['filter_by'];  
  
if($search != ""){

    if($filter_by == 1){
      $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id WHERE tp.pack_name LIKE '%$search%'";
    }

    if($filter_by == 2){
      $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id WHERE tp.price <= ".$search;
    }

    if($filter_by == 3){
      $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id WHERE tp.no_of_days <= ".$search;
    }

    if($filter_by == 4){
      $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id WHERE tp.no_of_people <= ".$search;
    }

}else{
    $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id";
}



$result = $conn->query($sql);
 $html= '';
 $i=0;
if($result->num_rows > 0){
while($row = $result->fetch_assoc()) {

    $html.= '<div class="col-md-3">
      <div class="card pkgcard '.($i==0 ? "active" : "").'" style="width: 18rem;">
        <img src="'.$row["pack_image"].'" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title pkgtitle">'.$row["pack_name"].'</h5>
           <p class="card-text pkginfo">'.$row["name"].",".$row["state_title"].",". $row["country"].'</p>
        </div>
        <ul class="list-group list-group-flush">
    <li class="list-group-item pkginfo"><i class="fa-solid fa-calendar-days pkginfo"></i> No of Days: '.$row["no_of_days"].'</li>
    <li class="list-group-item pkginfo"><i class="fa-solid fa-user icon pkginfo"></i> People: '.$row["no_of_people"].'</li>
    <li class="list-group-item pkginfo pkgprice">Rs. '.$row["price"].'</li>
  </ul>
  <div class="card-body">
    <a type="button" class="btn btn-success pkgbtn" href="package_details.php?p='.$row['package_id'].'">View details</a>
  </div>
      </div>
    </div>';
    $i++;
  }
}
echo $html;
?>