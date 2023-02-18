<?php

include '../include/getTasks.php';

try {
    $tasksJSON = getTasks();

} catch (Exception $e) {
    echo 'exception: ' . $e->getMessage();
    $tasksJSON = '{}';
}
?>



<html>
<head>
    <!--<script type="text/javascript" src="//vuejs.org/js/vue.js"></script>-->
    <script type="text/javascript" src="//unpkg.com/vue"></script>
</head>
<body>
<div id="msg"></div>
<div id="app">
    <h2>Tasks</h2>
    <ul>
        <li v-for="task in tasks">
            {{ task.name }}
        </li>
    </ul>
</div>
<script type="text/javascript">
    const URL = 'https://duga.zomis.net/tasks';
    const messageConstainer = document.getElementById('msg');

    new Vue({
        el: '#app',
        data: {
            tasks: {},
            loading: false
        }
    });
    async function loadData() {
        try {
            // const response = await fetch(URL);
            const data = <?= $tasksJSON ?>;

            const lastCommentsScan = data['Comments scanning'].last;
            const lastCommentsScanDate = new Date(data['Comments scanning'].last);
            messageConstainer.innerHTML = `last scan: ${lastCommentsScan} date: ${lastCommentsScanDate.toISOString('en-GB')}`;

        } catch (e) {
            messageConstainer.innerHTML = `error: ${e.message}`;
        }
    }

    loadData();
</script>
</body>
</html>
