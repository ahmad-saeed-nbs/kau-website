<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>King Abdulaziz University – Main Website</title>

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

        h2 {
            font-size: 24px;
            margin-top: 40px;
            color: #1f3c88;
        }

        p {
            font-size: 16px;
            margin-top: 15px;
            color: #495057;
        }

        .highlight {
            background-color: #f1f5ff;
            padding: 20px;
            border-left: 5px solid #0b5ed7;
            margin: 30px 0;
            border-radius: 6px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .card {
            background: #f8f9fc;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e6e9f0;
        }

        .card h3 {
            margin-top: 0;
            color: #0b5ed7;
            font-size: 20px;
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

    <h1>King Abdulaziz University</h1>

    <p>
        Welcome to the main website of King Abdulaziz University. This platform
        serves as the central digital gateway for academic information,
        university services, announcements, and institutional resources.
    </p>

    <div class="highlight">
        <p>
            This page is served by the <strong>Main Website backend</strong>
            and demonstrates reliable, scalable delivery through our
            cloud-based infrastructure.
        </p>
    </div>

    <h2>Explore KAU</h2>

    <div class="cards">
        <div class="card">
            <h3>Academic Programs</h3>
            <p>
                Discover a wide range of undergraduate and postgraduate programs
                designed to meet global academic standards.
            </p>
        </div>

        <div class="card">
            <h3>Admissions</h3>
            <p>
                Learn about admission requirements, application timelines,
                and student enrollment processes.
            </p>
        </div>

        <div class="card">
            <h3>Research</h3>
            <p>
                Explore research initiatives, innovation centers, and
                international collaborations at KAU.
            </p>
        </div>

        <div class="card">
            <h3>Campus Life</h3>
            <p>
                Experience student activities, facilities, and services that
                support a vibrant academic community.
            </p>
        </div>
    </div>

    <footer>
        © {{ date('Y') }} King Abdulaziz University. Main Website.
    </footer>

</div>

</body>
</html>
