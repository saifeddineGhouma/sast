<?php
	include 'cnx.php';
	$query  = "select * from accounts_certificate where type='manualcertificate'";
	$result = mysqli_query($old, $query);
	$id = 10000;
	while ($row = mysqli_fetch_array($result)) {
		$id++;
		$student_id     = fetch_or_create_student($row['accounts_id'], $id);
		$course_result  = fetch_or_create_course($row['trainingprograms_id']);
		$certificate    = fetch_or_create_certificate($row['serialnumber'], $student_id, $course_result, $row['date']);
	}

	function fetch_or_create_student($student_id, $id){
		include 'cnx.php';
		if(isset($student_id)){
			$query  = "select u.* from manualcertificate m, users u where m.fullnameen is not null and m.fullnameen COLLATE utf8_unicode_ci = u.full_name_en and m.id = ".$student_id;			
		    $result2 = mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));
		    if(mysqli_num_rows($result2) > 0){
		    	echo "found<br>";
		    	$row2    = mysqli_fetch_array($result2);
				$query   = "select * from students where id =".$row2['id'];
			    $result3 = mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));	
		    	if(mysqli_num_rows($result3) == 0){
					$query  	= "insert into students values (".$row2['id'].", null, now(), now() )";
			    	mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));	
			    }	    	
		    	return $row2['id'] ;
		    }else{
		    	echo "new<br>";
		    	$query  	= "select * from manualcertificate where id = ".$student_id;
		    	$result2 	= mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));
		    	$row2    	= mysqli_fetch_array($result2);
		    	$username	= 'user_'.$student_id;
		    	$query  	= "insert into users(full_name_ar, full_name_en, username, password, active, email_verified, mobile_verified, created_at, updated_at, nationality) values ('".$row2['fullnamear']."','".$row2['fullnameen']."','".$username."','password',0,1,1, now(), now(), '".$row2['nationality']."' )";
		    	mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));
		    	$ids 		= mysqli_insert_id($new);
		    	$query  	= "insert into students values (".$ids.", null, now(), now() )";
		    	mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));
		    	return $ids;
		    }
		}
		return null;
	}

	/*****************************************/
	function fetch_or_create_course($trainingprogram_id){
		include 'cnx.php';
		if(isset($trainingprogram_id)){
			$query  = "select * from courses_mirror where old_id = ".$trainingprogram_id;
			$result = mysqli_query($new, $query)or die('error in $query <br>'.mysqli_error($old));
			if(mysqli_num_rows($result)>0 ){
				$row    = mysqli_fetch_array($result);
				$query  = "select * from certificate where id =".$trainingprogram_id;
				$result2 = mysqli_query($old, $query)or die('error in $query <br>'.mysqli_error($old));
				$row2    = mysqli_fetch_array($result2);
				$fresult = array($row['new_id'],$row2['lectureren']);
				return $fresult;
			}else{
				$query  = "select * from certificate where id =".$trainingprogram_id;
				$result = mysqli_query($old, $query)or die('error in $query <br>'.mysqli_error($old));
				if(mysqli_num_rows($result)>0 ){
					$row   = mysqli_fetch_array($result);
			    	$query = "insert into courses(exam_period, promo_points, language, active, created_at,updated_at) values (0,0,'arabic',1, '".$row['date']."', '".$row['date']."')";
			    	mysqli_query($new, $query) or die('error 4'.mysqli_error($new));
			    	$id    = mysqli_insert_id($new);
			    	$query = "insert into course_translations(course_id, slug, name, lang) values (".$id.",'slug','".$row['name']."','ar')";
			    	mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));
			    	$query = "insert into courses_mirror(old_id, new_id) values (".$trainingprogram_id.",".$id.")";
			    	mysqli_query($new, $query) or die('error in $query <br>'.mysqli_error($new));
			    	$fresult = array($id,$row['lectureren']);
			    	return $fresult;
			    }
			}
		}
		return null;
	}


	/******************************************/
	function fetch_or_create_certificate($serial_number,$student_id, $course, $date){
		include 'cnx.php';
		if(isset($course) && isset($student_id) && isset($serial_number) && isset($date)){
		    $query  = "select * from students_certificates where serialnumber ='".$serial_number."' ";
			$result = mysqli_query($new, $query)or die('error in $query <br>'.mysqli_error($new));
			if(mysqli_num_rows($result)>0 ){
				$query = "update students_certificates set student_id =".$student_id.", course_id = ".$course[0].", teacher_name='".$course[1]."' where serialnumber ='".$serial_number."' ";
				mysqli_query($new, $query)or die('error in $query <br>'.mysqli_error($new));
			}else{
				$query  = "insert into students_certificates(student_id, course_id, teacher_name, serialnumber, image, manual, active, created_at, updated_at) values(".$student_id.", ".$course[0].", '".$course[1]."', '".$serial_number."', 'students certificates/".$serial_number.".jpg',1,1,'".$date."','".$date."')";
		    	mysqli_query($new, $query) or die('error 2 in '.$query.' <br>'.mysqli_error($new));
			}
		}
	} 
?>