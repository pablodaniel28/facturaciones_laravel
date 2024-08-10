<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Mecanico - Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffff;
        }

        h3 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        table {
            width: 100%;
            margin: 20px auto;
            /* Añade margen superior e inferior para separación */
            border-collapse: collapse;
            background-color: #ffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #2f295f;
            color: #fff;
        }

        th,
        td {
            padding: 10px 15px;
            /* Ajusta el espaciado interno de celdas */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        p {
            padding: 30px 15px;
        }

        th {
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #fff;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            /* Asegura que la imagen no tenga márgenes */
            margin: 0 auto;
            /* Centra la imagen en la celda */
        }

        .descripcion {
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Centra el texto verticalmente en la celda */
        }

        .descripcion p {
            margin: 4px 0;
            /* Ajusta el espaciado entre líneas de texto */
        }

        .descripcion span {
            color: #555;
        }

        /* Estilo para los textos pequeños */
        .texto-pequeno {
            font-size: 12px;
            /* Ajusta el tamaño del texto según tus necesidades */
            color: #666;
        }
    </style>
</head>

<body>
    <div>
        <span>Taller Mecánico</span>
    </div>
    <span class="texto-pequeno">Av. Virgen de Luján - B. Carmen 2</span>

    <h3>Catálogo de Productos</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Producto</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($productos as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        <img src="{{ $base64EncodeImage('storage/multimedia/' . $p->img) }}" alt="Imagen del producto">
                    </td>
                    <td>
                        <p>{{ $p->nombre }} | <span>Precio:</span> {{ $p->precio }} Bs</p>
                    </td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        </tbody>
    </table>
</body>

</html>
