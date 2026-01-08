<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KAU Faculty Websites</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f5f7fa;
            color: #2c3e50;
            line-height: 1.7;
        }

        .container {
            max-width: 1000px;
            margin: 60px auto;
            background: #ffffff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            font-size: 36px;
            color: #0b5ed7;
            margin-bottom: 20px;
            border-bottom: 3px solid #e9ecef;
            padding-bottom: 10px;
        }

        p, label {
            font-size: 16px;
            color: #495057;
        }

        .highlight {
            background-color: #f1f5ff;
            padding: 20px;
            border-left: 5px solid #0b5ed7;
            margin: 30px 0;
            border-radius: 6px;
        }

        form select {
            padding: 5px 10px;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .faculty-list {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .faculty-card {
            background: #f8f9fc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e6e9f0;
            transition: transform 0.2s;
        }

        .faculty-card:hover {
            transform: translateY(-3px);
        }

        .faculty-card a {
            text-decoration: none;
            color: #0b5ed7;
            font-weight: bold;
            font-size: 18px;
        }

        .faculty-card span {
            display: block;
            margin-top: 5px;
            color: #6c757d;
            font-size: 14px;
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

    <h1>Faculty Websites</h1>

    <div class="highlight">
        <p>
            Select a faculty below to view more details. This page is served by
            the <strong>FACULTY backend</strong> and demonstrates database-driven
            content dynamically.
        </p>
    </div>

    <form method="GET">
        <label>Select Language:</label>
        <select name="lang" onchange="this.form.submit()">
            <option value="en" {{ $language === 'en' ? 'selected' : '' }}>English</option>
            <!-- Add more languages as needed -->
        </select>
    </form>

    <div class="faculty-list">
        @foreach ($faculties as $faculty)
            <div class="faculty-card">
                <a href="{{ route('faculty.profile', [$faculty->language, $faculty->code]) }}">
                    {{ $faculty->name }}
                </a>
                <span>Language: {{ $faculty->language }}</span>
                <span>Code: {{ $faculty->code }}</span>
            </div>
        @endforeach
    </div>

    <footer>
        © {{ date('Y') }} King Abdulaziz University – Faculty Websites
    </footer>
</div>

</body>
</html>
