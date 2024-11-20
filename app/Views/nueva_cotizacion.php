<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app">
    <?php foreach ($cotizacion as $item): ?>        
    <div class="card shadow mb-4 rounded-0">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between rounded-0">
        <h6 class="m-0 font-weight-bold text-primary">Cotización <span ref="id_cotizacion"><?php echo $item['id_cotizacion'] ?></span></h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                <div class="dropdown-header"></div>
                <a class="dropdown-item" href="<?php echo base_url('descargar_cotizacion/'.$item['id_cotizacion']); ?>"><span class="bi bi-download"></span> Descargar</a>
                <a class="dropdown-item" href="" @click.prevent = "enviar_cotizacion(<?php  echo $item['id_cotizacion'] ?>)"><span class="bi bi-send"></span> Enviar</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="" onclick="return confirm('¿Estas seguro de querer eliminar esta cotización?');"><span class="bi bi-trash3"></span> Eliminar Cotización</a>
            </div>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body rounded-0">
        <div class="row">
            <div class="col-md-8">
                <p class="m-0"><strong>Para:</strong></p>
                <p class="m-0"><?php echo $item['hospital'] ?></p>
                <p class="m-0">Att: <?php echo $item['responsable'] ?></p>
                <p class="m-0">Tel: <?php echo $item['telefono'] ?></p>
                <p class="m-0"><?php echo $item['correo'] ?></p>
                <p class="m-0"><strong>Kardex asociado: </strong><a href="<?php echo base_url('kardex/').$slug?>"><?php echo $item['id_kardex'] ?></a></p>
            </div>
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <td>
                            <h5><strong>Sub-total</strong></h5>
                        </td>
                        <td>
                            <h5 class="text-primary">${{totales.sub_total}}</h5>
                        </td>
                    </tr>
                     <tr>
                        <td>
                            <h5><strong>IVA</strong></h5>
                        </td>
                        <td>
                            <h5 class="text-primary">${{totales.iva}}</h5>
                        </td>
                    </tr>
                     <tr class="bg-dark">
                        <td>
                            <h5 class="text-white"><strong>Pago Total</strong></h5>
                        </td>
                        <td>
                            <h5 class="text-white">${{totales.total}}</h5>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
</div>
<div class="card shadow mb-4 rounded-0">
    <div class="card-body">
        <button class="btn btn-primary btn-icon-split mb-3 mb-sm-0 mr-2" data-toggle="collapse" data-target="#independiente">
            <span class="icon text-white-50">
                <i class="bi bi-cart"></i>
            </span>
            <span class="text">Articulo Independiente</span>
        </button>
        <button class="btn btn-primary btn-icon-split" @click = "agregar_diagnostico_modal(<?php echo $item['id_kardex'] ?>)" data-toggle="modal" data-target="#agregar_articulo">
            <span class="icon text-white-50">
                <i class="bi bi-list-check"></i>
            </span>
            <span class="text">Agregar Diagnóstico</span>
        </button>
        <!--  Modal agregar diagnosticos  -->  
        <div class="modal fade" id="agregar_articulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Seleecione un diagnostico</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-for = "diag in diagnostico">
                        <table class="table w-100" id="articulos">
                            <thead>
                                <tr>
                                    <th>Diagnóstico</th>
                                    <th>Reparacion sugerida</th>
                                    <th>Precio estimado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{diag.diagnostico}}</td>
                                    <td>{{diag.reparacion}}</td>
                                    <td>${{total = diag.precio_estimado}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table w-100" id="articulos">
                            <thead>
                                <tr>
                                    <th>Refacciones</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "refa in refacciones">
                                    <td>{{refa.refaccion}}</td>
                                    <td>${{costo = refa.precio}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="diag.agregado != 1">
                            <h4 class="text-primary">Costo total: ${{+total + +costo}}</h4>
                            <div class="d-block mr-2">
                                <label for="">Descripción</label>
                                <textarea name="" id="" class="form-control rounded-0 shadow-none" v-model="articulo_ind"></textarea>
                            </div>
                            <div class="d-block w-25">
                                <label for="">Precio</label>
                                <input type="text" class="form-control form-control-sm rounded-0 shadow-none" v-model="precio_ind">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-icon-split" data-dismiss="modal">
                            <span class="icon text-white-50">
                                <i class="bi bi-box-arrow-right"></i>
                            </span>
                            <span class="text">Cerrar</span>
                        </button>
                        <div v-for="id_diagnostico in diagnostico">
                            <button type="button"  v-if="id_diagnostico.agregado != 1" class="btn btn-success btn-icon-split" @click = "agregar_ind(id_diagnostico.id_detalle_kardex)">
                                <span class="icon text-white-50">
                                    <i class="bi bi-check2"></i>
                                </span>
                                <span class="text">Agregar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse mt-4" id="independiente">
          <div class="d-flex justify-content-between align-items-center">
            <label for="">Cantidad</label>
            <input type="number" class="form-control rounded-0 shadow-none w-25"  v-model="cantidad">
            <label for="">Partida</label>
            <input type="number" class="form-control rounded-0 shadow-none w-25"  v-model="partida">
            <input type="text" class="form-control rounded-0 shadow-none" placeholder="Descripción" v-model="articulo_ind">
            <input type="text" class="form-control rounded-0 shadow-none w-25" placeholder="Precio" v-model="precio_ind">
            <button class="btn btn-primary ml-2" @click="agregar_ind('independiente')"><span class="bi bi-check"></span></button>
          </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4 rounded-0">
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Descripción</th>
                <th>Precio</th>
                <th>IVA</th>
                <th>Total</th>
                <td></td>
            </tr>
            <tr v-for = "dato in detalles">
                <td>{{dato.descripcion}}</td>
                <td>${{dato.precio_unitario}}</td>
                <td>${{dato.iva}}</td>
                <td>${{dato.total}}</td>
                <td><button class="btn btn-danger btn-sm rounded-0"><span class="bi bi-x-lg" @click = "borrar_linea_detalle(dato.id_cotizacion_detalle)"></span></button></td>
            </tr>
        </table>
    </div>
</div>
<?php endforeach ?>
</div>
<script src="<?php echo base_url('public/js/cotizaciones.js');?>"></script> 
<?php echo $this->endSection()?>