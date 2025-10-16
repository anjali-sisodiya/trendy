<?php
session_start();
include "dbconfig.php";
include "header.php";
include "nav.php";

$sql = "SELECT * FROM cart c JOIN tbl_package tp on c.package_id=tp.package_id WHERE c.user_id=".$_SESSION['user_id']."  ORDER BY c.cart_id DESC";
$result = $conn->query($sql);
if($result->num_rows > 0){
?>

<style>
  body {
    background: #f0f4f8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .page-heading {
  text-align: center;
  margin: 10px auto 40px auto; 
  font-size: 2.8rem;
  font-weight: 800;
  color: #0056b3;
  letter-spacing: 2px;
  text-shadow: 1px 1px 4px rgba(0, 86, 179, 0.3);
}


  .table-container {
  max-width: 100%;
  width: 95vw;
  margin: -35px auto 80px auto; 
  padding: 15px 20px 30px 20px; 
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 12px 50px rgba(0, 86, 179, 0.12);
  overflow-x: hidden;
}


  .table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 22px;
  }

  .table thead tr {
    background-color: #004085;
    color: white;
    font-weight: 700;
    font-size: 16px;
    text-transform: uppercase;
    border-radius: 18px 18px 0 0;
    box-shadow: 0 6px 20px rgba(0, 64, 133, 0.45);
  }

  .table thead th {
    padding: 18px 25px;
    text-align: center;
    border-right: 1px solid rgba(255, 255, 255, 0.3);
  }
  .table thead th:last-child {
    border-right: none;
  }

  .table tbody tr {
    background: #e9f0fb;
    box-shadow: 0 8px 36px rgba(0, 86, 179, 0.15);
    border-radius: 18px;
    transition: background-color 0.35s ease, box-shadow 0.35s ease, transform 0.35s ease;
  }

.table tbody tr:hover {
  background-color: #e6f0ff;
  box-shadow: 0 12px 40px rgba(0, 86, 179, 0.3); 
  transform: translateY(-7px);
}
  .table tbody td {
    padding: 18px 22px;
    text-align: center;
    vertical-align: middle;
    color: #1b3058;
    font-size: 17px;
    border-right: 1px solid #d6dce5;
  }
  .table tbody td:last-child {
    border-right: none;
  }

  .cart_history_img {
    width: 150px;
    height: 110px;
    object-fit: cover;
    border-radius: 16px;
    border: 3px solid #a3bffa;
    box-shadow: 0 9px 28px rgba(0, 86, 179, 0.35);
    padding: 5px;
    transition: transform 0.35s ease, box-shadow 0.35s ease;
  }

  .cart_history_img:hover {
    transform: scale(1.15);
    box-shadow: 0 15px 44px rgba(0, 86, 179, 0.7);
  }

  /* Contact number bold + phone icon */
  .contact-cell {
    font-weight: 700;
    color: #003366;
    position: relative;
    letter-spacing: 0.8px;
  }
  .contact-cell::before {
    content: "📞";
    margin-right: 8px;
  }

  
  .price-cell {
    font-weight: 900;
    color: #28a745; 
    font-size: 18px;
    letter-spacing: 0.6px;
  }

 
  .date-cell {
    font-weight: 600;
    color: #0b5394;
    font-size: 16px;
  }

  
  @media (max-width: 992px) {
    .table-container {
      padding: 20px 20px;
    }
    .cart_history_img {
      width: 120px;
      height: 90px;
    }
    .page-heading {
      font-size: 2rem;
    }
  }
  @media (max-width: 576px) {
    .table-container {
      padding: 15px 10px;
    }
    .cart_history_img {
      width: 90px;
      height: 70px;
    }
    .table thead {
      display: none;
    }
    .table, .table tbody, .table tr, .table td {
      display: block;
      width: 100%;
    }
    .table tbody tr {
      margin-bottom: 25px;
      box-shadow: 0 6px 20px rgba(0, 86, 179, 0.2);
      border-radius: 16px;
      background: white;
      padding: 15px;
    }
    .table tbody td {
      text-align: right;
      padding-left: 50%;
      position: relative;
      border: none;
      font-size: 15px;
      color: #333;
    }
    .table tbody td::before {
      content: attr(data-label);
      position: absolute;
      left: 15px;
      top: 16px;
      font-weight: 700;
      color: #004085;
      text-transform: uppercase;
      font-size: 13px;
    }
    .contact-cell::before {
      margin-right: 4px;
    }
  }
</style>

<div class="page-heading">🛒 Hotels Booking History</div>

<div class="table-container">
  <table class="table" aria-label="Booking History Table">
    <thead>
      <tr>
        <th scope="col">Package Image</th>
        <th scope="col">Package Name</th>
        <th scope="col">No. of Days</th>
        <th scope="col">No. of People</th>
        <th scope="col">Contact No.</th>
        <th scope="col">Document</th>
        <th scope="col">Price</th>
        <th scope="col">Visiting Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while($row = $result->fetch_assoc()) {
        ?>
        <tr>
          <td data-label="Package Image"><img src="<?php echo htmlspecialchars($row['pack_image']); ?>" alt="Package Image" class="cart_history_img"></td>
          <td data-label="Package Name"><?php echo htmlspecialchars($row['pack_name']); ?></td>
          <td data-label="No. of Days"><?php echo htmlspecialchars($row['no_of_days']); ?></td>
          <td data-label="No. of People"><?php echo htmlspecialchars($row['no_of_people']); ?></td>
          <td data-label="Contact No." class="contact-cell"><?php echo htmlspecialchars($row['phone_no']); ?></td>
          <td data-label="Document">
            <img src="<?php echo htmlspecialchars($row['document']); ?>" alt="Document Image" class="cart_history_img" style="max-width:120px; max-height:80px; border-color:#a9a9a9;">
          </td>
          <td data-label="Price" class="price-cell">₹<?php echo number_format($row['price'], 2); ?></td>
          <td data-label="Visiting Date" class="date-cell"><?php echo date("d-M-Y", strtotime($row['visit_date'])); ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>

<?php
}
include "footer.php";
?>
