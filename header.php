<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style type="text/css">
            .padding {
                padding: 15px;
            }

            #ajax-container {
                position: absolute;
                background: #fff;
                border: 1px solid #ccc;
                min-width: 300px;
                display: none;
            }

            .movie {
                padding: 5px;
                border-bottom: 1px solid #ccc;
                cursor: pointer;
            }

            .movie:last-child {
                border-bottom: none;
            }

            table thead {
                cursor: pointer;
            }

            table .asc:after {
                content: '▲';
            }

            table .desc:after {
                content: '▼'
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Movietheek</h1>
            <main class="content">
