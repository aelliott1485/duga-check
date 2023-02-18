<?php
/**
 * This scans the list of tasks and checks to see when the last time the Comments scanning was run
 * If the time delta between the last run and the current time is more than 15 minutes then return a 500 response code
 *
 * This script is scanned via betteruptime.com
 */
const URL = 'https://duga.zomis.net/tasks';
function getTasks() {
    $sh = curl_init(URL);
    curl_setopt($sh, CURLOPT_RETURNTRANSFER, true);

    $tasksJSON = curl_exec($sh);
    if (curl_errno($sh)) {
        $error = curl_error($sh);
        throw new Exception('curl error: ' . $error);
    }
    return json_decode($tasksJSON);
}
try {
    $tasks = getTasks();
    $lastCommentsTimestamp = $tasks->{'Comments scanning'}->last;
    $lastComments = date('c', $lastCommentsTimestamp);
    $nextCommentsTimestamp = $tasks->{'Comments scanning'}->next;
    $nextComments = date('c', $nextCommentsTimestamp);
    $currentTimestamp = time();
    $current = date('c', $currentTimestamp);
    $difference = $currentTimestamp - $lastCommentsTimestamp;
    //print 'tasks: '.var_export($tasks, true);
    if ($difference > 900) {
        http_response_code(500);
    }

    print "<table><tr><td>lastComments</td><td>$lastComments</td></tr><tr><td>nextComments</td><td>$nextComments</td></tr><tr><td>current</td><td>$current</td></tr><tr><td>difference</td><td>$difference</td></tr></table>";

} catch (Exception $e) {
    echo 'exception: ' . $e->getMessage();
}
