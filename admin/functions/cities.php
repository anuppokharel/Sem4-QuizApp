<?php
    require '../../includes/connection.php';

    $country_id = $_POST['countryId'];
    $options = "<option value=''>Select your city</option>";
    
    $sql = "select * from tbl_cities where country_id = $country_id";

    $query = mysqli_query($connection, $sql);

    while ($city = mysqli_fetch_assoc($query)) {
        $options .= "<option value='$city[id]'>$city[city_name]</option>";
    }

    echo $options;
?>