<?php

include '../include/getTasks.php';

try {
    $tasks = json_decode(getTasks());
    $lastCommentsTimestamp = $tasks->{'Comments scanning'}->last;
    $lastComments = date('c', $lastCommentsTimestamp);
    $nextCommentsTimestamp = $tasks->{'Comments scanning'}->next;
    $nextComments = date('c', $nextCommentsTimestamp);
    $currentTimestamp = time();
    $current = date('c', $currentTimestamp);
    $difference = $currentTimestamp - $lastCommentsTimestamp;
    //print 'tasks: '.var_export($tasks, true);
    if ($difference > 1000) {
        http_response_code(500);
    }

    print "<table><tr><td>lastComments</td><td>$lastComments</td></tr><tr><td>nextComments</td><td>$nextComments</td></tr><tr><td>current</td><td>$current</td></tr><tr><td>difference</td><td>$difference</td></tr></table>";

} catch (Exception $e) {
    echo 'exception: ' . $e->getMessage();
}
