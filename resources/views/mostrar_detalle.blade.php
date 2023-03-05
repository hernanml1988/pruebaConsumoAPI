<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <div style="display:flex; justify-content: center; align-items: center; margin-top: 50px">
        <div class="card" style="width: 18rem;">
            <img src="{{ $personaje['image'] }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $personaje['name'] }}</h5>
                <div class="detalle">
                    <table class="table table-striped table-hover">

                        <tbody>

                            <tr>
                                <td>Estado</th>
                                <td>{{ $personaje['status'] }}</td>
                            </tr>
                            <tr>
                                <td>Especie</th>
                                <td>{{ $personaje['species'] }}</td>
                            </tr>
                            <tr>
                                <td>Genero</th>
                                <td>{{ $personaje['gender'] }}</td>
                            </tr>
                            <tr>
                                <td>Origen</th>
                                <td>{{ $personaje['location']['name'] }}</td>
                            </tr>


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>
