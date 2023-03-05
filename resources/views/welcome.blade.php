<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>API Rick y Morty</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Styles -->

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
        style="display: flex; flex-direction: row; gap: 30px; justify-content: center; align-items: flex-start; margin-top: 32px">
        <div style="width: 580px; border: 1px solid grey; border-radius: 15px">
            <div class="tituloMostrarTodo">
                <h3>Todos los personajes</h3>
            </div>
            <div class="paginacion" id="pagination"
                style="display: flex; justify-content: space-between; margin: 25px 10px">
                <div class="container_pre" id="container_pre">
                    <div id="previous">
                        <button class="btn btn-secondary" id="btn_pre" disabled>Anterior</button>
                    </div>
                </div>
                <div id="numPagina">
                    <h6>Pagina {{ $pagina }}</h6>
                </div>
                <div class="container_next" id="container_next">
                    <div id="next">
                        <button class="btn btn-secondary" id="btn_next">Siguiente</button>
                    </div>
                </div>

            </div>
            <div class="tablaMostrar" id="tablaMostrar">


                <table class="table table-striped table-hover" id="">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Especie</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTabla">
                        @foreach ($personajes as $item)
                            <tr>
                                <td>{{ $item['id'] }}</th>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['status'] }}</td>
                                <td>{{ $item['species'] }}</td>
                                <td>
                                    <a class="btn btn-success"
                                        href="{{ Route('mostrar_detalle', $item['id']) }}">Mostrar
                                        Detalle</a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <div style="width: 580px; border: 1px solid grey; border-radius: 15px">
            <div class="container" style="">
                <div class="titulo">
                    <h3>Filtrar</h3>

                    <h6>En esta sección se podra filtar por Especie y Estado</h6>
                </div>

                <div class="form_busqueda">
                    <form action=""
                        style="display: flex; flex-direction: row; justify-content: center; align-items: center; padding: 15px 15px; ">

                        <h6>Seleccione Especie</h6>
                        <select class="form-select" name="especies" id="select_especies"
                            style="width: 50%; margin: 20px 20px;">
                            <option value="0">--</option>
                            @foreach ($especies as $es)
                                <option value="{{ $es }}">{{ $es }}</option>
                            @endforeach
                        </select>

                        <h6>Seleccione Estado</h6>
                        <select class="form-select" name="estados" id="select_estados"
                            style="width: 50%; margin: 20px 20px;">
                            <option value="0">--</option>
                            @foreach ($estados as $est)
                                <option value="{{ $est }}">{{ $est }}</option>
                            @endforeach
                        </select>


                        <button class="btn btn-primary" id="btn_filtro">Buscar</button>

                    </form>

                    <div class="container_pagination_Filtro" id="pagination_filtro"
                        style="display: flex; justify-content: space-between; margin: 25px 5px">

                    </div>
                    <div class="container_tabla" id="tabla_filtro">

                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- script bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>

    <script>
        url = "https://rickandmortyapi.com/api/character"

        let pagina = {!! $pagina !!}

        ////////////////////////////////////////////////////////////////////
        //////////////////paginacion tabla de todos los personajes///////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////
        let paginacion = document.getElementById('pagination')
        let pre = document.getElementById('previous')
        let next = document.getElementById('next')
        paginacion.addEventListener('click', (e) => {

            console.log(e)
            if (e.target.matches("button#btn_pre.btn.btn-secondary")) {
                pagina = pagina - 1
            }
            if (e.target.matches("button#btn_next.btn.btn-secondary ")) {
                pagina = pagina + 1
            }

            document.getElementById('numPagina').innerHTML = `<h6>Pagina ${ pagina }</h6>`

            if (pagina > 1) {
                document.getElementById('btn_pre').disabled = false
            } else {
                document.getElementById('btn_pre').disabled = true
            }
            if (pagina == 42) {
                document.getElementById('btn_next').disabled = true
            } else {
                document.getElementById('btn_next').disabled = false
            }


            // https://rickandmortyapi.com/api/character/?page=19

            urlPaginacion = `${url}/?page=${pagina}`

            fetch(urlPaginacion)
                .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                .then((json) => {



                    let personajes_aux = ''
                    json['results'].forEach(element => {
                        let url_aux = "{{ Route('mostrar_detalle', ['id' => 'temp']) }}";
                        url_aux = url_aux.replace('temp', element['id']);
                        personajes_aux = `${personajes_aux}
                                    <tr>
                                        <td>${element['id']}</td>
                                        <td>${element['name']}</td>
                                        <td>${element['status']}</td>
                                        <td>${element['species']}</td>
                                        <td>
                                            <a class="btn btn-success" href="${url_aux}">Mostrar Detalle</a>   
                                        </td>
                                    </tr>`
                    });

                    let tabla = `<table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Especie</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                                ${personajes_aux}

                            </tbody>
                        </table>`

                    document.getElementById('tablaMostrar').innerHTML = tabla


                })
                .catch()



        })


        //////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////*Filtro*////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////
        let btnFiltro = document.getElementById('btn_filtro')
        let paginationFiltro = document.getElementById('pagination_filtro')
        let tablaFiltro = document.getElementById('tabla_filtro')

        //funcion que crea las tablas del filtro
        function crearTabla(data) {
            let personajes_aux = ''
            data['results'].forEach(element => {
                let url_aux = "{{ Route('mostrar_detalle', ['id' => 'temp']) }}";
                url_aux = url_aux.replace('temp', element['id']);
                personajes_aux = `${personajes_aux}
                        <tr>
                            <td>${element['id']}</td>
                            <td>${element['name']}</td>
                            <td>${element['status']}</td>
                            <td>${element['species']}</td>
                            <td>
                                <a class="btn btn-success" href="${url_aux}">Mostrar Detalle</a>   
                            </td>
                        </tr>`

            });

            let tabla = `<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Especie</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>

                    ${personajes_aux}

                </tbody>
            </table>`

            tablaFiltro.innerHTML = tabla
        }
        //funcion que crea la paginacion del filtro
        function crearPaginacion(url, paginas) {
            codigoPaginationFiltro = `<div class="container_pre_filtro" id="container_pre_filtro">
                                                            <div id="previous_filtro">
                                                                <button class="btn btn-secondary" id="btn_pre_filtro" disabled>Anterior</button>
                                                            </div>
                                                        </div>
                                                        <div id="numPagina_filtro">
                                                            <input type="text" name="" id="url_filtro" value="${url}" hidden>
                                                            <input type="text" name="" id="paginas_filtro" value="${paginas}" hidden>
                                                            <input type="number" name="" id="pagina_filtro" value="${1}" disabled>
                                                        </div>
                                                        <div class="container_next_filtro" id="container_next_filtro">
                                                            <div id="next_filtro">
                                                                <button class="btn btn-secondary" id="btn_next_filtro">Siguiente</button>
                                                            </div>
                                                        </div>`

            paginationFiltro.innerHTML = codigoPaginationFiltro
        }


        //////////////////////paginacion filtro/////////////////////////////////
        paginationFiltro.addEventListener('click', (e) => {
            e.preventDefault();
            let especie = document.getElementById('select_especies').value
            let estado = document.getElementById('select_estados').value
            let urlFiltro = document.getElementById('url_filtro').value
            let paginas_filtro = document.getElementById('paginas_filtro').value // total de paginas de la busqueda
            let pagina_filtro = Number(document.getElementById('pagina_filtro').value)


            //verificamos que boton se oprime
            if (e.target.matches("button#btn_pre_filtro.btn.btn-secondary")) {
                pagina_filtro = pagina_filtro - 1
            }
            if (e.target.matches("button#btn_next_filtro.btn.btn-secondary")) {
                pagina_filtro = pagina_filtro + 1
            }

            let url1 = ''
            let url2 = ''
            let nuevaUrl = ''
            //segun el filtro que se utilice ingresara en la condicion y se creara la url para la busqueda de los datos en la API
            if (especie == 0) {
                //se crea la nueva url de busqueda
                nuevaURL =
                    `https://rickandmortyapi.com/api/character/?page=${pagina_filtro}&status=${estado}`
                console.log(nuevaURL)
                fetch(nuevaURL)
                    .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                    .then((json) => {
                        console.log(json)
                        crearTabla(json)
                    })
                    .catch()

            } else if (estado == 0) {
                //se crea la nueva url de busqueda
                nuevaURL =
                    `https://rickandmortyapi.com/api/character/?page=${pagina_filtro}&species=${especie}`
                console.log(nuevaURL)
                fetch(nuevaURL)
                    .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                    .then((json) => {
                        console.log(json)
                        crearTabla(json)
                    })
                    .catch()

            } else {
                //se crea la nueva url de busqueda
                nuevaURL =
                    `https://rickandmortyapi.com/api/character/?page=${pagina_filtro}&species=${especie}&status=${estado}`
                console.log(nuevaURL)
                fetch(nuevaURL)
                    .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                    .then((json) => {
                        console.log(json)
                        crearTabla(json)
                    })
                    .catch()


            }

            //se agregan los nuevos datos en la paginación
            document.getElementById('numPagina_filtro').innerHTML =
                `<input type="text" name="" id="url_filtro" value="${urlFiltro}" hidden>
                        <input type="text" name="" id="paginas_filtro" value="${paginas_filtro}" hidden>
                        <input type="text" name="" id="especie_filtro" value="${especie}" hidden>
                        <input type="text" name="" id="estado_filtro" value="${estado}" hidden>
                        <input type="number" name="" id="pagina_filtro" value="${pagina_filtro}" disabled>`

            //desabilita el boton "Anterior" si la pagina es 1         
            if (pagina_filtro > 1) {
                document.getElementById('btn_pre_filtro').disabled = false
            } else {
                document.getElementById('btn_pre_filtro').disabled = true
            }
            //desabilita el boton "Siguiente" si llega a la pagina_filtro tiene el mismo valor de paginas_filtro(cantidad total de paginas de la busqueda)
            if (pagina_filtro == paginas_filtro) {
                document.getElementById('btn_next_filtro').disabled = true
            } else {
                document.getElementById('btn_next_filtro').disabled = false
            }



        })


        //////////////////////Boton busqueda del filtro/////////////////////////////////
        btnFiltro.addEventListener("click", (e) => {

            e.preventDefault();
            let especie = document.getElementById('select_especies').value
            let estado = document.getElementById('select_estados').value


            // https://rickandmortyapi.com/api/character/?name=rick&status=alive
            if (especie == 0 && estado == 0) {
                alert('Debe seleccionar un especie o algún estado');
            } else if (especie == 0) {
                let urlEstado = `${url}/?status=${estado}`
                fetch(urlEstado)
                    .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                    .then((json) => {
                        let cantidadPages = json['info']['pages'];
                        let url_next = json['info']['next']
                        //si el resultado tiene más de una pagina se crea la paginacion
                        paginationFiltro.innerHTML = ''
                        if (cantidadPages > 1) {
                            crearPaginacion(url_next, cantidadPages)
                        }
                        crearTabla(json)
                    }).catch()

            } else if (estado == 0) {
                let urlEspecie = `${url}/?species=${especie}`
                fetch(urlEspecie)
                    .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                    .then((json) => {

                        let cantidadPages = json['info']['pages'];
                        let url_next = json['info']['next']
                        paginationFiltro.innerHTML = ''
                        //si el resultado tiene más de una pagina se crea la paginacion
                        if (cantidadPages > 1) {
                            crearPaginacion(url_next, cantidadPages)
                        }
                        crearTabla(json)
                    }).catch()
            } else {

                let urlEspecieEstado = `${url}/?species=${especie}&status=${estado}`
                console.log(especie, estado)
                fetch(urlEspecieEstado)
                    .then((res) => (res.ok ? res.json() : Promise.reject(res)))
                    .then((json) => {

                        let cantidadPages = json['info']['pages'];
                        let url_next = json['info']['next']
                        paginationFiltro.innerHTML = ''
                        //si el resultado tiene más de una pagina se crea la paginacion
                        if (cantidadPages > 1) {
                            crearPaginacion(url_next, cantidadPages)
                        }
                        crearTabla(json)
                    }).catch()
            }
        })
    </script>
</body>

</html>
