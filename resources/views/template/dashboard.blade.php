<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sello Pronto</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <!-- insert stylesheets here -->
</head>
<body>
    <div class="top-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 d-flex align-items-center">
                    <h4 class="m-0">Sello Pronto</h4>
                </div>
                <div class="col-md-2 d-flex justify-content-end align-items-center">
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                      </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="side-nav">
        <nav class="side-nav-nav">
            <ul class="side-nav-list">
                <li class="side-nav-item"><a href="{{url('/quotations')}}"><span class="bi bi-circle"></span>Cotizaciones</a></li>
                <li class="side-nav-item"><a href=""><span class="bi bi-circle"></span>Proveedores</a></li>
                <li class="side-nav-item"><a href=""><span class="bi bi-circle"></span>Clientes</a></li>
                <li class="side-nav-item"><a href=""><span class="bi bi-circle"></span>Pedidos a proveedor</a></li>
                <li class="side-nav-item"><a href=""><span class="bi bi-circle"></span>Cotizaciones</a></li>
                <li class="side-nav-item"><a href=""><span class="bi bi-circle"></span>Facturas</a></li>
                <button class="btn btn-danger mt-4">Nueva Cotización</button>
                <button class="btn btn-danger mt-1">Nuevo Cliente</button>
            </ul>
        </nav>
    </div>
    <div class="main">
        <div class="container-fluid">
            <h2>Panel de Control</h2>
            <div class="row mt-5">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4 p-0">
              <div class="card-header">
                Ultimas Cotizaciones
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        <tr>
                            <td>55</td>
                            <td>Agro industrias</td>
                            <td>5 abril 20023</td>
                            <td>$250.00</td>
                            <td class="d-flex justify-content-end">
                                <button class="btn btn-danger btn-sm">Ver</button>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
              </div>
            </div>
        </div>                      
    </div>     
    </div>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
</body>
</html>