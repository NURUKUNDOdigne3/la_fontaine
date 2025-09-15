<?php
include "connection.php"
?>
<?php


if (isset($_POST['id'])) {
  $id = $_POST['id'];

  $sql = "DELETE FROM events WHERE Event_ID = $id";
  if ($conn->query($sql) === TRUE) {
    echo "success";
  } else {
    echo "error";
  }
}


?>