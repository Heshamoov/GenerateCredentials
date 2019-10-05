<?php

include ('../config/dbConfig.php');

$grades = $_REQUEST["grades"];

$sql = 	 "SELECT students.first_name 'name', courses.course_name 'grade', batches.name 'section' "
		."FROM ((("
		."academic_years "
		."INNER JOIN batches ON academic_years.id = batches.academic_year_id) "
     	."INNER JOIN courses ON batches.course_id = courses.id) "
     	."INNER JOIN students ON batches.id = students.batch_id) ";


if ($grades !== "")
    $sql = $sql . "WHERE $grades AND academic_year_id = 6 AND batches.is_deleted = 0 ";
else
    $sql = $sql . "WHERE batches.is_deleted = 0 ";

    $sql = $sql . "ORDER BY students.first_name ASC ;";

// echo $sql;
    
$result = $conn->query($sql);

$rownumber = 1;
if ($result->num_rows > 0) {
    echo "<thead>
    		<tr id =out class= w3-custom >
    			<th>Name</th>
    			<th>Grade</th>
    			<th>Section</th>
    		</tr>
    	  </thead>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>"
        	."<td>".$row["name"]."</td>"
        	."<td>".$row["grade"]."</td>"
        	."<td>".$row["section"]."</td>"
        	."</tr>";
    }
} 
    else {
    	echo "No Data Found! Try another search.";
}

$conn->close();
