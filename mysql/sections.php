<?php

include ('../config/dbConfig.php');

$grades = $_REQUEST["grades"];

$sql = "SELECT DISTINCT batches.name batch FROM batches "
     . "INNER JOIN courses  ON batches.course_id = courses.id ";

if ($grades !== "")
    $sql = $sql . "WHERE $grades AND academic_year_id = 6 AND batches.is_deleted = 0 ";
else
    $sql = $sql . "WHERE academic_year_id = 6 AND batches.is_deleted = 0 ";

    $sql = $sql . "ORDER BY batches.name ASC ;";

// echo $sql;
    
$result = $conn->query($sql);

while ($row = mysqli_fetch_array($result))
    echo $row['batch'] . "\t";

$conn->close();
