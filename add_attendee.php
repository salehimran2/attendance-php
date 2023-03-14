<?php
include_once 'cors.php';
include_once 'attendance_tracker.php';

$attendanceTracker = AttendanceTracker::getInstance();

if (isset($attendanceTracker) && 
    isset($_POST) && isset($_POST['name']) && 
    preg_match('/[A-Za-z]+/', $_POST['name'])) {
  
  $notes = isset($_POST['notes']) ? trim($_POST['notes']) : NULL;
  echo $attendanceTracker->addAttendee(trim($_POST['name']), $notes);
}
?>
