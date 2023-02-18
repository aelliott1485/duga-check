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
    <title>Duga Tasks</title>
    <link rel="stylesheet" type="text/css" href="//unpkg.com/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//unpkg.com/bootstrap-vue@2.23.0/dist/bootstrap-vue.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="//unpkg.com/bootstrap-vue@2.23.0/dist/bootstrap-vue.js"></script>
    <script type="text/javascript" src="//unpkg.com/bootstrap-vue@2.23.0/dist/bootstrap-vue-icons.js"></script>
    <style>
        body {
            background-image: url("https://cdn.sstatic.net/Sites/codereview/img/background-image.png?v=f93b5df604a8");
        }
    </style>
</head>
<body>
<div id="msg"></div>
<script type="text/x-template" id="task-card-template">
    <b-card
        border-variant="primary"
        :header="task.name"
        header-bg-variant="primary"
        header-text-variant="white"
        align="center"
        class="m-1"
    >
        task card
        <b-card-text>
            Last Ran: {{ formatDate(task.last) }}
        </b-card-text>
        <b-card-text>
            Next Run: {{ formatDate(task.next) }}
        </b-card-text>
    </b-card>
</script>
<div id="app">
    <h2 class="m-2">Tasks</h2>
    <b-card-group deck class="m-1">
        <task-card
            v-for="task in firstTasks"
            :task="task"
        >
        </task-card>
    </b-card-group>

    <b-card-group deck class="m-1">
        <task-card
            v-for="task in laterTasks"
            :task="task"
        >
        </task-card>
    </b-card-group>
</div>
<script type="text/javascript">
    const URL = 'https://duga.zomis.net/tasks';
    const messageConstainer = document.getElementById('msg');

    Vue.component('task-card', {
        template: '#task-card-template',
        props: {
            task: {
                type: Object
            }
        },
        methods: {
            formatDate: function(timestamp) {
                console.log(`timestamp: ${timestamp}`);
                const date = new Date(0);
                date.setUTCSeconds(timestamp);
                return date.toLocaleString(); //date.toISOString('en-GB');
            }
        }
    });
    new Vue({
        el: '#app',
        data: {
            tasks: <?= $tasksJSON ?>,
            loading: false
        },
        computed: {
            firstTasks: function () {
                return Object.values(this.tasks).slice(0, 2);
            },
            laterTasks: function() {
                return Object.values(this.tasks).slice(2);
            }
        }
    });
</script>
</body>
</html>
