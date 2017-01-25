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

            .ajax-container {
                position: absolute;
                background: #fff;
                border: 1px solid #ccc;
                min-width: 300px;
                display: none;
                max-height: 300px;
                overflow-y: auto;
                box-shadow: 0px 2px 12px 0px rgba(0,0,0, .4);
                z-index: 10;
                padding: 15px;
            }

            .ajax-container .result-info {
                padding: 0px 5px 10px;
                border-bottom: 1px solid #ccc;
            }

            .ajax-container .result-info ul {
                margin-bottom: 0px;
            }

            .movie, 
            .item {
                padding: 5px;
                border-bottom: 1px solid #ccc;
                cursor: pointer;
            }

            .movie:last-child, 
            .item:last-child {
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

            .pager a {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Movietheek</h1>
            <main class="content">
