<?php
session_start();
include "dbconfig.php";
include "header.php";
include "nav.php";
?>

<div class="row">
<div class="input-group rounded col-md-6"style="width:25%!important">
  <select class="form-control rounded" id="price">
    <option>Select price</option>
    <option value="1000">1000</option>
    <option value="2000">2000</option>
    <option value="3000">3000</option>
    <option value="4000">4000</option>
    <option value="10000">Up to 10000</option>    
  </select>
</div>

<div class="input-group rounded col-md-6"style="width:25%!important">
  <select class="form-control rounded" id="days">
    <option>Select No of days</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="10">Up to 10</option>
  </select>
</div>

<div class="input-group rounded col-md-6"style="width:25%!important">
  <select class="form-control rounded" id="people">
    <option>Select No of people</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="10">Up to 10</option>
  </select>
</div>

<div class="input-group rounded col-md-6" style="width:25%!important">
  <input type="search" class="form-control rounded" id="live_search" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
  <span class="input-group-text border-0" id="search-addon">
    <i class="fas fa-search"></i>
  </span> 
</div>

</div>
  <!--filter_by = name
      filter_by = price
      filter_by = no of days
      filter_by = no of people -->
  <script type="text/javascript">
    $(document).ready(function(){
      $("#live_search").keyup(function(){
        var input = $(this).val();

        if (input.trim() === "") {
        $.ajax({
            url: "livesearch.php",
            method: "POST",
            data: { input: "", filter_by: 1 },
            success: function(data) {
                $("#search_result").html(data);
            }
        });
        return;
    }

          $.ajax({
            url:"livesearch.php",
            method:"POST",
            data:{input:input,filter_by:1},
            

            success:function(data){
              if(data != ""){
                $("#search_result").html(data);
              }else{
                $("#search_result").html(`
                      <div class="col-12 text-center my-5">
                            <i class="fas fa-search fa-2x text-muted mb-2"></i>
                            <p class="text-muted fs-5">No results found</p>
                      </div>
                `);
              }
              
            }
          });       
      });

      $("#price").on("change", function(){
        var input = $(this).val();
        if (input === "Select price") {
        input = "";
    }

          $.ajax({
            url:"livesearch.php",
            method:"POST",
            data:{input:input,filter_by:2},

            success:function(data){
              if(data != ""){
                $("#search_result").html(data);
              }else{

                $("#search_result").html(`
                      <div class="col-12 text-center my-5">
                            <i class="fas fa-search fa-2x text-muted mb-2"></i>
                            <p class="text-muted fs-5">No results found</p>
                      </div>
                `);


              }
              
            }
          });      
      });

       $("#days").on("change", function(){
        var input = $(this).val();
        if (input === "Select No of days") {
        input = "";
    }
          $.ajax({
            url:"livesearch.php",
            method:"POST",
            data:{input:input,filter_by:3},

            success:function(data){
              if(data != ""){
                $("#search_result").html(data);
              }else{
                $("#search_result").html(`
                      <div class="col-12 text-center my-5">
                            <i class="fas fa-search fa-2x text-muted mb-2"></i>
                            <p class="text-muted fs-5">No results found</p>
                      </div>
                `);
              }
              
            }
          });      
      });

       $("#people").on("change", function(){
        var input = $(this).val();
        if (input === "Select No of people") {
        input = "";
    }
          $.ajax({
            url:"livesearch.php",
            method:"POST",
            data:{input:input,filter_by:4},

            success:function(data){
              if(data != ""){
                $("#search_result").html(data);
              }else{
                $("#search_result").html(`
                      <div class="col-12 text-center my-5">
                            <i class="fas fa-search fa-2x text-muted mb-2"></i>
                            <p class="text-muted fs-5">No results found</p>
                      </div>
                `);
              }
              
            }
          });      
      });

    });
  </script>

  <div class="pkgheading">
  <p>BEST HOLIDAY PACKAGES</p>
  <hr class="line1">
  <hr class="line2">
  </div>
  <div class="container">
  <div class="row" id="search_result">

    <?php
    $sql = "SELECT * FROM tbl_package tp JOIN city c on tp.city_id=c.id JOIN state s on c.state_id=s.state_id";
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
<?php
include "footer.php";

?>

