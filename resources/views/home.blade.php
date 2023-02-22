@extends('template.app')
@section('content')
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Ventas Totales</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$month}} {{$year}}</h6>
                            <h4>${{$sales}}</h4>
                            <a href="#" class="card-link">Ir a resumen</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Utilidades netas</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$month}} {{$year}}</h6>
                            <h4>${{$profit}}</h4>
                            <a href="#" class="card-link">Ir a resumen</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Piezas vendidas</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$month}} {{$year}}</h6>
                            <h4>{{$sold}}</h4>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total de Gastos</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$month}} {{$year}}</h6>
                            <h4>${{$spent}}</h4>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mt-4 p-0">
                      <div class="card-header">
                        Resumen - {{$month}} {{$year}}
                      </div>
                      <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Entradas Totales </th>
                                <td>${{$sales}}</td>
                            </tr>
                            <tr>
                                <th>Utilidades Brutas</th>
                                <td>${{$profit}}</td>
                            </tr>
                            <tr>
                                <th>Gastos</th>
                                <td>${{$spent}}</td>
                            </tr>
                            <tr>
                                <th>Ganancias netas</th>
                                <td>${{$net}}</td>
                            </tr>
                            
                        </table>
                      </div>
                    </div>
                </div>
                <div class="col-md-8">
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
@endsection