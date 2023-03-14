<?php
/**
 * A simple attendance tracker to collect and display a list of attendees
 */
final class AttendanceTracker {
  private static $db;
  private static $instance;


  /**
   * Sets and returns a single instance of an AttendanceTracker 
   *
   * @return an AttendanceTracker object
   */
  public static function getInstance() {
    if (!isset(self::$instance)) {
      include_once '/students/ggorlen/secure/dbvars_ggorlen.php';
      self::$db = new mysqli($dbhost, $dbuser, $dbpass, $database);
      unset($dbhost, $dbuser, $dbpass, $database);

      if (self::$db) {
        self::$instance = new AttendanceTracker();
      }

      return self::$instance;
    }
  } // end getInstance

  /**
   * Adds a new attendee to the database
   *
   * @param $name the name of the attendee
   * @return true if successful, false otherwise
   * @throws 
   */
  public function addAttendee($name, $notes) {
    if (!isset($name)) {
      throw new InvalidArgumentException('$name must be provided');
    }

    $name = self::$db->real_escape_string($name);
    $notes = isset($notes) ? self::$db->real_escape_string($notes) : NULL;

    // Write and run the query
    $query = "INSERT INTO attendance (
                name,
                notes
              ) VALUES (?, ?);";
    $statement = self::$db->prepare($query);
    $statement->bind_param('ss', $name, $notes);

    if ($statement->execute()) {
      $statement->close();
      return true;
    }
    else {
      // todo: write to error log
      return false;
    }
  } // end addAttendee

  /**
   * Returns a list of attendees matching a datetime range
   *
   * @param begin the beginning datetime of the query
   * @param end the ending datetime of the query
   * @return the list as a mysqli object
   */
  public function getAttendees($begin, $end) {
    $begin = self::$db->real_escape_string($begin);
    $end = self::$db->real_escape_string($end);

    // Write and run the query
    $query = "SELECT *
              FROM attendance
              WHERE (created BETWEEN '$begin' AND '$end');";
    $result = self::$db->query($query);
    // todo: error logging
    return $result;
  } // end getAttendees 

  /**
   * Clears the attendance database of entries older than the parameter datetime. 
   * If no parameter is provided, the default is entries older than a day.
   *
   * @return true if the db was cleared, false otherwise
   */
  public function clearAttendanceHistory($datetime) {
    if (isset($datetime)) {
      $datetime = "'" . self::$db->real_escape_string($datetime) . "'";
    }
    else {
      $datetime = '(NOW() - INTERVAL 1 DAY)';
    }

    $query = "DELETE  
              FROM attendance
              WHERE created < $datetime;";
    $result = self::$db->query($query);
    // todo: error logging
    return $result;
  } // end clearAttendanceHistory


  // Disallowed--use getInstance to construct
  private function __construct() { }
} // end AttendanceTracker
?>
