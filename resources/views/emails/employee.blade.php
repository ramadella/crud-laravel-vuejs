{{-- employee.blade.php --}}
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>employee data</h2>
    <ul>
        @foreach($data as $item)
            <li>
                <ul>
                    @foreach($item as $key => $value)
                        <li><b>{{ $key }}:</b> {{ $value }}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
</body>

</html>