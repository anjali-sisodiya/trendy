<?php

include "../../dbconfig.php";
$state_id = $_POST["state_id"];
$sql = "SELECT * FROM city WHERE state_id =".$state_id. " ORDER BY name ASC";
$result = $conn->query($sql);
$html = '';
while($row=$result->fetch_assoc()){                      
$html.= "<option value='".$row['id']."'>".$row['name']."</option>";
}
echo $html;

?>