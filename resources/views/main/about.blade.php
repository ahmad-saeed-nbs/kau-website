<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About King Abdulaziz University</title>

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

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .stat-box {
            background: #f8f9fc;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e6e9f0;
        }

        .stat-box h3 {
            font-size: 28px;
            color: #0b5ed7;
            margin-bottom: 5px;
        }

        .stat-box span {
            font-size: 14px;
            color: #6c757d;
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

    <h1>About King Abdulaziz University</h1>

    <p>
        King Abdulaziz University (KAU) is one of the leading public universities
        in the Kingdom of Saudi Arabia. Established in Jeddah, KAU has grown into
        a center of academic excellence, innovation, and research, serving students
        from across the Kingdom and around the world.
    </p>

    <div class="highlight">
        <p>
            KAU is committed to advancing knowledge, fostering creativity,
            and preparing future leaders who contribute meaningfully to
            society, industry, and global development.
        </p>
    </div>

    <h2>Academic Excellence</h2>

    <p>
        The university offers a wide range of undergraduate, postgraduate,
        and doctoral programs across disciplines such as engineering,
        medicine, science, humanities, business, and information technology.
        Its academic programs are continuously enhanced to meet international
        standards and evolving societal needs.
    </p>

    <h2>Research and Innovation</h2>

    <p>
        Research is a core pillar of King Abdulaziz University. Through
        specialized research centers, innovation labs, and global partnerships,
        KAU actively contributes to scientific discovery, technological advancement,
        and sustainable development initiatives.
    </p>

    <div class="stats">
        <div class="stat-box">
            <h3>197</h3>
            <span>Established Year</span>
        </div>

        <div class="stat-box">
            <h3>130,000+</h3>
            <span>Students</span>
        </div>

        <div class="stat-box">
            <h3>30+</h3>
            <span>Research Centers</span>
        </div>

        <div class="stat-box">
            <h3>Global</h3>
            <span>Academic Partnerships</span>
        </div>
    </div>

    <footer>
        © {{ date('Y') }} King Abdulaziz University. All rights reserved.
    </footer>

</div>

</body>
</html>
