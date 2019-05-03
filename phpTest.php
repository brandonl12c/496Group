<?php
	
	include 'functions.php';
	dbConnect();
	
	/*
		All Id types can be identified by the first two digits of the Id
		10 = accountUser
		20 = adminUser
		30 = school
		31 = favSchool
		40 = course
		41 = favCourse
		50 = notes
		51 = favNotes
		60 = request
		70 = ticket
	*/
	
	$accountUserId = 1000000003;
	$adminUserId = 2000000000;
	$schoolId = 3000000001;
	$courseId = 4000000000;
	$favCourseId = 3100000000;
	$favSchoolId = 4100000000;
	$noteId = 5000000000;
	$requestId = 6000000000;
	$ticketId = 7000000000;
	
	$_SESSION['userId'] = $accountUserId;
	//$_POST['commentText'] = "THIS IS A TEST COMMENT 2";
	$_POST['noteId'] = $noteId;
	displayComments();
	
	//submitComment();
	
	echo 	"
				<form action='functions.php' method='post'>
					<input type='hidden' name='noteId' value='$noteId'>
					<input type='hidden' name='commentText' value='THIS IS A TEST COMMENT 2'>
					<input type='submit' name='commentSubmit' value='Submit'>
				</form>
	
			";
	
	
	
/* 	
	$filePath = ".\\docs\\" . $accountUserId . "\\fAvatar.jpg";
	
	$password = 'humptyDumpty';
	$hashed_password = password_hash($password, PASSWORD_ARGON2I);
	echo "<script>alert('$password')</script>";
	echo "<script>alert('$hashed_password')</script>";
	$entered_password = 'humptyDumpty';
	
	$verified = password_verify($entered_password, $hashed_password);
	
	if($verified){
		echo "<script>alert('true')</script>";
	}else{
		echo "<script>alert('false')</script>";
	} */
	
	/*
	TODO FUNCTIONS
	
		NADA
		
	Finished Functions

		dbConnect();
		closeConnection();

		createSchool("schoolName", "acronym", $adminUserId);
		addSchool($accountUserId, $schoolId);
		removeSchool($accountUserId, $schoolId);
		showUserSchools($accountUserId);
		deleteSchool($schoolId);

		createCourse("courseName", "section", $adminUserId, $schoolId);
		addCourse($accountUserId, $schoolId, $courseId);
		deleteCourse($courseId);
		removeCourse($accountUserId, $courseId);
		showUserCourses($accountUserId)
		deleteCourse

		uploadFile();
		deleteFile($filePath);
		showNotes($courseId);
		retrieveFile($notesId);
		downloadFile($notesId);
	*/
?>



<!--
<!DOCTYPE html>

<html>
<body>

<form action="" method="post" enctype="multipart/form-data">
    Select image to upload: <br><br>
    <input type="file" name="file" id="file"><br><br>
    <input type="submit" value="Upload File" name="submit">
</form>

<?php

 	if(isset($_FILES['file'])){
		uploadFile();
	}

?>

    <div class="main">
        <iframe id="fred" style="border:1px solid #666CCC" title="PDF in an i-Frame" src="<?php retrieveFile($notesId); ?>" frameborder="1" scrolling="auto" height="1100" width="850"></iframe>
    </div>


</body>
</html> 

-->













