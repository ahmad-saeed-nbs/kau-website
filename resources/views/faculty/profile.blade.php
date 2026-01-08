<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $faculty->name }} – Faculty Profile</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f5f7fa;
            color: #2c3e50;
            line-height: 1.7;
        }

        .container {
            max-width: 800px;
            margin: 60px auto;
            background: #ffffff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        h1 {
            font-size: 36px;
            color: #0b5ed7;
            margin-bottom: 20px;
            border-bottom: 3px solid #e9ecef;
            padding-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #495057;
            margin-top: 10px;
        }

        .highlight {
            background-color: #f1f5ff;
            padding: 20px;
            border-left: 5px solid #0b5ed7;
            margin: 30px 0;
            border-radius: 6px;
        }

        .buttons {
            margin-top: 30px;
        }

        .buttons a, .buttons button {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            background-color: #0b5ed7;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        .buttons a:hover, .buttons button:hover {
            background-color: #084298;
        }

        footer {
            margin-top: 60px;
            text-align: center;
            font-size: 14px;
            color: #868e96;
        }
    </style>
</head>
<body>

<div class="container">

    <h1>{{ $faculty->name }} – Profile</h1>

    <div class="highlight">
        <p>
            This page shows faculty details retrieved from database. Backend: <strong>FACULTY servers</strong>
        </p>
    </div>

    <p>Language: {{ $lang }}</p>
    <p>Faculty Code: {{ $faculty->code }}</p>
    <p>Backend: FACULTY servers</p>

    <div class="buttons">
        <a href="{{ route('faculty.index') }}">Back to Faculty List</a>
        <button onclick="alert('Future DB action')">View Courses</button>
    </div>

    <footer>
        © {{ date('Y') }} King Abdulaziz University – Faculty Profile
    </footer>

</div>

</body>
</html>
