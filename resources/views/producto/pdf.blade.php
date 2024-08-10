<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>
                    <img src="{{ $base64EncodeImage('storage/multimedia/' . $p->img) }}" alt="Imagen del producto">
                </td>
                <td>{{ $p->codigo }}</td>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->precio }}</td>
                <td>{{ $p->cantidad }}</td>
                <td>{{ $p->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
