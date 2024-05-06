<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$asunto}}</title>
    <style>
        /* Reset styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        /* Wrapper */
        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Header */
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h1 {
            color: #333;
        }
        /* Content */
        .email-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .email-content p {
            margin-bottom: 10px;
            color: #555;
        }
        /* Button */
        .email-button {
            text-align: center;
            margin-top: 20px;
        }
        .email-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>{{$asunto}}</h1>
        </div>
        <div class="email-content">
            <p>Hello {{ $nombre }},</p>
            <p>{{$contenido}}</p>
        
            <!-- <div class="email-button">
                <a href="{{ $ctaUrl }}">Call to Action</a>
            </div> -->
        </div>
    </div>
</body><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$asunto}}</title>
    <style>
        /* Reset styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        /* Wrapper */
        .email-wrapper {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Header */
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h1 {
            color: #333;
        }
        /* Content */
        .email-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .email-content p {
            margin-bottom: 10px;
            color: #555;
        }
        /* Logo */
        .email-logo {
            text-align: center;
            margin-top: 20px;
        }
        .email-logo img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h1>{{$asunto}}</h1>
        </div>
        <div class="email-content">
            <p>Hello {{ $nombre }},</p>
            <p>{{$contenido}}</p>
        </div>
        <!-- Logo -->
        <div class="email-logo">
            <img src="\public\images\logoLargo.png" alt="Your Logo">
        </div>
    </div>
</body>
</html>

</html>
