<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Laporan')</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
        }

        .report-wrapper {
            border: 1px dotted black;
            padding: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px dotted #000;
            padding: 4px;
            text-align: left;
            word-wrap: break-word;
        }

        thead {
            background-color: #f5f5f5;
        }

        tfoot {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        h3,
        p {
            margin: 5px 0;
        }
    </style>

</head>

<body>

    @yield('content')

</body>

</html>
