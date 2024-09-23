<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bike Edit</title>
  <link rel="stylesheet" href="bike-edit.css">
</head>

<body>
  <?php

  include 'connection.php';
  include 'menu.php';

  // Get the bike ID from the URL query string
  $bikeid = isset($_GET['bikeid']) ? (int) $_GET['bikeid'] : '';

  echo "Bike ID: $bikeid";
  // Validate bike ID (optional)
  if ($bikeid <= 0) {
    echo "Invalid bike ID.";
    exit;
  }

  // Sanitize the bike ID
  $bikeid = $conn->real_escape_string($bikeid);

  $sql = "SELECT * FROM bikes WHERE bikeid = $bikeid";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $bike = $result->fetch_assoc();

    // Pre-fill the form with existing data
    $bike_name = htmlspecialchars($bike['bname']);
    $brand = htmlspecialchars($bike['brand']);
    $type = htmlspecialchars($bike['btype']);
    $displacement = htmlspecialchars($bike['enginecc']);
    $price = htmlspecialchars($bike['price']);
    $image = htmlspecialchars($bike['image']);

    echo "<h2>Edit Bike</h2>
  <form action='update-bike.php' method='post'  enctype='multipart/form-data'>
    <input type='hidden' name='bikeid' value='$bikeid'>
    <label for='bike_name'>Bike Name:</label>
    <input type='text' name='bike_name' id='bike_name' value='$bike_name' required>
    <br>
    <label for='brand'>Brand:</label>
    <input type='text' name='brand' id='brand' value='$brand' required>
    <br>
    <label for='type'>Type:</label>
    <input type='text' name='type' id='type' value='$type' required>
    <br>
    <label for='displacement'>Displacement (cc):</label>
    <input type='number' name='displacement' id='displacement' value='$displacement' required>
    <br>
    <label for='price'>Price:</label>
    <input type='number' name='price' id='price' value='$price' required>
    <br>
    <label for='image'>Current Image:</label><br>
      <img src='$image;' alt='$bike_name' width='100'><br>
      <label for='image'>Upload New Image:</label>
      <input type='file' name='image' id='image'>
      <br>
    <button type='submit'>Save Changes</button>
  </form>";
  } else {
    echo "Bike not found with ID: $bikeid";
  }

  $conn->close();
  ?>
</body>

</html>