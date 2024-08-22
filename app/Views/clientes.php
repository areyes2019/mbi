<?php echo $this->extend('panel_template')?>
<?php echo $this->section('contenido')?>
<div class="container-fluid" id="app">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url('inicio'); ?>">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Clientes</li>
      </ol>
    </nav>
    <div class="row column_title">
        <div class="col-md-12">
            <div class="page_title">
                <h2>Clientes</h2>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row mt-4">
        <!-- table section -->
        <div class="col-md-12">
            <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                    <div class="heading1 margin_0 mb-2">
                        <a href="<?php echo base_url('agregar_cliente'); ?>" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Nuevo Cliente</span>
                        </a>
                    </div>
                    <div class="modal fade" id="nuevo_cliente">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="<?php echo base_url('nuevo_cliente');?>" method="post">
                                <label for="">Nombre</label>
                                <input type="text" class="my-input w-100" name="nombre">
                                <label for="">Numero WhatsApp</label>
                                <input type="text" class="my-input w-100" name="telefono">
                                <button class="btn btn-primary btn-icon-split mt-2">
                                    <span class="icon text-white-50">
                                        <i class="bi bi-save"></i>
                                    </span>
                                    <span class="text">Guardar</span>
                                </button>
                            </form>
                          </div>
                          <div class="modal-footer">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="table_section padding_infor_info">
                    <div class="table-responsive-sm">
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Doctor o Encargado</th>
                                    <th>Contacto</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Móvil</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><a href="" data-toggle="modal" data-target="#ver_cliente"><?php echo $cliente['titular'] ?></a></td>
                                    <td><?php echo $cliente['responsable'] ?></td>
                                    <?php if ($cliente['correo'] == null):?>
                                    <td>No registrado</td>
                                    <?php else:?>
                                    <td><?php echo $cliente['correo'] ?></td>
                                    <td><?php echo $cliente['telefono'] ?></td>
                                    <td><?php echo $cliente['movil'] ?></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <div class="dropdown" id="menu" data-toggle="tooltip" title="Opciones de edición">
                                          <a href="#" type="button" data-toggle="dropdown" aria-expanded="false">
                                            <span class="bi bi-three-dots-vertical"></span>
                                          </a>
                                          <div class="dropdown-menu rounded-0">
                                            <a class="dropdown-item" href="/editar_cliente/<?php echo $cliente['id_cliente']; ?>">Editar Cliente</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="if(confirm('¿Estás seguro de que deseas eliminar este cliente?')) { window.location.href='/eliminar_cliente/<?php echo $cliente['id_cliente'] ?>'; }">
                                                Eliminar Cliente
                                            </a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#agregar_datos_fiscales">Agregar Datos Fiscales</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#agregar_horario">Agregar Horarios de Atencion</a>
                                          </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Doctor o Encargado</th>
                                    <th>Responsable</th>
                                    <th>Correo</th>
                                    <th>Teléfono</th>
                                    <th>Móvil</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--  Modal agregar horario -->
        <div class="modal fade" id="agregar_horario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title">Horarios de Atención</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <button class="btn btn-primary btn-sm rounded-0 mb-2" type="button" onclick="agregarCampo()">Agregar Horario</button>
                            <!-- Grupo de campos 1 -->
                            <div class="form-row align-items-end mb-3">
                                <div class="col-md-4">
                                    <label for="dia1">Día de la Semana</label>
                                    <select id="dia1" name="dia1" class="form-control">
                                        <option value="Lunes">Lunes</option>
                                        <option value="Martes">Martes</option>
                                        <option value="Miércoles">Miércoles</option>
                                        <option value="Jueves">Jueves</option>
                                        <option value="Viernes">Viernes</option>
                                        <option value="Sábado">Sábado</option>
                                        <option value="Domingo">Domingo</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="horaInicio1">De:</label>
                                    <input type="time" id="horaInicio1" name="horaInicio1" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="horaFin1">A:</label>
                                    <input type="time" id="horaFin1" name="horaFin1" class="form-control">
                                </div>
                            </div>
                            <div id="contenedorCampos">
                            <!-- Los campos dinámicos se agregarán aquí -->
                            </div>
                            <button class="btn btn-primary btn-sm rounded-0">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  Modal agregar horario -->
        <div class="modal fade" id="agregar_datos_fiscales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-body">
                    <h4>Datos Fiscales</h4>
                    <!-- contacto -->
                    <!-- Regimen Fiscasl -->
                    <div class="form-group">
                        <select name="regimen-fiscal" id="regimen-fiscal" style="width:100%">
                            <option value=""></option>
                            <option value="601">601 - General de Ley Personas Morales</option>
                            <option value="603">603 - Personas Morales con Fines no Lucrativos</option>
                            <option value="605">605 - Sueldos y Salarios e Ingresos Asimilados a Salarios</option>
                            <option value="606">606 - Arrendamiento</option>
                            <option value="607">607 - Régimen de Enajenación o Adquisición de Bienes</option>
                            <option value="608">608 - Demás ingresos</option>
                            <option value="609">609 - Consolidación</option>
                            <option value="610">610 - Residentes en el Extranjero sin Establecimiento Permanente en México</option>
                            <option value="611">611 - Ingresos por Dividendos (socios y accionistas)</option>
                            <option value="612">612 - Personas Físicas con Actividades Empresariales y Profesionales</option>
                            <option value="614">614 - Ingresos por Intereses</option>
                            <option value="615">615 - Régimen de los ingresos por obtención de premios</option>
                            <option value="616">616 - Sin obligaciones fiscales</option>
                            <option value="620">620 - Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>
                            <option value="621">621 - Incorporación Fiscal</option>
                            <option value="622">622 - Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>
                            <option value="623">623 - Opcional para Grupos de Sociedades</option>
                            <option value="624">624 - Coordinados</option>
                            <option value="625">625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>
                            <option value="626">626 - Régimen Simplificado de Confianza</option>
                        </select>
                    </div>
                    <!--  Razon social -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend input-group-sm">
                              <div class="input-group-text rounded-0">
                                <i class="bi bi-person"></i>
                              </div>
                            </div>
                            <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Nombre o razón social *" v-model="form.contacto">
                        </div>
                        <small class="text-danger mt-0"></small>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!--  correo  -->
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Correo Elecrtónico *" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <!-- RFC -->
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" maxlength="12" @input="limpiar_error($event,'contacto')" placeholder="RFC *" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row"> <!-- row  -->
                        <div class="col-6">
                            <div class="form-group">
                                <!-- Calle  -->
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Calle" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Int *" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Num Ext. *" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                    </div> <!--  row -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Colonia" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Código Postal *" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend input-group-sm">
                                      <div class="input-group-text rounded-0">
                                        <i class="bi bi-person"></i>
                                      </div>
                                    </div>
                                    <input type="text" class="form-control rounded-0 form-control-sm shadow-none" @input="limpiar_error($event,'contacto')" placeholder="Ciudad *" v-model="form.contacto">
                                </div>
                                <small class="text-danger mt-0"></small>
                            </div>
                        </div>
                        <div class="col-6">
                            <select v-model="form.estado"  id="estados" class="form-control">
                                <option value=""></option>
                                <option value="AGS">Aguascalientes</option>
                                <option value="BC">Baja California</option>
                                <option value="BCS">Baja California Sur</option>
                                <option value="CAMP">Campeche</option>
                                <option value="CHIS">Chiapas</option>
                                <option value="CHIH">Chihuahua</option>
                                <option value="CDMX">Ciudad de México</option>
                                <option value="COAH">Coahuila</option>
                                <option value="COL">Colima</option>
                                <option value="DGO">Durango</option>
                                <option value="GTO">Guanajuato</option>
                                <option value="GRO">Guerrero</option>
                                <option value="HGO">Hidalgo</option>
                                <option value="JAL">Jalisco</option>
                                <option value="MEX">México</option>
                                <option value="MICH">Michoacán</option>
                                <option value="MOR">Morelos</option>
                                <option value="NAY">Nayarit</option>
                                <option value="NL">Nuevo León</option>
                                <option value="OAX">Oaxaca</option>
                                <option value="PUE">Puebla</option>
                                <option value="QRO">Querétaro</option>
                                <option value="QR">Quintana Roo</option>
                                <option value="SLP">San Luis Potosí</option>
                                <option value="SIN">Sinaloa</option>
                                <option value="SON">Sonora</option>
                                <option value="TAB">Tabasco</option>
                                <option value="TAMPS">Tamaulipas</option>
                                <option value="TLAX">Tlaxcala</option>
                                <option value="VER">Veracruz</option>
                                <option value="YUC">Yucatán</option>
                                <option value="ZAC">Zacatecas</option>
                            </select>
                        </div>

                    </div>
                    <button class="btn btn-primary btn-sm rounded-0">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
    $( document ).ready(function() {
        new DataTable('#example');
        $('#menu').tooltip();
        $('#agregar_datos_fiscales').on('shown.bs.modal', function () {
            $('#estados').select2({
              allowClear: true,
              placeholder: 'Selecciona un estado',
              dropdownParent: $('#agregar_datos_fiscales')
            });
            $('#regimen-fiscal').select2({
              allowClear: true,
              placeholder: 'Selecciona el régimen fiscal',
              dropdownParent: $('#agregar_datos_fiscales')
            });
        });
    });
    </script>
</div>
<script type="text/javascript" src="<?php echo base_url('public/js/form_horarios.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('public/js/clientes.js'); ?>"></script>
<?php echo $this->endSection()?>
