<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Project Report: {{ $project->name }}</h1>
    <p><strong>Description:</strong> {{ $project->description }}</p>
    <p><strong>Status:</strong> {{ $project->status }}</p>
    <p><strong>Created On:</strong> {{ $project->created_at }}</p>

    <h2>Tasks</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
