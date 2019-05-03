<?php

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
		80 = comment
	*/

	dbConnect();
	session_start();
	
	if(isset($_POST['ticketSubmit'])){
		submitTicket();
	}
	if(isset($_POST['removeCourse'])){
		removeCourse();
	}
	if(isset($_POST['removeSchool'])){
		removeSchool();
	}
	if(isset($_POST['addCourse'])){
		addCourse();
	}
	if(isset($_POST['addSchool'])){
		addSchool();
	}
	if(isset($_POST['createCourse'])){
		createCourse();
	}
	if(isset($_POST['createSchool'])){
		createSchool();
	}
	if(isset($_POST['showSchools'])){
		showSchools();
	}
	if(isset($_POST['showCourses'])){
		showCourses();
	}
	if(isset($_POST['showNotes'])){
		showNotes();
	}
	if(isset($_POST['showUserSchools'])){
		showUserSchools();
	}
	if(isset($_POST['showUserCourses'])){
		showUserCourses();
	}
	if(isset($_POST['uploadFile'])){
		uploadFile();
	}
	if(isset($_POST['deleteFile'])){
		deleteFile($_POST['deletedFile']);
	}
	if(isset($_POST['retrieveFile'])){
		retrieveFile();
	}
	if(isset($_POST['downloadFile'])){
		downloadFile();
	}
	if(isset($_POST['deleteSchool'])){
		deleteSchool();
	}
	if(isset($_POST['deleteCourse'])){
		deleteCourse();
	}
	if(isset($_POST['listSchools'])){
		listSchools();
	}
	if(isset($_POST['listCourses'])){		
		listCourses();
	}
	if(isset($_POST['commentSubmit'])){
		submitComment();
	}
	if(isset($_POST['submit_add_course'])){
		addCourse();
	}
	if(isset($_POST[''])){
		
	}

/*
-------------------------------------------------
ALL FUNCTIONS UNDER THIS LINE
-------------------------------------------------
*/

	function dbConnect(){
		
		//sets variables for the database connection
		$hostname = "localhost";
		$dbUsername = "root";
		$dbPassword = "";
		$db = "496db";

		//Establishes new mysqli connection and saves that connection as a global variable
		$GLOBALS['connection'] = new mysqli($hostname, $dbUsername, $dbPassword, $db);

		//Checks to make sure the connection was established
		if (!$GLOBALS['connection']){
			echo '<script>';
			echo 'alert("message unsuccessfully sent")';
			echo '</script>';
			die("Connection Failed: " . $GLOBALS['connection']->connect_error);
		}
	}

	function user_logout(){
		
		//unsets all session variables, destroys the session and redirects
		session_unset(); 
		session_destroy(); 
		header("location: index.php");
	}
	
	function closeConnection(){
		//closes the global db connection
		mysqli_close($GLOBALS['connection']);
	}

	function removeCourse(){
		
		//Retrieves data for query
		$accountUserId = $_SESSION['userId'];
		$favCourseId = $_POST['favCourseId'];

		//Query to find the course in userCourses and also get the associated school id
		$query = "	SELECT
						schoolId
					FROM
						userCourses
					WHERE
						favCourseId='$favCourseId'
			";
			
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);		
		$schoolId = $row['schoolId'];
		
		echo $schoolId;
		
		//query to delete the course from userCourses
		$query = "DELETE FROM userCourses WHERE accountUserId='$accountUserId' AND favCourseId='$favCourseId'"; 
		
		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
		
		//query to see if the schoolId exists for the current user in the userCourses
		//If so, it redirect back to home
		//Otherwise, the schoolId is removed from userSchools for the current user
		$query = "	SELECT
						schoolId
					FROM
						userCourses
					WHERE
						schoolId='$schoolId' 
						AND accountUserId='$accountUserId'
			";
			
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		if($row['schoolId'] == null){
			removeSchool($accountUserId, $schoolId);
		}else{
			header("Location: ./home.php");
		}
		
		
	}		
	
	function removeSchool($accountUserId, $schoolId){
		
		//makes sure all userCourses are removed for the selected school
		$query = "DELETE FROM userCourses WHERE accountUserId='$accountUserId' AND schoolId='$schoolId'"; 
		
		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
		
		//deletes the school from userSchools for current user
		//Then redirects to home
		$query = "DELETE FROM userSchools WHERE accountUserId='$accountUserId' AND schoolId='$schoolId'"; 

		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
		header("Location: ./home.php");

	}
	
	

	function addCourse(){
		
		//Checks to make sure all necessary data has been properly set in POST and SESSION
		//alerts error and redirects if not
		//otherwise, the data is stored in the appropriate varaibles
		if(isset($_SESSION['userId']) && isset($_POST['addC_Sch_selection']) && isset($_POST['addC_Course_selection'])){
			$accountUserId = $_SESSION['userId'];
			$schoolId = $_POST['addC_Sch_selection'];
			$courseId = $_POST['addC_Course_selection'];
		}else{
			exit("	<script>
						alert('Something Went Wrong');
						window.location.href = './home.php';
					</script>");
		}
		
		//Checks to make sure the accountUser exists in the database
		//Just an extra layer to catch errors
		$query = "SELECT userId FROM accountUser WHERE userId='$accountUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		if($accountUserId == null){
			exit("	<script>
						alert('Account User Does Not Exist!');
						window.location.href = './home.php';
					</script>");
		}
		
		//Checks to see if the school exists in the school table and has not been soft deleted
		$query = "SELECT schoolId FROM school WHERE schoolId='$schoolId' and isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolId'] == null){
			exit("	<script>
						alert('School Does Not Exist!');
						window.location.href = './home.php';
					</script>");
		}
		
		//Checks to see if the course exists in the course table and has not been soft deleted
		$query = "SELECT courseId FROM course WHERE courseId='$courseId' and isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['courseId'] == null){
			exit("	<script>
						alert('Course Does Not Exist!');
						window.location.href = './home.php';
					</script>");
		}

		//Checks to see if the course exists in the userCourses table
		$query = "SELECT courseId FROM userCourses WHERE courseId='$courseId' AND accountUserId = '$accountUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['courseId'] != null){
			exit("	<script>
						alert('Course Already Added');
						window.location.href = './home.php';
					</script>");
		}
		
		//Checks to see if the schoolId exists in the userSchools table for the current user
		//If not, then the school is added to userSchools for the current account user
		//Otherwise nothing
		$query = "SELECT schoolId FROM userSchools WHERE schoolId='$schoolId' AND accountUserId = '$accountUserId'";
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
		
		
		//Adds the course is added to userCourses for the current account user
		//Then redirects to home
		$query = "INSERT INTO userCourses
					(accountUserId, schoolId, courseId)
				  VALUES
					('$accountUserId', '$schoolId', '$courseId')";
		if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
		}
		
		header("Location: ./home.php");

	}
	
	function addSchool($accountUserId, $schoolId){
		
		//Checks to see if the user exists in the accountUser table
		//If not, an error alert is shown
		$query = "SELECT userId FROM accountUser WHERE userId='$accountUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		if($accountUserId == null){
			exit("<script>alert('Account User Does Not Exist!')</script>");
		}
		
		//Checks to see if the school exists in the school table
		//If not, an error alert is shown
		$query = "SELECT schoolId FROM school WHERE schoolId='$schoolId' and isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolId'] == null){
			exit("<script>alert('School Does Not Exist!')</script>");
		}
		
		//Checks to see if the school already exists in userSchools
		//If so, an error alert is shown
		//Otherwise, a query is run to insert the school into userSchools
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
	
	function createCourse(){
		
		//Retrieves and stores approprate data
		$schoolName = $_POST['sName'];
		$courseName = $_POST['cName'];
		$courseSection = $_POST['section'];
		$adminUserId = $_SESSION['adminId']; 
		
		//Checks to see if the school exists in the database
		//If not, the admin user is redirected back to the admin home
		$query = "SELECT * FROM school WHERE schoolName='$schoolName' AND isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$schoolId = $row['schoolId'];
		if($row['schoolId'] == null){
			echo "<script>alert('School Not Exists!')</script>";                
			echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
		}

		//Checks to see if the course already exists. 
		//If so, the admin user is redirected back to the admin home
		$query = "SELECT courseName FROM course WHERE courseName='$courseName' AND schoolId = '$schoolId' AND isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$query1 = "SELECT courseName FROM course WHERE section='$courseSection' AND schoolId = '$schoolId' AND isDeleted=0";
		$result1 = mysqli_query($GLOBALS['connection'], $query1);
		$row1 = mysqli_fetch_array($result1);
		if($row['courseName'] != null || $row1['courseName'] != null){
			echo "<script>alert('Course Already Exists!')</script>";
			echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
		}else{
			
			//If the course does exist but has been previously soft deleted the
			//	the isDeleted value is set back to 1
			//This essentialy undos the soft delete and redirects the admin user
			$query = "SELECT courseName FROM course WHERE courseName ='$courseName' AND isDeleted=1";
			$result = mysqli_query($GLOBALS['connection'], $query);
			$row = mysqli_fetch_array($result);
			if($row['courseName'] != null){
				$query = 	"UPDATE course
				SET isDeleted=0
				WHERE courseName='$courseName'";
				$result = mysqli_query($GLOBALS['connection'], $query);
				echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
			}
			
			//If the course does not exist at all, the max id is retrieved from the database
			//	and then incremented.
			$query = "SELECT MAX(courseId) AS courseId FROM course";
			$result = mysqli_query($GLOBALS['connection'], $query);
			$row = mysqli_fetch_array($result);
			
			$courseId = $row['courseId'];
			
			if($courseId != Null){
				$courseId += 1;
			}else{
				$courseId = 4000000000;
			}

			//Inserts the course into the course table with the previously set data
			$query = "INSERT INTO course
						(courseId, schoolId, courseName, section, adminUserId) 
						VALUES 
						('$courseId', '$schoolId', '$courseName', '$courseSection', '$adminUserId')";
						
			if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
			}
		}
	}
	
	function createSchool(){
		
		//Retrieves and stores approprate data
		$schoolName = $_POST['sName'];
		$acronym = $_POST['acronym'];
		$adminUserId = $_SESSION['adminId'];
		$query = "SELECT userId FROM adminUser WHERE userId='$adminUserId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		$adminUserId = $row['userId']; 
		
		//makes sure adminUserId has been set
		if($adminUserId == null){
			exit("<script>alert('Admin User Does Not Exist!')</script>");
		}
		
		//Checks to see if the school already exists in school
		$query = "SELECT schoolName FROM school WHERE schoolName='$schoolName' AND isDeleted=0";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);

		if($row['schoolName'] != null){
			exit("<script>alert('School Already Exists!')</script>");
		}

		//Checks to see if school exists but has been previously soft deleted
		//If so, the soft delete is undone and the user is redirected to admin home
		$query = "SELECT schoolName FROM school WHERE schoolName='$schoolName' AND isDeleted=1";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		if($row['schoolName'] != null){
			$query = 	"UPDATE school
			SET isDeleted=0
			WHERE schoolName='$schoolName'";
			$result = mysqli_query($GLOBALS['connection'], $query);
			echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
		}
		
		//If the school does not exist at all, the max id is retrieved from school and incremented
		$query = "SELECT MAX(schoolId) AS schoolId FROM school";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		$schoolId = $row['schoolId'];
		
		if($schoolId != Null){
			$schoolId += 1;
		}else{
			$schoolId = 3000000000;
		}

		//Inserts the new school into school
		$query = "INSERT INTO school
					(schoolId, schoolName, acronym, adminUserId) 
					VALUES 
					('$schoolId', '$schoolName', '$acronym', '$adminUserId')";
					
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}
		
	}
		
	function showNotes($courseId){
		
		//Retrieves all notes for the selected courseId
		$query = "	SELECT 
						*
					FROM
						note
					WHERE
						courseId='$courseId'
				";
		$result = mysqli_query($GLOBALS['connection'], $query);
		
		//iterates through the query results and echoes out forms for each note
		while($row = mysqli_fetch_assoc($result)){
			$noteId = $row['noteId'];
			$filePath = retrieveFile($noteId);
			
			//echo "<a href='https://docs.google.com/gview?url=http://ec2-18-223-15-205.us-east-2.compute.amazonaws.com/cs496/docs/". $filePath ."embedded=true' target='docFrame'>" . $row['noteName'] . "</a>";
			
			echo "	<form action='' method='post' id='noteForm2".$noteId."'>
						<input type='hidden' name='noteId' value='".$noteId."'>
						<input type='hidden' name='courseId' value='".$courseId."'>
						<input id='notesLink' type='submit' value='".$row['noteName']."'>	
					</form>
					<br/><hr/>
					";
		}
	}
	
	function showMyNotes(){
		
		$userId = $_SESSION['userId'];
		
		//Retrieves all notes for the current user
		$query = "	SELECT 
						noteId, noteName
					FROM
						note
					WHERE
						accountUserId='$userId'
				";
		$result = mysqli_query($GLOBALS['connection'], $query);
		
		//iterates through the query results and echoes out forms for each note
		//	as well as a delete form
		while($row = mysqli_fetch_assoc($result)){
			$noteId = $row['noteId'];
			
			echo "	<hr style='display: inline-block; width: 150px;'>
					<form action='' method='post' id='noteForm2".$noteId."'>
						<input type='hidden' name='noteId' value='".$noteId."'>
						<input id='notesLink' type='submit' value='".$row['noteName']."'>	
					</form>
					";
			echo "	<form action='functions.php'  method='post'>
						<input type='hidden' name='deletedFile' value='" . $noteId . "'></input>
						<input id='notesLinkDelete' type='submit' name='deleteFile' value='Delete'></input>
					</form>
					<br/>
				";
		}
	}
	
	function showUserSchools($accountUserId){	

		//Query to find all schools that the user has favorited
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
			
		//iterates through the results and creates a list/dropdown toggle item for each school
		//calls function to get userCourses for each school
		while($row = mysqli_fetch_assoc($result)){
			echo '<li class="list-group-item" role="button" href="#collapse' . $row['schoolId'] .'" data-toggle="collapse" id="schoolListTxt" ><data value="' . $row['schoolId'] . '">' . $row['schoolName'] . '</li>';
			showUserCourses($row['schoolId']);
		}	
	}
	
	function showUserCourses($schoolId){			
		$userId = $_SESSION['userId'];
	
		//Query to find all courses that the user has favorited
		$query = "	SELECT 
						course.courseId, course.section, userCourses.favCourseId
					FROM 
						userCourses 
					INNER JOIN
						course
					ON 
						userCourses.courseId = course.courseId
					WHERE 
						course.schoolId='$schoolId' 
						AND course.isDeleted=0
						AND userCourses.accountUserId = '$userId'
					ORDER BY course.section ASC"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
			
			
		echo '	<div class="collapse" id="collapse' . $schoolId .'">';

		//iterates through the results and creates a form/dropdown item for each course
		while($row = mysqli_fetch_assoc($result)){
			echo '	<form class="userCourseForm" id="courseForm' . $row['courseId'] . '" action="./viewNotes.php" method="post">';
			echo '
				<input type="hidden" name="courseId" value="' . $row['courseId'] . '"/>
				<a class="dropdown-item" href="javascript:{}" onclick="document.getElementById(\'courseForm' . $row['courseId'] . '\').submit();" id="courseListTxt' . $row['courseId'] . '">	
					' . $row['section'] . '
				</a>
			';
			echo '</form>';
			
			echo "
					<form action='functions.php' method='post'>
						<input type='hidden' name='favCourseId' value='" . $row['favCourseId'] . "'></input>
						<input id='favCourseRemove' type='submit' name='removeCourse' value='Remove'></input>
					</form>
				";
			echo "	<hr style='display: inline-block; width: 100%;'>";	
				
			
			
		}	
		echo '</div>';
	}
	
	function showUserNotes($accountUserId){
		
		//Query to find all courses that the user has favorited
				$query = "	SELECT 
						note.noteId, note.noteName, note.courseId
					FROM 
						userNotes 
					INNER JOIN
						note
					ON 
						userNotes.noteId=note.noteId
					WHERE 
						userNotes.accountUserId='$accountUserId'"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
			
		//iterates through the results and creates a form for each note
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
		
		//Retrieves and sets all appropriate data
		$accountUserId = $_SESSION['userId'];
		$courseId = $_POST['courseId'];
		$fileName = $_FILES['file']['name']; 
		$noteDir = ".\\docs\\";
		$userDir = $noteDir . $accountUserId;
		$newFilePath = $userDir . "\\" . $fileName;
		$fileType = strtolower(pathinfo($newFilePath, PATHINFO_EXTENSION));
		$fileNameOnly = strtolower(pathinfo($newFilePath, PATHINFO_FILENAME));
		
		//Section to check file type
		$accept = false;
		$whiteList = array("doc", "docx", "txt", "tex", "jpg", "jpeg", 
							"gif", "png", "bmp", "pdf", "xml", 
							"ico", "html", "htm", "xhtml", "php",
							"js", "css", "ppt", "pptx");
			
		//checks to see if the filetype is in the whitelist
		$accept = in_array($fileType, $whiteList);
		
		//sends alert if file extension is not white listed
		if(!$accept){
			exit("<script> alert('Extension Type Not Allowed: " . $fileType . "')</script>");
		}
		
		//sends alert if the file already exists
		if(file_exists($newFilePath)){
			exit("<script> alert('File Already Exists!')</script>");
		}
		
		//Sends alert if the specified directory does not exist
		if(!is_dir($userDir)){
			if(!mkdir($userDir)){
				echo "<script> alert('File : " . $fileName . " Failed to Upload: No Such Directory')</script>";
			}
		}
		
		//attempts to transfer the file to the server and if it is successful
		//	 a query is ran to store all file information in the database
		if(move_uploaded_file($_FILES['file']['tmp_name'], $newFilePath)){
			
			
			$query = "INSERT INTO note
						(`accountUserId`, `courseId`, `noteName`, `datatype`)
					  VALUES
						('$accountUserId', '$courseId', '$fileNameOnly', '$fileType')";
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
		
		echo "	<script>
			window.location.href='./home.php';
		</script>";
		
	}
	
	function deleteFile($fileId){

		//query to find all necessary information of the specified note
		$query = "SELECT accountUserId, noteName, dataType FROM note WHERE noteId='$fileId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		//all appropriate variables are set
		$accountUserId = $row['accountUserId'];
		$fileName = $row['noteName'];
		$dataType = $row['dataType'];

		//establishes the file path based on retrieved data
		$filePath = ".\\docs\\" . $accountUserId . "\\" . $fileName . "." . $dataType ;
		
		//If the files does not exists, an alert is sent
		//Otherwise the file is removed and the database is updated respectively
		if(!unlink($filePath)){
			echo "File Does Not Exist";
		}else{
			$query = "DELETE FROM note WHERE noteId='$fileId'";
			if(!mysqli_query($GLOBALS['connection'], $query)){
				die(mysqli_error($GLOBALS['connection']));
			}else{
				echo "	<script>
							alert('Deleted " . $filePath . "');
							window.location.href = './myNotes.php';
						</script>
				";
			}
		}
	}
	
	function retrieveFile($fileId){
		
		//retrieves all necessary information from the database for the specified note
		$query = "SELECT accountUserId, noteName, dataType FROM note WHERE noteId='$fileId'";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		//sets the appropriate variables
		$accountUserId = $row['accountUserId'];
		$fileName = $row['noteName'];
		$fileType = $row['dataType'];

		//establishes the file path
		$filePath = $accountUserId . "\\" . $fileName . "." . $fileType;
		
		return $filePath;
		
	} 
	
	function downloadFile(){

		$fileId = $_POST['noteId'];		
		$filePath = ".\\docs\\" . retrieveFile($fileId);
		
		//necessary header files to perform the download operation
	    header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filePath));
		
		readfile($filePath);
	}
	
	function deleteSchool(){
		
		$schoolName = $_POST['sName1'];
		
		//query to see if school exists in database
		//if not, an error is thrown
		//otherwise the school is soft deleted
		$query = "SELECT * FROM school WHERE schoolName = '$schoolName' "; 
		
		$result = mysqli_query($GLOBALS['connection'], $query);
		if (mysqli_num_rows($result) == 0) {
			echo "<script>alert('No School Match in DataBase')</script>";
			echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
		}else{
			$query = 	"UPDATE school SET isDeleted=1 WHERE schoolName='$schoolName'";
			$result = mysqli_query($GLOBALS['connection'], $query);
		}
	}

	function deleteCourse(){
		$schoolName = $_POST['sName1'];
		$courseName = $_POST['cName1'];
		
		//query to find the school information
		$query = "SELECT * FROM school WHERE acronym = '$schoolName' "; 
		$result = mysqli_query($GLOBALS['connection'], $query);
		
		//query to find all course information
		$query1 = "SELECT * FROM course WHERE section = '$courseName' "; 
		$result1 = mysqli_query($GLOBALS['connection'], $query1);
		if (mysqli_num_rows($result) == 0 ||mysqli_num_rows($result1) == 0) {
			echo "<script>alert('No Match in DataBase')</script>";
			echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
		}else{
			$query = "SELECT * FROM school WHERE acronym='$schoolName' AND isDeleted=0";
			$result = mysqli_query($GLOBALS['connection'], $query);
			$row = mysqli_fetch_array($result);
			$schoolId = $row['schoolId'];
			$query = 	"UPDATE course SET isDeleted=1 WHERE schoolId='$schoolId' AND section = '$courseName'";
			$result = mysqli_query($GLOBALS['connection'], $query);
		}
	}
	
	function submitTicket(){
		
		//Retrieves and sets all appropriate data
		$accountUserId = $_SESSION['userId'];
		$ticketContent = $_POST['ticketContent'];
		$ticketType = $_POST['ticketType'];
		$ticketTopic = $_POST['ticketTopic'];
		
		//Query to insert new ticket into database
		$query = "	INSERT INTO ticket
						(`accountUserId`, `ticketType`, `ticketTopic`, `ticketContent`)
					VALUES
						('$accountUserId', '$ticketType', '$ticketTopic', '$ticketContent')
		";
		
		//Runs query and if the successful, an success alert is showNotes
		//otherwise an error is thrown
		if(mysqli_query($GLOBALS['connection'], $query)){
			echo "	<script>
						alert('Ticket Submitted');
						window.location.href='./home.php';
					</script>";
		}else{
			die(mysqli_error($GLOBALS['connection']));
		}
	}

	function getCourseSection($courseId){
		
		//Query to return the course section for the specified courseId
		$query = "	SELECT 
						section
					FROM
						course
					where courseId = '$courseId'
				";
		
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		return $row['section'];
		
	}

	function listCourses(){
		//Retrieves and sets all appropriate data
		$schoolId = $_POST['listCourses'];
		$courses = array();
		$code = "";
		
		//Query to retrieve the courses information for a school
		//The results are outputted as options for a select list
		$query = "SELECT * FROM course WHERE schoolId='$schoolId' AND isDeleted = 0 "; 
		$result = mysqli_query($GLOBALS['connection'], $query);
		if (mysqli_num_rows($result) != 0) {
			while($row = mysqli_fetch_assoc($result)){
				$code = '<option value="'.$row['courseId'].'" id="added_School" >'.$row['section'].' '.$row['courseName'].'</option>';
				array_push($courses, $code);
			}
			echo JSON_encode($courses);
		}		
	}

	function listCrs_admin(){
		
		$C_query = "SELECT * FROM course WHERE isDeleted = 0 "; 
		$C_query_result = mysqli_query($GLOBALS['connection'], $C_query);
		if (mysqli_num_rows($C_query_result) == 0) {
			echo '<tr><td> No Course </td></tr>';
		}else{
				while($C_query_result_row = mysqli_fetch_assoc($C_query_result)){
					$schoolId = $C_query_result_row['schoolId'];
					$SN_query = "SELECT * FROM school WHERE schoolId = '$schoolId'";
					$SN_query_result = mysqli_query($GLOBALS['connection'], $SN_query);
					$row = mysqli_fetch_assoc($SN_query_result);
					echo '<tr><td> ';
					echo $row['acronym'].' '.$C_query_result_row['section'].': '.$C_query_result_row['courseName'];
					echo '</td></tr>';
				}
			}	
	}

	function listSchools(){
		$schools = array();
		$code = "";
		
		//Query to retrieve the school information for all schools
		//The results are outputted as options for a select list
		$query = "SELECT * FROM school WHERE isDeleted = 0 "; 
		$result = mysqli_query($GLOBALS['connection'], $query);
		
		if (mysqli_num_rows($result) != 0) {
			while($row = mysqli_fetch_assoc($result)){				
				$code = '	<option value="'.$row['schoolId'].'" id="added_School">
									'.$row['schoolName'].'
								</option>';
				array_push($schools, $code);	
			}
			echo JSON_encode($schools); 
		}
	}
	
	function listSch_admin(){
		$S_query = "SELECT * FROM school WHERE isDeleted = 0 "; 
		$S_query_result = mysqli_query($GLOBALS['connection'], $S_query);
		if (mysqli_num_rows($S_query_result) == 0) {
			echo '<tr><td> No Course </td></tr>';
		}else{
				while($S_query_result_row = mysqli_fetch_assoc($S_query_result)){
				echo '<tr><td> ';
				echo $S_query_result_row['acronym'].' '.$S_query_result_row['schoolName'];
				echo '</td></tr>';
				}
			}	
	}

	function getNoteName(){
		$noteId = $_POST['noteId'];
		
		//Query to get note name from noteId 
		$query = "	SELECT
						noteName
					FROM
						note
					WHERE noteId='$noteId'
		";
		
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_assoc($result);
		
		return $row['noteName'];
		
	}
	
	function getNotePath(){
		$noteId = $_POST['noteId'];
		
		//Query to get note path from noteId 
		$query = "	SELECT
						*
					FROM
						note
					WHERE noteId='$noteId'
		";
		
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_assoc($result);
		
		return ".\\docs\\" . $row['accountUserId'] . "\\" . $row['noteName'] . "." . $row['dataType'];
		
	}
	
	function getMyFirstNote(){
		$userId = $_SESSION['userId'];
		
		//Query to retrieve the first note in the list for the user's notes
		$query = "	SELECT
						noteId
					FROM
						note
					WHERE accountUserId='$userId'
				";
		
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_assoc($result);
		
		return $row['noteId'];
	}
	
	function getFirstNote($courseId){
		
		//Query to retrieve the first note in the list for the selected course	
		$query = "	SELECT
						*
					FROM
						note
					WHERE courseId='$courseId'
		";
		
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_assoc($result);
		
		return $row['noteId'];
	}
	
	function displayComments(){
		
		$noteId = $_POST['noteId'];
		
		//query to list all comments and commentor info for the current note
		$query = "	SELECT
						comment.comment AS comment, accountUser.userName AS userName
					FROM
						comment
					INNER JOIN
						accountUser
					ON 
						comment.accountUserId = accountUser.userId
					WHERE
						comment.noteId = '$noteId'
					ORDER BY
						date_time DESC
				";
				
		$result = mysqli_query($GLOBALS['connection'], $query);
		
		while($row = mysqli_fetch_assoc($result)){
				
		//Outputs comments and commentor info in a list
		echo '	<li>
					<div class="commentTxt">
						<p class="userComments">'.$row['comment'].'</p> <span class="user sub-text">-'.$row['userName'].'</span>
						<hr>
					</div>
				</li>
			 ';
		}
		
	}
	
	function submitComment(){
		
		//Retrieves and sets all appropriate data
		$newComment = $_POST['commentText'];
		$userId = $_SESSION['userId'];
		$noteId = $_POST['noteId'];
		$courseId = $_POST['courseId'];
		$date = date("y-m-d h:i:s");
		
		//query to insert the new comment into the comment table
		//	with the associated note id
		$query = "	INSERT INTO
						comment(`accountUserId`,`noteId`,`comment`, `date_time`)
					VALUES
						('$userId', '$noteId', '$newComment', '$date')
				";
				
		if(mysqli_query($GLOBALS['connection'], $query)){
		}else{
			die(mysqli_error($GLOBALS['connection']));
		}
		
		//uses temporary session variables to reload the previous viewNotes/myNotes page
		$_SESSION['noteId'] = $noteId;
		$_SESSION['courseId'] = $courseId;
		header("Location: " . $_SERVER['HTTP_REFERER']);
	}
	









	// ************************************************************************************************************************************
	// ************************************************************************************************************************************
	// lofunctions.php
	// ************************************************************************************************************************************
	// ************************************************************************************************************************************

	function loginValidation(){
		$loginPage = "login.php";
		$homePage = "home.php";
		$email = $_POST['email'];
		$password = $_POST['password'];

		$adminLoginsql = "SELECT * FROM adminUser WHERE email='$email'";
		$adminLoginresult = mysqli_query($GLOBALS['connection'], $adminLoginsql);
		
		$loginsql = "SELECT * FROM accountUser WHERE email='$email'";
		$login_result = mysqli_query($GLOBALS['connection'], $loginsql);

		if(mysqli_num_rows($adminLoginresult) > 0){
				$row = mysqli_fetch_assoc($adminLoginresult);
				//verify argon2I hashed password 
				$verified = password_verify($password, $row['password']);
				//modify after hash hashed password
				if($verified){
						$_SESSION['adminId'] = $row['userId'];
						echo "Admin <br>".$row['userName'].", You are Logged in.";
						//change to admin home page
						echo "<meta http-equiv='refresh' content='1; url=admin_home.php'>";
						exit();
				} else{
						echo "Invalid Email or Password ";
				}
		} else if(mysqli_num_rows($login_result) > 0){
				$user_row = mysqli_fetch_assoc($login_result);
				//verify argon2I hashed password 
				$verified = password_verify($password, $user_row['password']);
				if($verified){
						$_SESSION['userId'] = $user_row['userId'];
						echo "Hi ".$user_row['userName'].",<br> You are Logged in.";
						//echo $user_row['userId'];
						echo "<meta http-equiv='refresh' content='1; url=$homePage'>";
						//exit();
				}else {
						echo "Invalid Email or Password ";
				}
		} else{
				echo "Invalid Email or Password ";
		}
}

function registration(){
		$mynotesPage = "myNotes.php";
		$regPage = "registration.php";
		$username = $_POST['username'];
		$password = $_POST['password'];
		$hashed_password = password_hash($password, PASSWORD_ARGON2I);
		//$hashedPw = sha1($password);
		$email = $_POST['email'];
		$Repeatpassword = $_POST['Repeatpassword'];
		$Fname = $_POST['Fname'];
		$Lname = $_POST['Lname'];
		$loginPage = "login.php";

		$emailsqli = "SELECT * FROM accountUser WHERE email='$email'";
		$email_result = mysqli_query($GLOBALS['connection'], $emailsqli);
		//admin email check
		$admin_emailsqli = "SELECT * FROM adminUser WHERE email='$email'";
		$admin_email_result = mysqli_query($GLOBALS['connection'], $admin_emailsqli);

		if(mysqli_num_rows($email_result) == 0 && mysqli_num_rows($admin_email_result) == 0){
				echo "Registration Complete!<br>";
				//echo "$hashed_password";				
				echo "<meta http-equiv='refresh' content='2; url=$loginPage'>";
				$reg_sql = "INSERT INTO accountUser(userName, `password`, `email`,`Fname`, `Lname`) Values ('$username','$hashed_password','$email','$Fname','$Lname')";
				$reg_result = mysqli_query($GLOBALS['connection'], $reg_sql);
		} else{
				echo "Email already in Use<br><br>";
		}
}

function resetPw(){
		$loginPage = "login.php";
		$username = $_POST['username'];
		$email = $_POST['email'];
		$RepeatEmail = $_POST['RepeatEmail'];
		$password = $_POST['password'];
		$hashed_password = password_hash($password, PASSWORD_ARGON2I);
		$Repeatpassword = $_POST['Repeatpassword'];
		$sqli1 = "SELECT * FROM accountUser WHERE email='$email' AND userName ='$username' ";
		$user_result = mysqli_query($GLOBALS['connection'], $sqli1);
				if(mysqli_num_rows($user_result) > 0){
						echo "<br> Successfully Reset Your Password";
						echo "<meta http-equiv='refresh' content='2; url=$loginPage'>";
						$resetPw_sql = "UPDATE accountUser SET password = '$hashed_password' WHERE email='$email' AND userName ='$username' ";
						$resetResult = mysqli_query($GLOBALS['connection'], $resetPw_sql);
				}else{
						echo "<br> Username and Email Address does not match";
				}         
}


function get_userName(){
		if(isset($_SESSION['userId'])){
		$userId = $_SESSION['userId'];
		$getUsername_sql = "SELECT userName FROM accountUser WHERE userId='$userId'";
		$userName_sql_result = mysqli_query($GLOBALS['connection'], $getUsername_sql);
		$username_row = mysqli_fetch_assoc($userName_sql_result);
		echo $username_row['userName'];
		}else {
		echo "Please Sign in!";
		//********** remove // after **************
		//echo "<meta http-equiv='refresh' content='2; url=$loginPage'>";
		}
}

function get_Admin_userName(){
	if(isset($_SESSION['adminId'])){
		$userId = $_SESSION['adminId'];
		$getUsername_sql = "SELECT * FROM adminUser WHERE userId='$userId'";
		$userName_sql_result = mysqli_query($GLOBALS['connection'], $getUsername_sql);
		$username_row = mysqli_fetch_assoc($userName_sql_result);
		echo $username_row['userName'];
	}else {
		echo "Please Sign in!";
	}
}

function get_userName_loginPage(){
		$homePage = "home.php";
		$admin_homePage = "admin_home.php";
		if(isset($_SESSION['userId'])){
			$userId = $_SESSION['userId'];
			$getUsername_sql = "SELECT userName FROM accountUser WHERE userId='$userId'";
			$userName_sql_result = mysqli_query($GLOBALS['connection'], $getUsername_sql);
			$username_row = mysqli_fetch_assoc($userName_sql_result);
			echo "Hi &nbsp;".$username_row['userName']. ",<br>Redirect to Home page.";
			echo "<meta http-equiv='refresh' content='2; url=$homePage'>";
			exit();
		}else if(isset($_SESSION['adminId'])){
			$userId = $_SESSION['adminId'];
			$get_adminUsername_sql = "SELECT userName FROM adminUser WHERE userId='$userId'";
			$AdminName_sql_result = mysqli_query($GLOBALS['connection'], $get_adminUsername_sql);
			$adminusername_row = mysqli_fetch_assoc($AdminName_sql_result);
				echo "Hi &nbsp;".$adminusername_row['userName']. ",<br>Redirect to Admin_Home page.";
				echo "<meta http-equiv='refresh' content='2; url=$admin_homePage'>";
				exit();
			}
	}


function get_email(){
		if(isset($_SESSION['userId'])){
		$userId = $_SESSION['userId'];
		$get_email_sql = "SELECT email FROM accountUser WHERE userId='$userId'";
		$email_sql_result = mysqli_query($GLOBALS['connection'], $get_email_sql);
		$email_row = mysqli_fetch_assoc($email_sql_result);
		echo $email_row['email'];
		}else {
		echo "Email Session Error!";
		}
}

function get_admin_email(){
	if(isset($_SESSION['adminId'])){
	$userId = $_SESSION['adminId'];
	$get_email_sql = "SELECT email FROM adminUser WHERE userId='$userId'";
	$email_sql_result = mysqli_query($GLOBALS['connection'], $get_email_sql);
	$email_row = mysqli_fetch_assoc($email_sql_result);
	echo $email_row['email'];
	}else {
	echo "Email Session Error!";
	}
}

function get_Fname(){
		if(isset($_SESSION['userId'])){
		$userId = $_SESSION['userId'];
		$get_Fname_sql = "SELECT Fname FROM accountUser WHERE userId='$userId'";
		$Fname_sql_result = mysqli_query($GLOBALS['connection'], $get_Fname_sql);
		$Fname_row = mysqli_fetch_assoc($Fname_sql_result);
				if($Fname_row['Fname'] != ""){
						echo $Fname_row['Fname'];
				} else{
						echo "N/A";
				}
		}else {
		echo "Fname Session Error!";
		}
}
function get_admin_Fname(){
	if(isset($_SESSION['adminId'])){
	$userId = $_SESSION['adminId'];
	$get_Fname_sql = "SELECT Fname FROM adminUser WHERE userId='$userId'";
	$Fname_sql_result = mysqli_query($GLOBALS['connection'], $get_Fname_sql);
	$Fname_row = mysqli_fetch_assoc($Fname_sql_result);
			if($Fname_row['Fname'] != ""){
					echo $Fname_row['Fname'];
			} else{
					echo "N/A";
			}
	}else {
	echo "Fname Session Error!";
	}
}

function get_Lname(){
		if(isset($_SESSION['userId'])){
		$userId = $_SESSION['userId'];
		$get_Lname_sql = "SELECT Lname FROM accountUser WHERE userId='$userId'";
		$Lname_sql_result = mysqli_query($GLOBALS['connection'], $get_Lname_sql);
		$Lname_row = mysqli_fetch_assoc($Lname_sql_result);
				if($Lname_row['Lname'] != ""){
						echo $Lname_row['Lname'];
				} else{
						echo "N/A";
				}
		}else {
		echo "Lname Session Error!";
		}
}
function get_admin_Lname(){
	if(isset($_SESSION['adminId'])){
	$userId = $_SESSION['adminId'];
	$get_Lname_sql = "SELECT Lname FROM adminUser WHERE userId='$userId'";
	$Lname_sql_result = mysqli_query($GLOBALS['connection'], $get_Lname_sql);
	$Lname_row = mysqli_fetch_assoc($Lname_sql_result);
			if($Lname_row['Lname'] != ""){
					echo $Lname_row['Lname'];
			} else{
					echo "N/A";
			}
	}else {
	echo "Lname Session Error!";
	}
}

function update_Fname(){
		if(isset($_POST['updateFname']) && isset($_SESSION['userId'])){
	$profilePage = "profile.php";
	$newFname = $_POST['newFname'];
	$userId = $_SESSION['userId'];
	$update_Fname_sql = "UPDATE accountUser SET Fname = '$newFname' WHERE userId ='$userId' ";
	$update_Fname_sql_result = mysqli_query($GLOBALS['connection'], $update_Fname_sql); 
	echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
		}
}
function update_admin_Fname(){
	if(isset($_POST['updateFname']) && isset($_SESSION['adminId'])){
		$profilePage = "admin_profile.php";
		$newFname = $_POST['newFname'];
		$userId = $_SESSION['adminId'];
		$update_Fname_sql = "UPDATE adminUser SET Fname = '$newFname' WHERE userId ='$userId' ";
		$update_Fname_sql_result = mysqli_query($GLOBALS['connection'], $update_Fname_sql); 
		echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
	}
}

function update_Lname(){
		if(isset($_POST['updateLname']) && isset($_SESSION['userId'])){
			$newLname = $_POST['newLname'];
			$profilePage = "profile.php";
			$userId = $_SESSION['userId'];
			$update_Lname_sql = "UPDATE accountUser SET Lname = '$newLname' WHERE userId ='$userId' ";
			$update_Lname_sql_result = mysqli_query($GLOBALS['connection'], $update_Lname_sql); 
			echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
		}
}
function update_admin_Lname(){
	if(isset($_POST['updateLname']) && isset($_SESSION['adminId'])){
		$newLname = $_POST['newLname'];
		$profilePage = "admin_profile.php";
		$userId = $_SESSION['adminId'];
		$update_Lname_sql = "UPDATE adminUser SET Lname = '$newLname' WHERE userId ='$userId' ";
		$update_Lname_sql_result = mysqli_query($GLOBALS['connection'], $update_Lname_sql); 
		echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
	}
}

function update_Username(){
		if(isset($_POST['newUsername']) && isset($_SESSION['userId'])){
			$newUname = $_POST['newUsername'];
			$profilePage = "profile.php";
			$userId = $_SESSION['userId'];
			$update_Uname_sql = "UPDATE accountUser SET userName = '$newUname' WHERE userId ='$userId' ";
			$update_Uname_sql_result = mysqli_query($GLOBALS['connection'], $update_Uname_sql); 
			echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
		}
}

function update_Admin_Username(){
	if(isset($_POST['update_admin_Username']) && isset($_SESSION['adminId'])){
		$newUname = $_POST['newUsername'];
		$adminprofilePage = "admin_profile.php";
		$userId = $_SESSION['adminId'];
		$update_Uname_sql = "UPDATE adminUser SET userName = '$newUname' WHERE userId ='$userId' ";
		$update_Uname_sql_result = mysqli_query($GLOBALS['connection'], $update_Uname_sql); 
		echo "<meta http-equiv='refresh' content='0; url=$adminprofilePage'>";
	}
}

function update_email(){
		if(isset($_POST['newEmail']) && isset($_SESSION['userId'])){
	$newEmail = $_POST['newEmail'];
	$profilePage = "profile.php";
	$emailsqli = "SELECT * FROM accountUser WHERE email='$newEmail'";
	$email_result = mysqli_query($GLOBALS['connection'], $emailsqli);
	$admin_emailsqli = "SELECT * FROM adminUser WHERE email='$newEmail'";
	$admin_email_result = mysqli_query($GLOBALS['connection'], $admin_emailsqli);
	if(mysqli_num_rows($email_result) == 0 && mysqli_num_rows($admin_email_result) == 0){
		$userId = $_SESSION['userId'];
		$update_email_sql = "UPDATE accountUser SET email = '$newEmail' WHERE userId ='$userId' ";
		$update_email_sql_result = mysqli_query($GLOBALS['connection'], $update_email_sql); 
		echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
	}else{
		echo "<script>alert('Email Already Exist! Use a Different Email!')</script>";
	}
		}
}
function update_admin_email(){
	if(isset($_POST['newEmail']) && isset($_SESSION['adminId'])){
		$newEmail = $_POST['newEmail'];
		$profilePage = "admin_profile.php";
		$emailsqli = "SELECT * FROM accountUser WHERE email='$newEmail'";
	$email_result = mysqli_query($GLOBALS['connection'], $emailsqli);
	$admin_emailsqli = "SELECT * FROM adminUser WHERE email='$newEmail'";
	$admin_email_result = mysqli_query($GLOBALS['connection'], $admin_emailsqli);
	if(mysqli_num_rows($email_result) == 0 && mysqli_num_rows($admin_email_result) == 0){
		$userId = $_SESSION['adminId'];
		$update_email_sql = "UPDATE adminUser SET email = '$newEmail' WHERE userId ='$userId' ";
		$update_email_sql_result = mysqli_query($GLOBALS['connection'], $update_email_sql); 
		echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
	}else{
		echo "<script>alert('Email Already Exist! Use a Different Email!')</script>";
		}
	}
}

function resetPwProfilePage(){

		if(isset($_SESSION['userId'])){
	$Currentpassword = $_POST['Currentpassword'];
	$Newpassword = $_POST['Newpassword'];
	$RepeatNewpassword = $_POST['RepeatNewpassword'];
	$hashed_password = password_hash($Newpassword, PASSWORD_ARGON2I);
	$userId = $_SESSION['userId'];
	$getPWsql = "SELECT password FROM accountUser WHERE userId='$userId'";
	$getPWsql_result = mysqli_query($GLOBALS['connection'], $getPWsql);
	$oldPW_row = mysqli_fetch_assoc($getPWsql_result);
	$verified = password_verify($Currentpassword, $oldPW_row['password']);
	if($verified){
		$resetPw_sql = "UPDATE accountUser SET password = '$hashed_password' WHERE userId='$userId' ";
		$resetResult = mysqli_query($GLOBALS['connection'], $resetPw_sql);
		//echo "Successfully Reset Your Password!<br>";
		echo "<script>alert('Successfully Reset Your Password!')</script>";
	}else{
		//echo "Invalid Current Password!<br>";
		echo "<script>alert('Invalid Current Password! Try Again!')</script>";
	}
		}else{
				//echo "Reset Password Session Error!<br>";
				echo "<script>alert('Reset Password Session Error!')</script>";
		}
}

function reset_admin_PwProfilePage(){

	if(isset($_SESSION['adminId'])){
		$Currentpassword = $_POST['Currentpassword'];
		$Newpassword = $_POST['Newpassword'];
		$RepeatNewpassword = $_POST['RepeatNewpassword'];
		$hashed_password = password_hash($Newpassword, PASSWORD_ARGON2I);
		$userId = $_SESSION['adminId'];
		$getPWsql = "SELECT password FROM adminUser WHERE userId='$userId'";
		$getPWsql_result = mysqli_query($GLOBALS['connection'], $getPWsql);
		$oldPW_row = mysqli_fetch_assoc($getPWsql_result);
		$verified = password_verify($Currentpassword, $oldPW_row['password']);
		if($verified){
		$resetPw_sql = "UPDATE adminUser SET password = '$hashed_password' WHERE userId='$userId' ";
		$resetResult = mysqli_query($GLOBALS['connection'], $resetPw_sql);
		//echo "Successfully Reset Your Password!<br>";
		echo "<script>alert('Successfully Reset Your Password!')</script>";
}else{
	//echo "Invalid Current Password!<br>";
	echo "<script>alert('Invalid Current Password! Try Again!')</script>";
}
	}else{
			//echo "Reset Password Session Error!<br>";
			echo "<script>alert('Reset Password Session Error!')</script>";
	}
}

function sch_crs_request_submit(){
	if(isset($_SESSION['userId'])){

		//$_SESSION['alertMessage'] = "111";
		$requestTypeSlection = $_POST['requestTypeSlection'];
		$sName = $_POST['sName'];
		$acronym = $_POST['acronym'];
		$cName = $_POST['cName'];
		$section = $_POST['section'];
		$userId = $_SESSION['userId'];
		
		//check sName and acro in db? no
		// echo "<script>alert('$requestTypeSlection!')</script>";
		if($requestTypeSlection == "SCHOOL" ){
			$cName = $section = null;
			//check if the sName and acronym is in request db
			$check_sName_sql = "SELECT * FROM request WHERE sName='$sName' AND acronym = '$acronym' ";
			$check_sName_sql_result = mysqli_query($GLOBALS['connection'], $check_sName_sql);
			//check if the sName and acronym is in school db
			$check_sName_existInS_sql = "SELECT * FROM school WHERE schoolName ='$sName' AND acronym = '$acronym' ";
			$check_sName_existInS_sql_result = mysqli_query($GLOBALS['connection'], $check_sName_existInS_sql);
			if(mysqli_num_rows($check_sName_sql_result) > 0 || mysqli_num_rows($check_sName_existInS_sql_result) > 0){
				echo "<meta http-equiv='refresh' content='0; url=home.php'>";
				//echo "<script>alert('School or Request Already Exist in Database!')</script>";
				$_SESSION['alertMessage'] = "School or Request Already Exist in Database!";
			} else{
				$Sch_req_sql = "INSERT INTO request(accountUserId, sName, acronym,requestType) Values ('$userId','$sName','$acronym','$requestTypeSlection')";
				$Sch_req_sql_result = mysqli_query($GLOBALS['connection'], $Sch_req_sql);
				echo "<meta http-equiv='refresh' content='0; url=home.php'>";
				//echo "<script>alert('School Request Sent!')</script>";
				$_SESSION['alertMessage'] = "School Request Sent!";
			}
		}else{
			//check if the sName and acronym is in course db
			$get_sch_id = "SELECT schoolId FROM school WHERE schoolName='$sName' AND acronym = '$acronym' ";
			$get_sch_id_result = mysqli_query($GLOBALS['connection'], $get_sch_id);
			$get_sch_id_result_row = mysqli_fetch_assoc($get_sch_id_result);
				//echo "111".$get_sch_id_result_row['schoolId'];
			$schoolId_got = $get_sch_id_result_row['schoolId'];
			$check_cName_existInC_sql = "SELECT * FROM course WHERE schoolId = '$schoolId_got' AND courseName = '$cName' AND section = '$section' ";
			$check_cName_existInC_sql_result = mysqli_query($GLOBALS['connection'], $check_cName_existInC_sql);
			//in request db
			$check_cName_sql = "SELECT * FROM request WHERE sName='$sName' AND acronym = '$acronym' AND cName='$cName' AND section = '$section' ";
			$check_cName_sql_result = mysqli_query($GLOBALS['connection'], $check_cName_sql);
			if(mysqli_num_rows($check_cName_sql_result) > 0 || mysqli_num_rows($check_cName_existInC_sql_result) > 0 ){
				echo "<meta http-equiv='refresh' content='0; url=home.php'>";
				//echo "<script>alert('Course or Request Already Exist in Database!')</script>";
				$_SESSION['alertMessage'] = "Course or Request Already Exist in Database!";
			}else{
				$Crs_req_sql = "INSERT INTO request(accountUserId, sName, acronym,cName, section, requestType) Values ('$userId','$sName','$acronym','$cName','$section','$requestTypeSlection')";
				$Crs_req_sql_result = mysqli_query($GLOBALS['connection'], $Crs_req_sql);
				echo "<meta http-equiv='refresh' content='0; url=home.php'>";
				//echo "<script>alert('Course Request Sent!')</script>";
				$_SESSION['alertMessage'] = "Course Request Sent!";

			}
		}
	}
}

function search(){
	//set search keyword  
	if (isset($_POST['searchPage_search_Btn'])|| isset($_POST['display_all_SR'])||isset($_POST['display_notes_SR'])||isset($_POST['display_courses_SR'])) {
		$Actual_search_input = $_POST['searchPage_search_input'];
	}else	if(isset($_POST['search_keyword'])){
		$Actual_search_input = $_POST['search_keyword'];
	}else{
		echo '<tr><td> Search for Notes?</td></tr>';
		echo '<tr><td> Please Enter a Keyword! </td></tr>';
	}
	
	// set search for all results
	if(isset($_POST['search_keyword']) || isset($_POST['searchPage_search_Btn'])|| isset($_POST['display_all_SR'])){
			$note_query = "SELECT * FROM note WHERE noteName LIKE '%$Actual_search_input%' ";
			$course_query = "SELECT * FROM course WHERE courseName LIKE '%$Actual_search_input%' OR section LIKE '%$Actual_search_input%'"; 
			$note_query_result = mysqli_query($GLOBALS['connection'], $note_query);
			$course_query_result = mysqli_query($GLOBALS['connection'], $course_query);
			echo'<script>
				document.getElementById("display_all_SR").style.backgroundColor = "goldenrod";
				document.getElementById("display_all_SR").style.color = "grey";
			</script>';
			$N_rowcount = mysqli_num_rows($note_query_result);
			$C_rowcount = mysqli_num_rows($course_query_result);
		if ($N_rowcount == 0 && $C_rowcount == 0) {
			echo '<tr><td> Sorry, No result Found, Please Try Another Keyword </td></tr>';
		} else{
				for ($x = 1; $x <= $N_rowcount; $x++) {
					$note_row = mysqli_fetch_assoc($note_query_result);
					echo '<tr><td> ';
					echo '<form id="noteForm' . $note_row['noteId'] . '" action="./viewNotes.php" method="post">';
					echo '
							<input type="hidden" value="' . $note_row['courseId'] . '" name="courseId">
							<input type="hidden" value="' . $note_row['noteId'] . '" name="noteId">
							<span href="javascript:{}" onclick="document.getElementById(\'noteForm' . $note_row['noteId'] . '\').submit();"  class="searchList" id="courseListTxt">' . $note_row['noteName'] . '</span>';			
					echo '</form></td></tr>';
				} 
				for ($y = 1; $y <= $C_rowcount; $y++) {
					$course_row = mysqli_fetch_assoc($course_query_result);
					echo '<tr><td> ';
					echo '<form id="courseForm' . $course_row['courseId'] . '" action="./viewNotes.php" method="post">';
					echo '
							<input type="hidden" value="' . $course_row['courseId'] . '" name="courseId">
							<span href="javascript:{}" onclick="document.getElementById(\'courseForm' . $course_row['courseId'] . '\').submit();"  class="searchList" id="courseListTxt">' . $course_row['section'] . ': ' . $course_row['courseName'] . '</span>';			
					echo '</form></td></tr>';
				} 
			}	
		}

	//search for notename only
	if (isset($_POST['display_notes_SR'])) {
		echo'<script>
		document.getElementById("display_notes_SR").style.backgroundColor = "goldenrod";
		document.getElementById("display_notes_SR").style.color = "grey";
		</script>';
		$query = "SELECT * FROM note WHERE noteName LIKE '%$Actual_search_input%'"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
		if (mysqli_num_rows($result) == 0) {
			echo '<tr><td> Sorry, No result Found, Please Try Another Keyword </td></tr>';
		}else if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
				echo '<tr><td> ';
				echo '<form id="noteForm' . $row['noteId'] . '" action="./viewNotes.php" method="post">';
				echo '
				<span href="javascript:{}" onclick="document.getElementById(\'noteForm' . $row['noteId'] . '\').submit();"  id="courseListTxt">' . $row['noteName'] . '</span>';			
				echo '</form></td></tr>';
			}	
		}
	}

	// search for coursename
	if (isset($_POST['display_courses_SR'])) {
		echo'<script>
		document.getElementById("display_courses_SR").style.backgroundColor = "goldenrod";
		document.getElementById("display_courses_SR").style.color = "grey";
		</script>';
		$query = "SELECT * FROM course WHERE courseName LIKE '%$Actual_search_input%'"; 
		$result = mysqli_query($GLOBALS['connection'], $query);
		if (mysqli_num_rows($result) == 0) {
			echo '<tr><td> Sorry, No result Found, Please Try Another Keyword </td></tr>';
		}else if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
				// echo '<tr><td> '. $row['courseName'] .'</td></tr>';
				echo '<tr><td> ';
				echo '<form id="courseForm' . $row['courseId'] . '" action="./viewNotes.php" method="post">';
				echo '
				<span href="javascript:{}" onclick="document.getElementById(\'courseForm' . $row['courseId'] . '\').submit();"  id="courseListTxt">' . $row['courseName'] . '</span>';			
				echo '</form></td></tr>';
			}	
		}
	}
}

	function listT_admin(){
		$T_query = "SELECT * FROM ticket WHERE isDeleted = 0 AND repliedTo = 0 "; 
		$T_query_result = mysqli_query($GLOBALS['connection'], $T_query);
		if (mysqli_num_rows($T_query_result) == 0) {
			echo '<tr><td> No Ticket </td></tr>';
		}else{
				while($T_query_result_row = mysqli_fetch_assoc($T_query_result)){
					$accountUserId = $T_query_result_row['accountUserId'];
					$query = "SELECT * FROM accountUser WHERE userId='$accountUserId' AND isDeleted=0";
					$result = mysqli_query($GLOBALS['connection'], $query);
					$row = mysqli_fetch_array($result);
					$email = $row['email'];
				echo '<tr><td> ';
				echo $T_query_result_row['ticketType'].' Ticket: '.$T_query_result_row['ticketTopic'].' '.$SCR_query_result_row['cName'];
				echo str_repeat("&nbsp;", 60).'  Sent From: '.$email.'<br>';
				echo 'Content: '.$T_query_result_row['ticketContent'];
				echo '</td></tr>';
				}
			}	
	}

	function ListSCR_admin(){
		$SCR_query = "SELECT * FROM request WHERE isDeleted = 0 "; 
		$SCR_query_result = mysqli_query($GLOBALS['connection'], $SCR_query);
		if (mysqli_num_rows($SCR_query_result) == 0) {
			echo '<tr><td> No School/Course Request </td></tr>';
		}else{
				while($SCR_query_result_row = mysqli_fetch_assoc($SCR_query_result)){
				echo '<tr><td> ';
				echo $SCR_query_result_row['requestType'].' Request: '.$SCR_query_result_row['acronym'].' '.$SCR_query_result_row['cName'].' '.$SCR_query_result_row['section'] ;
				echo '</td></tr>';
				}
			}	
	}
?>
