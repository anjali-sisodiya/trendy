


<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <?php
include "dbconfig.php";    
$sql = "SELECT * FROM tbl_banner WHERE status=1";
$result = $conn->query($sql);
 $i=0;

while($row = $result->fetch_assoc()) {

?>
<div class="carousel-item <?php echo ($i==0 ? "active" : "");?>" data-bs-interval="2000">
     <div style="position: relative; height: 430px; width: 100%;">
  <img src="<?php echo $row['banner_image']?>" style="height: 430px; width: 100%; object-fit: cover;" alt="...">
  <div style="
    position: absolute;
    top: 0; left: 0;
    height: 100%; width: 100%;
    background-color: rgba(0, 0, 0, 0.3);
  "></div>
  <div style="
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    z-index: 2;
    text-align: center;
  ">
   
  </div>
</div>

      <div class="text-block">
        <h1 class="bigtext"><?php echo $row["banner_description"]?></h1>
        <p class="smalltext1"><?php echo $row["sub_description"]?></p>
      </div>
    </div>
    
  <?php

  $i++;
  }

  ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>