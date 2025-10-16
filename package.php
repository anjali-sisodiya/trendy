
	<div class="pkgheading">
  <p>BEST HOLIDAY PACKAGES</p>
	<hr class="line1">
	<hr class="line2">
  </div>
<div class="container">
  <div class="row">

    <?php
include "dbconfig.php";   
 $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id limit 0,4";
$result = $conn->query($sql);
 $i=0;

while($row = $result->fetch_assoc()) {

?>

    <div class="col-md-3">
      <div class="card pkgcard <?php echo ($i==0 ? "active" : "");?>" style="width: 18rem;">
        <img src="<?php echo $row["pack_image"]?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title pkgtitle"><?php echo $row["pack_name"]?></h5>
           <p class="card-text pkginfo"><?php echo $row["name"].",".$row["state_title"].",". $row["country"]?></p>
        </div>
        <ul class="list-group list-group-flush">
    <li class="list-group-item pkginfo"><i class="fa-solid fa-calendar-days pkginfo"></i> No of Days: <?php echo $row["no_of_days"]?></li>
    <li class="list-group-item pkginfo"><i class="fa-solid fa-user icon pkginfo"></i> People: <?php echo $row["no_of_people"]?></li>
    <li class="list-group-item pkginfo pkgprice">Rs. <?php echo $row["price"]?></li>
  </ul>
  <div class="card-body">
    <a type="button" class="btn btn-success pkgbtn" href="package_details.php?p=<?php echo $row['package_id']; ?>">View details</a>
  </div>
      </div>
    </div>

    <?php

  $i++;
  }
  ?>

  </div>
</div>

