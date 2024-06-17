<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Book PDF</title>
    <style>
        @font-face {
            font-family: 'Times New Roman';
            src: url('{{ public_path('fonts/times-new-roman.ttf') }}') format('truetype');
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: 'Times New Roman', serif;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 24px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .section p {
            font-size: 16px;
            margin: 0;
            padding: 0;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
    </div>

    <div class="section">
        <h2>Abstract</h2>
        {!!$abstract!!}
    </div>

    <div class="section">
        <h2>Fill</h2>
        {!!$fill!!}
    </div>
</body>
</html>
