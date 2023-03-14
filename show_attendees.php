<?php
include_once 'cors.php';
include_once 'attendance_tracker.php';

$attendanceTracker = AttendanceTracker::getInstance();

if (isset($attendanceTracker)) {    

  // Get today's attendees
  $attendees = $attendanceTracker->getAttendees(date('Y-m-d') . 
               ' 00:00:00', date('Y-m-d') . ' 23:59:59');
  
  if ($count = $attendees->num_rows) {
    echo '<table><tr><th>Date in</th><th>Time in</th><th>Name</th><th>Notes</th></tr>';

    $attendeesTable = [];

    while ($attendee = $attendees->fetch_object()) {
      $attendeesTable[] = '<tr><td>' . substr($attendee->created, 0, 10) . 
         '</td><td>' . substr($attendee->created, 10, 6) . '</td><td>' . 
         $attendee->name . '</td><td>' . $attendee->notes . '</td></tr>';
    }

    // Print attendees in reverse order
    for ($i = count($attendeesTable) - 1; $i >= 0; $i--) {
      echo $attendeesTable[$i];
    }

    echo '</table><div><em>[ total: ' . $count . ' ]</em></div>';
  }
}
?>
