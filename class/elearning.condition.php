<?php
SESSION_START();
error_reporting(0);
date_default_timezone_set('America/Chicago');
include_once '../class/elearning.class.php';

$user = $_SESSION['user'];
$type = $_SESSION['type'];

$el = new elearning();
$date = date("Y-m-d h:i A");
$activeSY = $el->getSchoolYear();


if ($_POST['action'] == "login") {
	$userid = htmlspecialchars($_POST["userid"]);
	$entered_password = htmlspecialchars($_POST["password"]);

	$el->getUserCredentials($userid, $entered_password);
	$el->setUserLog($userid, $date);
}

if ($_POST['action'] == "register-student") {
	$hashedPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
	$userid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$mobile = htmlspecialchars($_POST["mobile"]);
	$dob = htmlspecialchars($_POST["dob"]);
	$course = htmlspecialchars($_POST["course"]);
	$program = htmlspecialchars($_POST["program"]);
	$password = htmlspecialchars($_POST["password"]);
	$confirm_pass = htmlspecialchars($_POST["confirm-password"]);


	if ($el->isStudentId($userid)) {
		echo 'Student has already registered';
	} elseif ($confirm_pass !== $password) {
		echo 'Password not match!';
	} else {
		$el->setStudent($userid, $fname, $lname, $mobile, $dob, $course, $program, $hashedPassword, $date);
	}
}

if ($_POST['action'] == "register-instructor") {
	$hashedInstructorPassword = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
	$userid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$password = htmlspecialchars($_POST["password"]);
	$confirm_pass = htmlspecialchars($_POST["confirm-password"]);

	if ($el->isInstructorId($userid)) {
		echo 'Instructor has already registered';
	} elseif ($confirm_pass !== $password) {
		echo 'Password not match!';
	} else {
		$el->setInstructorInfo($userid, $fname, $lname, $hashedInstructorPassword, $date);
	}
}

if ($_POST['action'] == "createClass") {
	$sy = htmlspecialchars($_POST["selectSY"]);
	$subj = htmlspecialchars($_POST["selectCourse"]);
	$fac = htmlspecialchars($_POST["selectInstructor"]);
	$class = htmlspecialchars($_POST["className"]);
	$action = 'created class ' . $class;

	if ($el->isClassCode($class)) {
		echo 'Class has already created';
	} else {
		$el->setClass($class, $subj, $fac, $sy, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_GET['action'] == "addToClass") {
	$id = $_GET['id'];
	$sid = $_GET['sid'];
	$action = 'added student to class ' . $id;

	if ($el->isClassStudent($id, $sid)) {
		header('Location: students.php?id=' . $id);
	} else {
		$el->setStudentClass($id, $sid);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_GET['action'] == "deleteClass") {
	$id = $_GET['id'];
	$action = 'deleted class ' . $id;
	$el->deleteClass($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteStudent") {
	$id = $_GET['id'];
	$action = 'deleted student ' . $id;
	$el->deleteStudent($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteInstructor") {
	$id = $_GET['id'];
	$action = 'deleted instructor ' . $id;
	$el->deleteInstructor($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteCourse") {
	$id = $_GET['id'];
	$action = 'deleted course ' . $id;
	$el->deleteCourse($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteUser") {
	$id = $_GET['id'];
	$action = 'deleted user ' . $id;
	$el->deleteUser($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteClassStudent") {
	$action = 'deleted student in class ' . $_GET['id'] . ' ';
	$id = $_GET['id'];
	$sid = $_GET['sid'];
	$el->deleteClassStudent($id, $sid);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteSY") {
	$action = 'deleted school year ' . $_GET['id'] . ' ';
	$id = $_GET['id'];
	$el->deleteSY($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteAnnounce") {
	$action = 'deleted announcement ' . $_GET['id'] . ' ';
	$id = $_GET['id'];
	$el->deleteAnnounce($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteQuiz") {
	$action = 'deleted quiz ' . $_GET['id'] . ' ';
	$id = $_GET['id'];
	$el->deleteQuiz($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "deleteQuestion") {
	$action = 'deleted question ' . $_GET['id'] . ' ';
	$id = $_GET['qid'];
	$el->deleteQuestion($id);
	$el->setActivityLog($user, $action, $date);
}

if ($_GET['action'] == "activateSY") {
	$action = 'activate school year ' . $_GET['id'] . ' ';
	$id = $_GET['id'];


	$el->activateSY($id, $activeSY);
	$el->setActivityLog($user, $action, $date);

}

if ($_POST['action'] == "create-student") {
	$userid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$mobile = htmlspecialchars($_POST["mobile"]);
	$dob = htmlspecialchars($_POST["dob"]);
	$course = htmlspecialchars($_POST["course"]);
	$program = htmlspecialchars($_POST["program"]);
	$password = htmlspecialchars($_POST["password"]);
	$confirm_pass = htmlspecialchars($_POST["confirm-password"]);
	$action = "added new student " . $fname . ' ' . $lname;

	if ($el->isStudentId($userid)) {
		echo 'Student has already created';
	} elseif ($confirm_pass !== $password) {
		echo 'Password not match!';
	} else {
		$el->setStudent($userid, $fname, $lname, $mobile, $dob, $course, $program, $password, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "create-instructor") {
	$userid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$password = htmlspecialchars($_POST["password"]);
	$confirm_pass = htmlspecialchars($_POST["confirm-password"]);
	$action = "added new instructor " . $fname . " " . $lname;

	if ($el->isInstructorId($userid)) {
		echo 'Instructor has already created';
	} elseif ($confirm_pass !== $password) {
		echo 'Password not match!';
	} else {
		$el->setInstructorInfo($userid, $fname, $lname, $password, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "create-course") {
	$subcode = htmlspecialchars($_POST["subcode"]);
	$title = htmlspecialchars($_POST["title"]);
	$action = "created new course " . $title;

	if ($el->isCourseId($subcode)) {
		echo 'Course has already created';
	} else {
		$el->setCourse($subcode, $title, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "create-user") {
	$uid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$pass = htmlspecialchars($_POST["pass"]);
	$cpass = htmlspecialchars($_POST["cpass"]);
	$action = "created new admin " . $fname . ' ' . $lname;

	if ($el->isAdminId($uid)) {
		echo 'Admin user has already created';
	} elseif ($cpass !== $pass) {
		echo 'Password not match!';
	} else {
		$el->setUser($uid, $fname, $lname, $pass, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "create-sy") {
	$sy = htmlspecialchars($_POST["sy"]);
	$action = "created a new school year " . $sy;

	if ($el->isSYId($sy)) {
		echo 'School Year has already created';
	} else {
		$el->setSY($sy, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "create-announce") {
	$title = htmlspecialchars($_POST["title"]);
	$content = htmlspecialchars($_POST["content"]);
	$class = htmlspecialchars($_POST["classes"]);
	$action = "posted a new announcement " . $sy;
	$el->setAnnounce($title, $content, $user, $class, $date);
	$el->setActivityLog($user, $action, $date);
}

if ($_POST['action'] == "create-quiz") {
	$title = htmlspecialchars($_POST["title"]);
	$class = htmlspecialchars($_POST["classes"]);
	$action = "created a new quiz " . $sy;
	$el->setQuiz($title, $class, $user, $date);
	$el->setActivityLog($user, $action, $date);
}

if ($_POST['action'] == "create-question") {
	$question = htmlspecialchars($_POST["question"]);
	$ca = htmlspecialchars($_POST["ca"]);
	$cb = htmlspecialchars($_POST["cb"]);
	$cc = htmlspecialchars($_POST["cc"]);
	$cd = htmlspecialchars($_POST["cd"]);
	$answer = htmlspecialchars($_POST["answer"]);
	$quizid = htmlspecialchars($_POST["quizid"]);
	$action = "created a new question " . $sy;
	$el->setQuestion($question, $ca, $cb, $cc, $cd, $answer, $quizid, $date);
	$el->setActivityLog($user, $action, $date);
}

if ($_POST['action'] == "edit-student") {
	$userid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$mobile = htmlspecialchars($_POST["MOBILE"]);
	$dob = htmlspecialchars($_POST["DOB"]);
	$course = htmlspecialchars($_POST["course"]);
	$password = htmlspecialchars($_POST["password"]);
	$confirm_pass = htmlspecialchars($_POST["confirm-password"]);
	$action = "edited student " . $fname . ' ' . $lname;

	if ($confirm_pass !== $password) {
		echo 'Password not match!';
	} else {
		$el->editStudent($userid, $fname, $lname, $mobile, $dob, $course, $password, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "edit-instructor") {
	$userid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$password = htmlspecialchars($_POST["password"]);
	$confirm_pass = htmlspecialchars($_POST["confirm-password"]);
	$action = "edited instructor " . $fname . " " . $lname;

	if ($confirm_pass !== $password) {
		echo 'Password not match!';
	} else {
		$el->editInstructorInfo($userid, $fname, $lname, $password, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "edit-course") {
	$subcode = htmlspecialchars($_POST["subcode"]);
	$title = htmlspecialchars($_POST["title"]);
	$action = "edited course " . $title;


	$el->editCourse($subcode, $title, $date);
	$el->setActivityLog($user, $action, $date);
}

if ($_POST['action'] == "edit-user") {
	$uid = htmlspecialchars($_POST["userid"]);
	$fname = htmlspecialchars($_POST["fname"]);
	$lname = htmlspecialchars($_POST["lname"]);
	$pass = htmlspecialchars($_POST["pass"]);
	$cpass = htmlspecialchars($_POST["cpass"]);
	$action = "edited admin " . $fname . ' ' . $lname;

	if ($cpass !== $pass) {
		echo 'Password not match!';
	} else {
		$el->editUser($uid, $fname, $lname, $pass, $date);
		$el->setActivityLog($user, $action, $date);
	}
}

if ($_POST['action'] == "edit-announce") {
	$title = htmlspecialchars($_POST["title"]);
	$content = htmlspecialchars($_POST["content"]);
	$class = htmlspecialchars($_POST["class"]);
	$action = "edited a announcement " . $title;

	$el->editAnnounce($title, $content, $user, $class, $date);
	$el->setActivityLog($user, $action, $date);
}

if ($_POST['action'] == "edit-quiz") {
	$title = htmlspecialchars($_POST["title"]);
	$jid = htmlspecialchars($_POST["jid"]);
	$action = "edited a quiz " . $title;
	$el->editQuiz($jid, $title);
	$el->setActivityLog($user, $action, $date);
}

if ($_POST['action'] == "edit-question") {
	$id = htmlspecialchars($_POST["quizid"]);
	$question = htmlspecialchars($_POST["question"]);
	$ca = htmlspecialchars($_POST["ca"]);
	$cb = htmlspecialchars($_POST["cb"]);
	$cc = htmlspecialchars($_POST["cc"]);
	$cd = htmlspecialchars($_POST["cd"]);
	$answer = htmlspecialchars($_POST["answer"]);
	$action = "edited a question " . $question;
	$el->editQuestion($id, $question, $ca, $cb, $cc, $cd, $answer);
	$el->setActivityLog($user, $action, $date);
}


if ($_GET['action'] == "select-instructor") {
	$id = $_GET['id'];
	list($id, $fname, $lname, $password) = $el->getInstructorID($id);
}

if ($_GET['action'] == "select-student") {
	$id = $_GET['id'];
	list($id, $fname, $lname, $mobile, $dob, $course, $program, $password) = $el->getStudentID($id);
}

if ($_GET['action'] == "select-course") {
	$id = $_GET['id'];
	list($scode, $title) = $el->getCourseID($id);
}

if ($_GET['action'] == "select-user") {
	$id = $_GET['id'];
	list($id, $fname, $lname, $password) = $el->getUserID($id);
}

if ($_GET['action'] == "select-announce") {
	$id = $_GET['id'];
	list($title, $content) = $el->getAnnounceID($id);
}

if ($_GET['action'] == "select-quiz") {
	$id = $_GET['id'];
	list($title) = $el->getQuizID($id);
}

if ($_GET['action'] == "select-question") {
	$id = $_GET['id'];
	list($question, $ca, $cb, $cc, $cd, $answer) = $el->getQuestionID($id);
}

if ($_GET['action'] == "downloadAss") {
	$id = $_GET['id'];
	$el->downloadAss($id);
}

?>