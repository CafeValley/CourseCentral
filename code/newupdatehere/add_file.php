<?php
	error_reporting(E_ALL);
	
    // Check if a file has been uploaded
    if(isset($_FILES['uploaded_file'])) {
        // Make sure the file was sent without errors
        if($_FILES['uploaded_file']['error'] == 0) {
            // Connect to the database
	
			
            $dbLink = new mysqli("localhost","root","", 'adminstration');
			
            if(mysqli_connect_errno()) {
                die("MySQL connection failed: ". mysqli_connect_error());
            }
     
            // Gather all required data
            $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
            $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
            $data = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
            $size = intval($_FILES['uploaded_file']['size']);
     
            // Create the SQL query
            $query = "
                INSERT INTO `file` (
                    `name`, `mime`, `size`, `data`, `created` , `product_name` , `product_describtion` , `product_quentity` , `product_price` 
                )
                VALUES (
                    '{$name}', '{$mime}', {$size}, '{$data}', NOW() ,'$_POST[product_name]' , '$_POST[product_describtion]' , '$_POST[product_quentity]' , '$_POST[product_price]'
                )";
			
			
            // Execute the query
            $result = $dbLink->query($query);
     
            // Check if it was successfull
            if($result) {
                echo 'Success! Your Product was Successfully Added!';
            }
            else {
                echo 'Error! Failed to insert the file'
                   . "<pre>{$dbLink->error}</pre>";
            }
        }
        else {
            echo 'An error accured while the file was being uploaded. '
               . 'Error code: '. intval($_FILES['uploaded_file']['error']);
        }
     
        // Close the mysql connection
        # Free the mysqli resources
       @mysql_free_result($result);
       @mysql_close($dbLink);    }
    else {
        echo 'Error! A file was not sent!';
    }
     
    // Echo a link back to the main page
    echo '<p>Click <a href="admin_page.html">here</a> to go back</p>';
?>
     
     

