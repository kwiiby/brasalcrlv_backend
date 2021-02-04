<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <style>
        body {
            background: url("brasal.jpeg") no-repeat;
            background-size: cover;
            position: relative;
            padding: 0;
            margin: 0;
        }
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,.7);
        }
    </style>
    <body>
    </body>
</html>
