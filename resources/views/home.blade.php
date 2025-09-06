
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Sederhana</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            line-height: 1.6;
        }

        main {
            flex: 1;
            padding: 4rem 2rem;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        p {
            color: #636e72;
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <main>
        <h1>Selamat Datang</h1>
        <p>Ini adalah halaman sederhana yang dibuat dengan Laravel</p>
    </main>

    <footer>
        &copy; 2025 Muhammad Luthfi Naldi
    </footer>
</body>
</html>