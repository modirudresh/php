<?php

// get-state-ep.php
if (isset($_POST['countryId'])) {
  $countryId = $_POST['countryId'];
  // Fetch state result based on selected country from database
  $result = mysqli_query($conn, "SELECT * FROM states WHERE country_id = '$countryId'");
  $options = "";
  while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
  }
  echo $options;
}

// get-city-ep.php
if (isset($_POST['stateId'])) {
  $stateId = $_POST['stateId'];
  // Fetch city result based on selected state from database
  $result = mysqli_query($conn, "SELECT * FROM cities WHERE state_id = '$stateId'");
  $options = "";
  while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
  }
  echo $options;
}
?>
<!-- Dependent Dropdown HTML -->
<div>
  <select id="country" name="country">
    <!-- Load country options on page load -->
  </select>
  <select id="state" name="state">
    <!-- Load state options based on selected country -->
  </select>
  <select id="city" name="city">
    <!-- Load city options based on selected state -->
  </select>
</div>


<script>
    // getState() method definition
function getState(countryId) {
  $.ajax({
    type: "POST",
    url: "get-state-ep.php",
    data: {countryId: countryId},
    success: function(response) {
      $("#state").html(response);
    }
  });
}

// getCity() method definition
function getCity(stateId) {
  $.ajax({
    type: "POST",
    url: "get-city-ep.php",
    data: {stateId: stateId},
    success: function(response) {
      $("#city").html(response);
    }
  });
}

// Update dependent dropdown options on change event
$("#country").on("change", function() {
  getState($(this).val());
});

$("#state").on("change", function() {
  getCity($(this).val());
});
</script>