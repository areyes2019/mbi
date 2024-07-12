<?php echo $this->extend('Panel/panel_template')?>
<?php echo $this->section('contenido')?>
<div id="app">
    <div class="card shadow mb-4 rounded-0">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between rounded-0">
        <h6 class="m-0 font-weight-bold text-primary">Orden de Compra: <span ref="pedido"><?php echo $pedidos_id?></span></h6>
        <p>{{display_primero}}</p>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
                <div class="dropdown-header"></div>
                <a class="dropdown-item" href="<?php echo base_url('/descargar_orden/'.$pedidos_id); ?>"><span class="bi bi-download"></span> Descargar</a>
                <a class="dropdown-item" href="<?php echo base_url('/enviar_pdf/'.$pedidos_id); ?>"><span class="bi bi-send"></span> Enviar</a>
                <a :class="['dropdown-item']" v-if="display_pagado == 0" href="#" @click.prevent="agregar_pago"><span class="bi bi-credit-card"></span> Marcar pagado </a>
                <a :class="['dropdown-item']" v-if="display_recibido == 0" href="#" @click.prevent="recibida('<?php echo $pedidos_id ?>')"><span class="bi bi-truck"></span> Marcar Recibido </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo base_url('/eliminar_cotizacion/'.$pedidos_id); ?>" onclick="return confirm('¿Estas seguro de querer eliminar esta cotización?');"><span class="bi bi-trash3"></span> Eliminar Cotización</a>
            </div>
        </div>
    </div>
    <!-- Card Body -->
    <div class="card-body rounded-0">
        <?php foreach ($proveedor as $data): ?>
        <p class="m-0"><strong>Para:</strong></p>
        <p class="m-0 d-none" ref="proveedor"><?php echo $data['id_proveedor']?></p>
        <p class="m-0"><?php echo $data['empresa']?></p>
        <p class="m-0">Tel: <?php echo $data['telefono']?></p>
        <p class="m-0"><?php echo $data['correo']?></p>
        <p class="m-0">Descuento asignado a este proveedor: <span ref="descuento"><?php echo $data['descuento']?></span>%</p>
        <?php endforeach ?>
        <?php foreach ($pedido as $orden): ?>
        <p class="m-0"><?php echo $orden['fecha'] ?></p>
        <p v-if="<?php echo $orden['pagado'] ?>==1">Pagado</p>
        <?php endforeach ?>
    </div>
</div>
<div class="card shadow mb-4 rounded-0">
    <div class="card-body" v-if="display_pagado == 0">
        <button :class="['btn btn-primary', 'btn-icon-split']" data-toggle="modal" data-target="#agregar_articulo">
            <span class="icon text-white-50">
                <i class="bi bi-list-check"></i>
            </span>
            <span class="text">Articulo de Lista</span>
        </button>
        <!--  Modal agregar articulos -->  
        <div class="modal fade" id="agregar_articulo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Seleecione un artículo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table w-100" id="articulos">
                            <thead>
                                <tr>
                                    <th>Artículo</th>
                                    <th>Modelo</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for = "articulo in lista">
                                    <td>{{articulo.nombre}}</td>
                                    <td>{{articulo.modelo}}</td>
                                    <td>
                                        <input type="number" value="1" min="1" style="width: 50px;" :ref="articulo.idArticulo">
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-circle" @click="add_articulo(articulo.idArticulo)"><span class="bi bi-check"></span></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-icon-split" data-dismiss="modal">
                            <span class="icon text-white-50">
                                <i class="bi bi-box-arrow-right"></i>
                            </span>
                            <span class="text">Cerrar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4 rounded-0">
    <div class="card-body">
        <table class="table mt-4">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Cantidad</th>
                <th>PU</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for = "dato in articulos ">
                <td>{{dato.nombre}}</td>
                <td>{{dato.modelo}}</td>
                <td v-if="display_pagado==0">
                    <input type="number" min="1" :value="dato.cantidad" style="width:90px" @change="modificar_cantidad(dato.pedido_detalle_id)" :ref="dato.pedido_detalle_id" :disabled="disabled">
                </td>
                <td v-else>
                    {{dato.cantidad}}
                </td>
                <td>${{dato.p_unitario}}</td>
                <td>${{dato.total}}</td>
                <td><a v-if="display_pagado==0" href="#" @click.prevent="borrar_linea(dato.pedido_detalle_id)"><span class="bi bi-x-lg"></span></a></td>
              </tr>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3"></th>
                <td><strong>Sub-Total</strong></th>
                <td>${{sub_total}}</td> 
                <td></td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <td><strong>IVA</strong></th>
                <td>${{iva}}</td>
                <td></td>
              </tr>
              <tr>
                <th colspan="3"></th>
                <td><strong>Total</strong></th>
                <td>${{total}}</td>
                <td></td>
              </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
<script src="<?php echo base_url('public/js/compras.js');?>"></script> 
<?php echo $this->endSection()?>