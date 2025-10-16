<?php
session_start();
include "dbconfig.php";
include "header.php";
include "nav.php";

$id = $_GET['p'];
$sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id WHERE package_id=$id";
$result = $conn->query($sql);
    while($row=$result->fetch_assoc()){

?>
<div class="container-fluid pagenav">
<ul class="nav justify-content-end">
	 <li class="nav-item">
    <a class="nav-link pagenavtitle" aria-current="page" href="#"><?php echo $row["pack_name"]?></a>
  </li>
  <li class="nav-item">
    <a class="nav-link active pagelinks" aria-current="page" href="index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link pagelinks" href="allpackages.php">/ Pages</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link disabled pagelinks" href="#" tabindex="-1" aria-disabled="true">/ <?php echo $row["pack_name"]?></a>
  </li>
</ul>
</div>

<div class="img_container">
  <div>
<img src="<?php echo $row["pack_image"]?>" class="img-thumbnail pkg1img" alt="...">
  </div>
<div class="imgdetails">
<p class="package_title"><?php echo $row["pack_name"]?></p>
	<span class="packageprice">Rs.<?php echo $row["price"]?></span>
  <div class="page_dtl">
<p class="pageinfo pgdtl">Package name : <?php echo $row["pack_name"]?></p>
<p class="pageinfo pgdtl">City : <?php echo $row["name"]?></p>
<p class="pageinfo pgdtl">State : <?php echo $row["state_title"]?></p>
<p class="pageinfo pgdtl">Country : <?php echo $row["country"]?></p>
<p class="pageinfo pgdtl">No of Days :<?php echo $row["no_of_days"]?></p>
<p class="pageinfo pgdtl">People : <?php echo $row["no_of_people"]?></p>
</div>

<h2 class="pageinfo">Description</h2>
<p class="pageinfo">Fusce vehicula eros eros, nec vulputate odio feugiat tempus. Pellentesque habitant <br>morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean sed<br> hendrerit purus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices.<br> Phasellus nisl augue, malesuada non nunc ac, auctor facilisis urna. Fusce interdum<br> erat vitae faucibus pharetra. Praesent ut mauris dictum, rutrum enim at, pharetra<br> orci. Vivamus malesuada et erat at pharetra. Vivamus aliquet tincidunt risus. Donec<br> porttitor quam id semper pretium.</p>
<div class="addtobtn">
<a type="button" class="btn btn-success pkgbtn addtocart_btn" href="cart.php?p=<?php echo $row['package_id']; ?>">Add to cart</a>

</div>
</div>
</div>
<?php
}
include "footer.php";
?>
