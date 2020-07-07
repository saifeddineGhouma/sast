<!DOCTYPE html>
<html>
<head>
	<title>Update users infos</title>
</head>
<body>
<?php
	include 'cnx.php';
	if(isset($_POST['id'])){
		$query  = "update users set full_name_ar = '".$_POST['userar']."', full_name_en = '".$_POST['useren']."', gender= '".$_POST['gender']."' where id =".$_POST['id'];
		$result = mysqli_query($new, $query) or die(mysqli_error($new)."<br>".$query);
		echo "<span style='color: green;'>enregistré avec succès</span> <br>";

	}
		$query  = "select u.* from users u, students s, students_certificates sc where sc.student_id = s.id and s.id = u.id and (u.full_name_ar is null or u.full_name_ar = '' or u.full_name_en is null or u.full_name_en = '' or u.gender = '' or u.gender is null and u.id != 1) GROUP by u.id order by u.id desc";
		$result = mysqli_query($new, $query);
		echo "Il vous reste à modifier ".mysqli_num_rows($result)." utilisateur(s)<br/><br/><br/>";
		while ($row = mysqli_fetch_array($result)) {
			if (!isset($row['full_name_ar'])&&!isset($row['full_name_en'])) { // évite les membres pairs
        		continue;
    		}
	?>
		<form action="update_users.php" method="post">
			<input type="hidden" name="id" class="val" value="<?php echo $row['id']; ?>">
			<input type="text" name="userar" class="val" value="<?php echo $row['full_name_ar']; ?>">
			<input type="text" name="useren" class="val" value="<?php echo $row['full_name_en']; ?>">
			<select name="gender" class="val">
				<option value="" ></option>
				<option value="male" <?php $row['gender'] == 'male' ? 'selected' : '' ;  ?> >Male</option>
				<option value="female" <?php $row['gender'] == 'female' ? 'selected' : '' ;  ?> >Female</option>
			</select>
			<input type="submit" value="submit" >
		</form>
		<br/>
	<?php
			break;
		}
?>

</body>
</html>
