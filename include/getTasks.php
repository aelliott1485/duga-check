<?php

const URL = 'https://duga.zomis.net/tasks';

function getTasks() {
    $sh = curl_init(URL);
    curl_setopt($sh, CURLOPT_RETURNTRANSFER, true);

    $tasksJSON = curl_exec($sh);
    if (curl_errno($sh)) {
        $error = curl_error($sh);
        throw new Exception('curl error: ' . $error);
    }
    return $tasksJSON;
}