<?php
include_once 'attendance_tracker.php';

$attendanceTracker = AttendanceTracker::getInstance();

if (isset($attendanceTracker)) {
  echo $attendanceTracker->clearAttendanceHistory();
}
?>
