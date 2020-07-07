<?php
	include 'cnx.php';
	$action = $_GET['action'];

	if($action= "sex"){
		$query = "select * from users where gender is null";
		$result = mysqli_query($new, $query);
		while ($row = mysqli_fetch_array($result)) {
			$query = "select * from manualcertificate where fullnameen is not null and fullnameen COLLATE utf8_unicode_ci ='".$row['full_name_en']."'";
			$result2 = mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));	
		    if(mysqli_num_rows($result2) > 0){
		    	$row2 = mysqli_fetch_array($result2);
		    	$gender     = $row2['gender'] == 2 ? 'female' : 'male';
				$query  	= "update users set gender ='".$gender."' where id =".$row['id'];
			    mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));	
			}	    	
		}
	}

	if($action= "nationality"){
		$query = "select * from users where government_id is null and nationality != ''";
		$result = mysqli_query($new, $query);
		while ($row = mysqli_fetch_array($result)) {
			$query = "select * from governments_translations where name = '".$row['nationality']."' and lang = 'en' limit 1";
			$result2 = mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));	
		    if(mysqli_num_rows($result2) > 0){
		    	$row2 = mysqli_fetch_array($result2);
				$query  	= "update users set government_id =".$row2['government_id']." where id =".$row['id'];
			    mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));	
			}	    	
		}
	}else{
		$query  = "select * from users where id < 3950";
		$result = mysqli_query($new, $query) or die('error in '.$query.' <br>'.mysqli_error($new));
		while ($row = mysqli_fetch_array($result)) {
			echo "*******************<br>";
			$query  = "select * from users where id > 3950 and full_name_ar != '' and full_name_ar ='".htmlspecialchars($row['full_name_ar'])."'";
			$result2 = mysqli_query($new, $query) or die('error in '.$query.' <br>'.mysqli_error($new));
			if($action == "merge"){
				while ($row2 = mysqli_fetch_array($result2)) {
					if(!isset($row['full_name_en'])){
						$query = "update users set full_name_en ='".$row2['full_name_en']."' where id =".$row['id'];
						mysqli_query($new, $query);
					}
					if(!isset($row['gender'])){
						$gender     = $row2['gender'] == 2 ? 'female' : 'male';
						$query = "update users set gender ='".$gender."' where id =".$row['id'];
						mysqli_query($new, $query);
					}
					if(!isset($row['nationality'])){
						$query = "update users set nationality ='".$row2['nationality']."' where id =".$row['id'];
						mysqli_query($new, $query);
					}

					$query = "select * from students where id =".$row['id'];
					$res = mysqli_query($new, $query);
					if(mysqli_num_rows($res) == 0){
						$query = "insert into students values(".$row['id'].",,now(),now())";
						mysqli_query($new, $query);
					}


					$query = "update students_certificates set student_id =".$row['id']."where student_id=".$row2['id'];
					mysqli_query($new, $query);
					$query = "delete from  users where id=".$row2['id'];
					mysqli_query($new, $query);
					$query = "delete from  students where id=".$row2['id'];
					mysqli_query($new, $query);


				}
			}
			if($action == "show"){
				while ($row2 = mysqli_fetch_array($result2)) {
					echo $row['full_name_ar']." : <br>";
					echo $row['id']." | ".$row['username']." | ".$row['email']." <br>".$row2['id']." | ".$row2['username']." | ".$row2['email'];
					echo '<br>-------------<br>';
				}
			}
		}
	}
?>