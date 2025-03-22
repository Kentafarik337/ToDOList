<?php
        require_once 'src/connect.php';
?>     
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
</head>
<style>
    th, td {
        padding: 10px;
    }

    th {
        background: #606060;
        color: #fff;
    }

    td {
        background: #b5b5b5;
    }
</style>
<body>
<h3>Add new Task</h3>
    <form id="AddNewTask">
        <p>ID</p>
        <input type="number" name="id" id="id">
        <p>Title</p>
        <input type="text" name="title" id="title">
        <p>Description</p>
        <textarea name="description" id="description"></textarea>
        <p>Status</p>
        <input type="number" name="status1" id="status"> <br> <br>
        <button type="submit" name="action" value="add">Add new task</button>
        <button type="submit" name="action" value="update">Update task</button>
        <button type="submit" name="action" value="find">Find task</button>
        <button type="submit" name="action" value="delete">Delete task</button>
        <button type="submit" name="action" value="findall">Find all</button>
    </form> 
    <br> <br>
    <div id='output'></div>
    <script>
    document.getElementById('AddNewTask').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = {
            id: document.getElementById('id').value,
            title: document.getElementById('title').value,
            description: document.getElementById('description').value,
            status: document.getElementById('status').value
        };
        formData.status = formData.status || 0;
        const action = event.submitter.value;
        switch (action) {
        case 'add':
            url = '/src/POST.php';
            method = 'POST';
            break;
        case 'update':
            url = '/src/PUT.php';
            method = 'PUT';
            break;
        case 'find':
            url = '/src/GETID.php';
            method = 'POST';
            break;
        case 'delete':
            url = '/src/DELETE.php';
            method = 'DELETE';
            break;
        case 'findall':
            url = '/src/GET.php';
            method = 'GET';
            break;
        default:
            alert('Invalid action');
            return;
        }
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: method !== 'GET' ? JSON.stringify(formData) : null
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
            } else {
                console.log('Success:', data);
                if (action === 'findall') {
                    displayAllTasks(data);
                } else if (action === 'find') {
                    displayTask(data);
                }
            }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
        function displayAllTasks(tasks) {
        const output = document.getElementById('output');
        output.innerHTML = '<h2>All Tasks</h2>';
        tasks.forEach(task => {
            output.innerHTML += `<p>ID: ${task.id}, Title: ${task.title}, Description: ${task.description}, Status: ${task.status}</p>`;
        });
    }
    function displayTask(task) {
        const output = document.getElementById('output');
        output.innerHTML = `<h2>Task Details</h2>
                            <p>ID: ${task.id}</p>
                            <p>Title: ${task.title}</p>
                            <p>Description: ${task.description}</p>
                            <p>Status: ${task.status}</p>`;
    }
    </script>
</body>
</html>