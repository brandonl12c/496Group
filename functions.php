<?php


	function dbConnect(){
				
		$hostname = "localhost";
		$dbUsername = "root";
		$dbPassword = "";
		$db = "496db";

		$GLOBALS['connection'] = new mysqli($hostname, $dbUsername, $dbPassword, $db);

		if (!$GLOBALS['connection']){
			echo '<script>';
			echo 'alert("message unsuccessfully sent")';
			echo '</script>';
			die("Connection Failed: " . $GLOBALS['connection']->connect_error);
		}
	}
	
	function closeConnection(){
		mysqli_close($GLOBALS['connection']);
	}

	function removeCourse($accountUserId, $courseId){
		$query = "DELETE FROM userCourses WHERE accountUserId='$accountUserId' AND courseId='$courseId'"; 
		
		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
	}		
	
	function removeSchool($accountUserId, $schoolId){
		$query = "DELETE FROM userCourses WHERE accountUserId='$accountUserId' AND schoolId='$schoolId'"; 
		
		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
		
		$query = "DELETE FROM userSchools WHERE accountUserId='$accountUserId' AND schoolId='$schoolId'"; 

		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}

	}
	
	function addCourse($accountUserId, $schoolId, $courseId){
		
		$query = "SELECT userId FROM accountUser WHERE userId='$accountUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		if($accountUserId == null){
			exit("<script>alert('Account User Does Not Exist!')</script>");
		}
		
		$query = "SELECT schoolId FROM school WHERE schoolId='$schoolId' and isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolId'] == null){
			exit("<script>alert('School Does Not Exist!')</script>");
		}
		
		$query = "SELECT courseId FROM course WHERE courseId='$courseId' and isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['courseId'] == null){
			exit("<script>alert('Course Does Not Exist!')</script>");
		}
		
		$query = "SELECT courseId FROM userCourses WHERE courseId='$courseId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['courseId'] != null){
			exit("<script>alert('Course Already Added')</script>");
		}
		
		$query = "SELECT schoolId FROM userSchools WHERE schoolId='$schoolId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolId'] == null){
			$query = "INSERT INTO userSchools
						(accountUserId, schoolId)
					  VALUES
						('$accountUserId', '$schoolId')";		
			if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
			}
		}
		
		$query = "INSERT INTO userCourses
					(accountUserId, schoolId, courseId)
				  VALUES
					('$accountUserId', '$schoolId', '$courseId')";
		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
		
	}
	
	function addSchool($accountUserId, $schoolId){
		
		$query = "SELECT userId FROM accountUser WHERE userId='$accountUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		if($accountUserId == null){
			exit("<script>alert('Account User Does Not Exist!')</script>");
		}
		
		$query = "SELECT schoolId FROM school WHERE schoolId='$schoolId' and isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolId'] == null){
			exit("<script>alert('School Does Not Exist!')</script>");
		}
		
		$query = "SELECT schoolId FROM userSchools WHERE schoolId='$schoolId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolId'] != null){
			exit("<script>alert('School Already Added')</script>");
		}
		
		$query = "INSERT INTO userSchools
					(accountUserId, schoolId)
				  VALUES
					('$accountUserId', '$schoolId')";
					
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}
		
	}
	
	function createCourse($courseName, $section, $adminUserId, $schoolId){
		$query = "SELECT userId FROM adminUser WHERE userId='$adminUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		if($adminUserId == null){
			exit("<script>alert('Admin User Does Not Exist!')</script>");
		}
		
		$query = "SELECT schoolId AS schoolId FROM school WHERE schoolId='$schoolId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$schoolId = $row['schoolId']; 
		
		if($schoolId == null){
			exit("<script>alert('That School Does Not Exist!')</script>");
		}
		
		$query = "SELECT section FROM course WHERE section='$section'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		if($row['section'] != null){
			exit("<script> alert('Course Section Already Exists') </script>");
		}
		
		$query = "SELECT MAX(courseId) AS courseId FROM course";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$courseId = $row['courseId'];
		
		if($courseId != Null){
			$courseId += 1;
		}else{
			$courseId = 4000000000;
		}
		
		$query = "INSERT INTO course
					(courseId, schoolId, courseName, section, adminUserId) 
				  VALUES 
					('$courseId', '$schoolId', '$courseName', '$section', '$adminUserId')";
					
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}		
		
	}
	
	function createSchool($schoolName, $acronym, $adminUserId){
		
		$query = "SELECT userId FROM adminUser WHERE userId='$adminUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		if($adminUserId == null){
			exit("<script>alert('Admin User Does Not Exist!')</script>");
		}
		
		$query = "SELECT schoolName FROM school WHERE schoolName='$schoolName'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolName'] != null){
			exit("<script>alert('School Already Exists!')</script>");
		}
		
		$query = "SELECT MAX(schoolId) AS schoolId FROM school";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		$schoolId = $row['schoolId'];
		
		if($schoolId != Null){
			$schoolId += 1;
		}else{
			$schoolId = 3000000000;
		}

		$query = "INSERT INTO school
					(schoolId, schoolName, acronym, adminUserId) 
				  VALUES 
					('$schoolId', '$schoolName', '$acronym', '$adminUserId')";
					
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}
		
	}
	
	function showSchools(){
		$query = "SELECT schoolName, acronym FROM school WHERE isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		
		//while($row = mysqli_fetch_assoc($result){
		//	echo "<br>" . $row['schoolName'] . " (" . $row['acronym'] .")";
		//}
		
	}
	
	function showCourses(){
		
	}
	
	function showNotes(){
		
	}
	
	function testPage(){
		echo "<script>alert('IT WORKS')</script>";
	}
	
	function showUserSchools($accountUserId){			
		$query = "	SELECT 
						school.schoolId, school.schoolName
					FROM 
						userSchools 
					INNER JOIN
						school
					ON 
						userSchools.schoolId=school.schoolId
					WHERE 
						userSchools.accountUserId='$accountUserId' AND school.isDeleted=0
					ORDER BY school.schoolName ASC"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
			
		while($row = mysqli_fetch_assoc($result)){
			echo '<li class="list-group-item" role="button" href="#collapse' . $row['schoolId'] .'" data-toggle="collapse" id="schoolListTxt" ><data value="' . $row['schoolId'] . '">' . $row['schoolName'] . '</li>';
			showUserCourses($row['schoolId']);
		}	
	}
	
	function showUserCourses($schoolId){			
		$query = "	SELECT 
						course.courseId, course.section
					FROM 
						userCourses 
					INNER JOIN
						course
					ON 
						userCourses.courseId=course.courseId
					WHERE 
						course.schoolId='$schoolId' AND course.isDeleted=0
					ORDER BY course.section ASC"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
			
			
		echo '	<div class="collapse" id="collapse' . $schoolId .'">';
		$i = 0;
		while($row = mysqli_fetch_assoc($result)){
			echo '<form id="courseForm' . $row['courseId'] . '" action="./viewNotes.php" method="post">';
			echo '
				<input type="hidden" name="courseId" value="' . $row['courseId'] . '"/>
				<a class="dropdown-item" href="javascript:{}" onclick="document.getElementById(\'courseForm' . $row['courseId'] . '\').submit();" id="courseListTxt' . $row['courseId'] . '">	
					' . $row['section'] . '
				</a>
			';
			echo '</form>';
			
			$i++;
		}	
		echo '</div>';
	}
	
	function showUserNotes($accountUserId){
				$query = "	SELECT 
						note.noteId, note.noteName, note.courseId
					FROM 
						userNotes 
					INNER JOIN
						note
					ON 
						userNotes.noteId=note.noteId
					WHERE 
						accountUserId='$accountUserId'"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
			
		while($row = mysqli_fetch_assoc($result)){
			echo '<form id="noteForm' . $row['noteId'] . '" action="./viewNotes.php" method="post">';
			echo '
			<input type="hidden" name="noteId" value="' . $row['noteId'] . '"/>
			<input type="hidden" name="courseId" value="' . $row['courseId'] . '"/>
			<li class="list-group-item" href="javascript:{}" onclick="document.getElementById(\'noteForm' . $row['noteId'] . '\').submit();"  id="courseListTxt">' . $row['noteName'] . '</li>';			
			echo '</form>';
		}	
	}
	
	function uploadFile(){
		$accountUserId = 1000000000;
		$courseId = 4000000000;
		$fileName = $_FILES['file']['name'];
		$noteDir = ".\\docs\\";
		$userDir = $noteDir . $accountUserId;
		$newFilePath = $userDir . "\\" . $fileName;
		$fileType = strtolower(pathinfo($newFilePath, PATHINFO_EXTENSION));
		
		
		//Section to check file type
		$accept = false;
		$whiteList = array("doc", "docx", "txt", "tex", "jpg", "jpeg", 
							"gif", "png", "bmp", "pdf", "xml", 
							"ico", "html", "htm", "xhtml", "php",
							"js", "css", "ppt", "pptx");
			
			
		$accept = in_array($fileType, $whiteList);
		
		if(!$accept){
			exit("<script> alert('Extension Type Not Allowed: " . $fileType . "')</script>");
		}
		
		if(file_exists($newFilePath)){
			exit("<script> alert('File Already Exists!')</script>");
		}
		
		if(!is_dir($userDir)){
			if(!mkdir($userDir)){
				echo "<script> alert('File : " . $fileName . " Failed to Upload: No Such Directory')</script>";
			}
		}
		
		$query = "SELECT MAX(noteId) AS max FROM note";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		if($noteId['max'] != null){
			$noteId = $row['max'] + 1;
		}else{
			$noteId = 5000000000;
		}
		
		if(move_uploaded_file($_FILES['file']['tmp_name'], $newFilePath)){
			
			
			$query = "INSERT INTO note
						(noteId, userId, courseId, noteName)
					  VALUES
						('$noteId', '$accountUserId', '$courseId', '$fileName')";
			if(mysqli_query($GLOBALS['connection'], $query)){
				echo "<script> alert('File : " . $fileName . " has been uploaded')</script>";
			}else{
				echo "<script> alert('File : " . $fileName . " Failed to Upload: Database Error')</script>";
				if(!mysqli_query($GLOBALS['connection'], $query)){
						die(mysqli_error($GLOBALS['connection']));
				} 
			}
			
		}else{
			echo "<script> alert('File : " . $fileName . " Failed to Upload: Unkown Error')</script>";
		}
		
	}
	
	function deleteFile($fileId){

		$query = "SELECT userId, noteName FROM note WHERE noteId='$fileId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		$accountUserId = $row['userId'];
		$fileName = $row['noteName'];


		$filePath = ".\\docs\\" . $accountUserId . "\\" . $fileName;
		

		
		if(!unlink($filePath)){
			echo "File Does Not Exist";
		}else{
			echo "Deleted " . $filePath;
			$query = "DELETE FROM note WHERE noteId='$fileId'";
			mysqli_query($GLOBALS['connection'], $query);
		}
	}
	
	function retrieveFile($fileId){
		
		$query = "SELECT userId, noteName FROM note WHERE noteId='$fileId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		$accountUserId = $row['userId'];
		$fileName = $row['noteName'];


		$filePath = ".\\docs\\" . $accountUserId . "\\" . $fileName;
		
		return $filePath;
		
	} 
	
	function downloadFile($fileId){

		//$filePath = ".\\docs\\1000000000\\EmploymentOpportunitywithDRES.pdf";
		
		$filePath = retrieveFile($fileId);
		
	    header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		
		readfile($filePath);
	}
	
	function deleteSchool($schoolId){
		$query = 	"UPDATE school
					SET isDeleted=1
					WHERE schoolId='$schoolId'";
		if(mysqli_query($GLOBALS['connection'], $query)){
		
		}else{
			die(mysqli_error($GLOBALS['connection']));
		}
	}

	function deleteCourse($courseId){
		$query = 	"UPDATE course
					SET isDeleted=1
					WHERE courseId='$courseId'";
		if(mysqli_query($GLOBALS['connection'], $query)){
		
		}else{
			die(mysqli_error($GLOBALS['connection']));
		}
	}
?>