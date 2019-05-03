<?php

	include "testFunctions.php";
/* 
	
*/
	testCase1(); //TEST CASE 1: REGISTRATION AND LOGIN
	testCase2(); //TEST CASE 2: CREATE SCHOOLS AND COURSES
	testCase3(); //TEST CASE 3: DELETE SCHOOLS AND COURSES
	testCase4(); //TEST CASE 4: UPLOAD AND DELETE NOTES
	testCase5(); //TEST CASE 5: ADD AND REMOVE FAVORITE COURSES

	//TEST CASE 1: REGISTRATION AND LOGIN
	function testCase1(){
		echo "<br><h2>TEST CASE 1: REGISTRATION AND LOGIN</h2>";
		$newUsers = array();
		
		
		
		//Creates Array with All Created User Information
		for($i = 0; $i < 10; $i++){
			$userName = "test" . $i;
			$password = "password" . $i;
			$email = "test".$i ."@test.com";
			$Fname = null;
			$Lname = "deleteThis";
			
			$newUsers[$i] = array($userName, $password, $email, $Fname, $Lname); 
		}
		
		//Iterates through the user array, sets the post data for each and
		//registers the new users
		for($i = 0; $i < 10; $i++){
			$_POST['username'] = $newUsers[$i][0];
			$_POST['password'] = $newUsers[$i][1];
			$_POST['Repeatpassword'] = $newUsers[$i][1];
			$_POST['email'] = $newUsers[$i][2];
			$_POST['Fname'] = $newUsers[$i][3];
			$_POST['Lname'] = $newUsers[$i][4];
			registration();
		}
		
		echo "<br>";
			
		for($i = 0; $i < 10; $i++){
			$_POST['password'] = $newUsers[$i][1];
			$_POST['email'] = $newUsers[$i][2];

			loginValidation();
			session_unset(); 
			
		}
		
		//Deletes all test cases from accountUser table
		$query = "	DELETE FROM
						accountUser
					WHERE
						Lname='deleteThis'
				";
				
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}
	}

	//TEST CASE 2: CREATE SCHOOLS AND COURSES
	function testCase2(){
		
		echo "<br><h2>TEST CASE 2: CREATE SCHOOLS AND COURSES</h2>";
	
		//CREATES SCHOOLS DYNAMICALLY IN DATABASE
		for($i = 0; $i < 10; $i++){
			$schoolName = "testSchool" . $i;
			$acronym = "ts" . $i;
			$adminUserId = 2000000001;
			
			createSchool($schoolName, $acronym, $adminUserId); 
		}
		
		echo "<br>";

		
		$query = "	SELECT 
						MAX(schoolId) AS schoolId 
					FROM school";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		
		$schoolId = $row['schoolId'];
		$adminUserId = 2000000001;
		
		//CREATES COURSES DYNAMICALLY IN DATABASE
		for($i = 0; $i < 10; $i++){
			$courseName = "testCourse" . $i;
			$section = "tc" . $i;
			
			createCourse($courseName, $section, $adminUserId, $schoolId);
 
		}
		
		echo "<br>";	
	
	}
	
	//TEST CASE 3: DELETE SCHOOLS AND COURSES
	function testCase3(){
		
		echo "<br><h2>TEST CASE 3: DELETE SCHOOLS AND COURSES</h2>";
		
		//Deletes all test cases from courses table
		$query = "	DELETE FROM
						course
					WHERE
						adminUserId = 2000000001
				";
				
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}else{
			echo "All Test Courses Deleted Successfully<br>";
		}			
		
		//Deletes all test cases from school table
		$query = "	DELETE FROM
						school
					WHERE
						adminUserId = 2000000001
				";
				
		if(!mysqli_query($GLOBALS['connection'], $query)){
			die(mysqli_error($GLOBALS['connection']));
		}else{
			echo "All Test Schools Deleted Successfully<br>";
		}
	}
	
	//TEST CASE 4: UPLOAD AND DELETE NOTES
	function testCase4(){

		echo "<br><h2>TEST CASE 4: UPLOAD AND DELETE NOTES</h2>";

		$_SESSION['userId'] = 1000000004;
		
		echo "	<form action='testFunctions.php' method='post' enctype='multipart/form-data'>
					<input type='hidden' name='courseId' value='4000000000'>
					<input type='hidden' name='noteId' value='5000000000'>
					<input  id='file'  name='file' type='file'>
					<input type='submit' name='uploadFile' value='Upload'>
				</form>
			";
		
		$query = "	SELECT
						MAX(noteId) AS noteId
					FROM
						note
				";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
			
		deleteFile($row['noteId']);
		
	}	
	
	//TEST CASE 5: ADD AND REMOVE FAVORITE COURSES
	function testCase5(){
		echo "<br><h2>TEST CASE 5: ADD AND REMOVE FAVORITE COURSES</h2>";
		
		$_SESSION['userId'] = 1000000004;
		$_POST['addC_Sch_selection'] = 3000000000;
		$_POST['addC_Course_selection'] = 4000000000;
		
 		addCourse();
		
		$query = "	SELECT
				MAX(favCourseId) AS favCourseId
			FROM
				userCourses
		";
		$result = mysqli_query($GLOBALS['connection'], $query);
		$row = mysqli_fetch_array($result);
		
		$_POST['favCourseId'] = $row['favCourseId'];
		removeCourse();
	}
	
?>