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

        .catalog {
            display: flex;
            flex-direction: column;
        }

        .product {
            display: grid;
            grid-template-columns: 100px 1fr; /* Two columns: first for the image, second for the details */
            gap: 20px; /* Space between columns */
            align-items: center; /* Align items vertically centered */
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .product img {
            width: 100px; /* Set fixed width for the image */
            height: auto; /* Maintain aspect ratio */
        }

        .product-details {
            display: flex;
            flex-direction: column;
        }

        .product-details h2 {
            margin: 0;
            font-size: 16px; /* Slightly smaller font size */
            color: #333;
        }

        .product-details p {
            margin: 4px 0;
            font-size: 12px; /* Slightly smaller font size */
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Catálogo de Productos</h1>
    <div class="catalog">
        @foreach ($productos as $p)
        <div class="product">
            <div>
                <div class="product-details">
                    <img src="{{ $base64EncodeImage('storage/multimedia/' . $p->img) }}" alt="Imagen del producto">
                    <h2>{{ $p->nombre }}</h2>
                    <p><strong>Código:</strong> {{ $p->codigo }}</p>
                    <p><strong>Precio:</strong> {{ $p->precio }}</p>
                    <p><strong>Cantidad:</strong> {{ $p->cantidad }}</p>
                    <p><strong>Estado:</strong> {{ $p->estado }}</p>
                </div>
            </div>

        </div>
        @endforeach
    </div>
</body>
</html>

