<?php
include '../header.php';
?>

<div class="container-fluid px-1" id="movimientos">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-4">
            <h2 class="men">Movimientos</h2>
        </div>
    </div>
    <br>
    <div class="card mt-3" v-if="showmoves" style="border: none;text-align:center">
        <div class="row">
            <div class="col-md-3 mb-1">
                <b-form-select v-model="id_empresa" @change="obtenerSucursalS();">
                    <b-form-select-option value=''>Empresa</b-form-select-option>
                    <b-form-select-option v-for="row in empresaColleccion" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                </b-form-select>
            </div>
            <div class="col-md-2 mb-1">
                <b-form-select v-model="id_sucursal" @change="obtenerCajaS();">
                    <b-form-select-option value="">Sucursal</b-form-select-option>
                    <b-form-select-option v-for="row in sucursalColleccion" v-bind:key="row.id_sucursal" :value="row.id_sucursal">{{row.nombre_sucursal}}</b-form-select-option>
                </b-form-select>
            </div>
            <div class="col-md-2 mb-1">
                <b-form-select v-model="id_caja">
                    <b-form-select-option value=0>Caja</b-form-select-option>
                    <b-form-select-option v-for="row in cajaColleccion" v-bind:key="row.id_caja" :value="row.id_caja">{{row.nombre_caja}}</b-form-select-option>
                </b-form-select>
            </div>
            <div class="col-md-2 mb-1">
                <input type="number" class="form-control" style="width: 100%;" placeholder="Año" v-model="anio">
            </div>
            <div class="col-md-2 mb-2">
                <b-form-select v-model="mes">
                    <b-form-select-option value=0>Mes</b-form-select-option>
                    <b-form-select-option v-for="row in meses" v-bind:key="row.no_mes" :value="row.no_mes">{{row.mes}}</b-form-select-option>
                </b-form-select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-warning text-white" type="button" @click="obtenerMovimientos();"><i class="fa-solid fa-magnifying-glass"></i></button>

            </div>
        </div>
    </div>
    <br>
    <br>
    <div class="card" id="form-person" v-if="showmoves == false">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item" v-if="movements == false">
                    <a class="nav-link" @click="mov();" style="cursor:pointer">Traspaso</a>
                </li>
                <li class="nav-item" v-if="movements">
                    <a class="nav-link active" @click="mov();" style="cursor:pointer">Traspaso</a>
                </li>
                <li class="nav-item" v-if="movin == false">
                    <a class="nav-link" @click="ins();" style="cursor:pointer">Ingreso</a>
                </li>
                <li class="nav-item" v-if="movin">
                    <a class="nav-link active" @click="ins();" style="cursor:pointer">Ingreso</a>
                </li>
                <li class="nav-item" v-if="movout == false">
                    <a class="nav-link" @click="out();" style="cursor:pointer">Salida</a>
                </li>
                <li class="nav-item" v-if="movout">
                    <a class="nav-link active" @click="out();" style="cursor:pointer">Salida</a>
                </li>
            </ul>
        </div>
        <div class="card-body" v-if="movements">
            <button type="button" class="btn btn-outline-info float-right" @click="verForm();" v-if="showmoves == false"><i class="fa-solid fa-eye"></i> Ver Traspasos</button>

            <form style="margin: 2%;">
                <div class="form-group mb-3">
                    <label>Tipo de Movimiento</label>
                    <select class="custom-select" v-model="id_tipo" disabled>
                        <option disabled>Selecciona el tipo de movimiento</option>
                        <option v-for="row in tipoColleccion" :value="row.id_atributo">{{row.nombre_atributo}}</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="concepto">Concepto</label>
                    <select class="custom-select" v-model="concepto">
                        <option value=0 disabled>Selecciona el concepto</option>
                        <option v-for="row in conceptoColleccion" :value="row.id_concepto">{{row.concepto}}</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" v-model="descripcion" placeholder="Ingresa una Descripción">
                </div>
                <div class="row">
                    <div class="col-sm-6" style="border-right: 2px solid #002752;">

                        <h5 class="ti">Origen</h5>
                        <select class="custom-select mb-3" v-model="id_empresa_origen" @change="obtenerSucursal();">
                            <option value="" disabled>Selecciona la Empresa (Origen)</option>
                            <option v-for="row in empresaColleccion" :value="row.id_empresa">{{row.nombre_empresa}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_sucursal_origen" @change="obtenerCaja();">
                            <option value="" disabled>Selecciona la Sucursal (Origen)</option>
                            <option v-for="row in sucursalColleccion" :value="row.id_sucursal">{{row.nombre_sucursal}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_caja_origen" @change="obtenerMoneda();">
                            <option value="" disabled>Selecciona la Caja (Origen)</option>
                            <option v-for="row in cajaColleccion" :value="row.id_caja">{{row.nombre_caja}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="moneda" @change="obtenerSaldo();">
                            <option value=0 disabled>Selecciona la moneda</option>
                            <option v-for="row in monedaColleccion" :value="row.id_moneda">{{row.moneda}}</option>
                        </select>
                        <input type="number" class="form-control mb-2" v-model="monto" placeholder="Ingresa el monto a enviar">
                        <label v-if="moneda != 0">Saldo en caja disponible: {{saldoDisp}} </label>
                    </div>
                    <div class="col-sm-6">
                        <h5 class="ti">Destino</h5>
                        <select class="custom-select mb-3" v-model="id_empresa_destino" @change="obtenerSucursalD();" v-if="id_tipo == 2">
                            <option value="" disabled>Selecciona la Empresa (Destino D)</option>
                            <option v-for="row in empresaColleccionD" :value="row.id_empresa">{{row.nombre_empresa}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_empresa_destino" @change="obtenerSucursal2();" v-if="id_tipo == 1 && moneda == 0" disabled>
                            <option value="" disabled>Selecciona la Empresa (Destino)</option>
                            <option v-for="row in empresaColleccion2" :value="row.id_empresa">{{row.nombre_empresa}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_empresa_destino" @change="obtenerSucursal2();" v-if="id_tipo == 1 && moneda != 0">
                            <option value="" disabled>Selecciona la Empresa (Destino)</option>
                            <option v-for="row in empresaColleccion2" :value="row.id_empresa">{{row.nombre_empresa}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_sucursal_destino" @change="obtenerDepartamento();" v-if="id_tipo == 2">
                            <option value="" disabled>Selecciona la Sucursal (Destino D)</option>
                            <option v-for="row in sucursalColleccionD" :value="row.id_sucursal">{{row.nombre_sucursal}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_sucursal_destino" @change="obtenerCaja2();" v-else>
                            <option value="" disabled>Selecciona la Sucursal (Destino)</option>
                            <option v-for="row in sucursalColleccion2" :value="row.id_sucursal">{{row.nombre_sucursal}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_departamento_destino" @change="obtenerCajaD();" v-if="id_tipo == 2">
                            <option value="" disabled>Selecciona el Departamento (Destino D)</option>
                            <option v-for="row in departamentoColleccion" :value="row.id_departamento">{{row.nombre_departamento}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_caja_destino" v-if="id_tipo == 2" @click="obtenerSaldoD();">
                            <option value="" disabled>Selecciona la Caja (Destino D)</option>
                            <option v-for="row in cajaColleccionD" :value="row.id_caja_departamento">{{row.nombre_caja_departamento}}</option>
                        </select>
                        <select class="custom-select mb-3" v-model="id_caja_destino" @click="obtenerSaldoD();" v-else>
                            <option value="" disabled>Selecciona la Caja (Destino)</option>
                            <option v-for="row in cajaColleccion2" :value="row.id_caja">{{row.nombre_caja}}</option>
                        </select>
                        <label v-if="id_caja_destino != ''">Saldo en caja destino: {{saldoDispDestino}} </label>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-muted text-right" style="background:none;border:none" v-if="movements">
            <div>
                <!-- <button type="button" class="btn btn-secondary" style="background-color:#001E31;color:white" @click="verTabla();"><i class="fa-solid fa-left-long"></i></button> -->
                <button type="button" class="btn btn-secondary text-white" @click="limpiar();"><i class="fa-solid fa-broom"></i></button>
                <button type="button" class="btn btn-warning text-white" @click="insertarMovimiento();"><i class="fa-solid fa-arrow-right-to-city"></i> Generar Movimiento</button>
            </div>
        </div>
        <!-- INSERTAR SALDO -->
        <div class="card-body" v-if="movin">
            <form style="margin: 2%;">
                <label>Empresa</label>
                <select class="custom-select mb-3" v-model="id_empresa_origen" @change="obtenerSucursal();">
                    <option value="" disabled>Selecciona la Empresa</option>
                    <option v-for="row in empresaColleccion" :value="row.id_empresa">{{row.nombre_empresa}}</option>
                </select>
                <label>Sucursal</label>
                <select class="custom-select mb-3" v-model="id_sucursal_origen" @change="obtenerCajaIn();">
                    <option value="" disabled>Selecciona la Sucursal</option>
                    <option v-for="row in sucursalColleccion" :value="row.id_sucursal">{{row.nombre_sucursal}}</option>
                </select>
                <label>Caja</label>
                <select class="custom-select mb-3" v-model="caja">
                    <option value=0 disabled>Selecciona la caja</option>
                    <option v-for="row in cajaColleccionIn" :value="row.id_caja">{{row.nombre_caja}}</option>
                </select>
                <label>Moneda</label>
                <select class="custom-select mb-3" v-model="moneda" @change="obtenerSaldoIn();">
                    <option value=0 disabled>Selecciona la moneda</option>
                    <option v-for="row in monedaColleccion" :value="row.id_moneda">{{row.moneda}}</option>
                </select>
                <label>Monto</label>
                <input class="form-control mb-3" min="0" type="number" placeholder="0" v-model="montoin">
                <label>Concepto</label>
                <select class="custom-select mb-3" v-model="concepto">
                    <option value=0 disabled>Selecciona el concepto</option>
                    <option v-for="row in conceptoColleccion" :value="row.id_concepto">{{row.concepto}}</option>
                </select>
                <label>Descripción</label>
                <input class="form-control  mb-3" type="text" placeholder="Escribe una descripción" v-model="descripcion">
                <label>Cliente</label>
                <input class="form-control" type="text" placeholder="Ingresa el cliente" v-model="cliente">
            </form>
            <div class="card-footer text-muted text-right" style="background:none;border:none" v-if="movin">
                <div>
                    <!-- <button type="button" class="btn btn-secondary" style="background-color:#001E31;color:white" @click="verTabla();"><i class="fa-solid fa-left-long"></i></button> -->
                    <button type="button" class="btn btn-secondary text-white" @click="limpiar();"><i class="fa-solid fa-broom"></i></button>
                    <button type="button" class="btn btn-success text-white" @click="agregarSaldoDolar();"><i class="fa-solid fa-plus"></i> Agregar Saldo</button>
                </div>
            </div>
        </div>
        <!-- RETIRAR DINERO -->
        <div class="card-body" v-if="movout">
            <form style="margin: 2%;">
                <label>Empresa</label>
                <select class="custom-select mb-3" v-model="id_empresa_origen" @change="obtenerSucursal();">
                    <option value="" disabled>Selecciona la Empresa</option>
                    <option v-for="row in empresaColleccion" :value="row.id_empresa">{{row.nombre_empresa}}</option>
                </select>
                <label>Sucursal</label>
                <select class="custom-select mb-3" v-model="id_sucursal_origen" @change="obtenerCajaIn();">
                    <option value="" disabled>Selecciona la Sucursal</option>
                    <option v-for="row in sucursalColleccion" :value="row.id_sucursal">{{row.nombre_sucursal}}</option>
                </select>
                <label>Caja</label>
                <select class="custom-select mb-3" v-model="caja">
                    <option value=0 disabled>Selecciona la caja</option>
                    <option v-for="row in cajaColleccionIn" :value="row.id_caja">{{row.nombre_caja}}</option>
                </select>
                <label>Moneda</label>
                <select class="custom-select mb-3" v-model="moneda" @change="obtenerSaldoIn();">
                    <option value=0 disabled>Selecciona la moneda</option>
                    <option v-for="row in monedaColleccion" :value="row.id_moneda">{{row.moneda}}</option>
                </select>
                <label>Monto</label>
                <input class="form-control mb-3" min="0" type="number" placeholder="0" v-model="montoin">
                <label>Concepto</label>
                <select class="custom-select mb-3" v-model="concepto">
                    <option value=0 disabled>Selecciona el concepto</option>
                    <option v-for="row in conceptoColleccion" :value="row.id_concepto">{{row.concepto}}</option>
                </select>
                <label>Descripción</label>
                <input class="form-control mb-3" type="text" placeholder="Escribe una descripción" v-model="descripcion">
                <label>Cliente</label>
                <input class="form-control" type="text" placeholder="Ingresa al cliente" v-model="cliente">
            </form>
            <div class="card-footer text-muted text-right" style="background:none;border:none" v-if="movout">
                <div>
                    <!-- <button type="button" class="btn btn-secondary" style="background-color:#001E31;color:white" @click="verTabla();"><i class="fa-solid fa-left-long"></i></button> -->
                    <button type="button" class="btn btn-secondary text-white" @click="limpiar();"><i class="fa-solid fa-broom"></i></button>
                    <button type="button" class="btn btn-danger text-white" @click="restarSaldoDolar();"><i class="fa-solid fa-file-invoice-dollar"></i> Retirar</button>
                </div>
            </div>
        </div>

    </div>
    <br>

    <button type="button" class="btn btn-outline-info float-right" @click="back();" v-if="showmoves"><i class="fa-solid fa-eye"></i> Ver Movimientos</button>

    <nav aria-label="Page navigation example" v-if="showmoves">
        <ul class="pagination">
            <li style="margin-right:2%">
                <select class="custom-select mb-2 mr-sm-2 mb-sm-0" v-model="numByPag" @change="paginator(1)" style="cursor: pointer;">
                    <option value=5>5</option>
                    <option value=10>10</option>
                    <option value=15>15</option>
                    <option value=20>20</option>
                </select>
            </li>
            <li v-for="li in paginas" class="page-item">
                <a class="page-link" @click="paginator(li.element)" style="cursor: pointer;color:#000;height:100%;">{{ li.element }}
                    <div v-if="li.element == paginaActual"></div>
                </a>
            </li>
        </ul>
    </nav>

    <div class="card" v-if="showmoves">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr style="text-align:center">
                            <th>#</th>
                            <th>Caja Origen</th>
                            <th></th>
                            <th>Caja Destino</th>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Monto Enviado</th>
                            <th>Detalles</th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in paginaCollection" style="text-align:center">
                            <td>{{row.id_movimientos}}</td>
                            <td>{{row.origen}}</td>
                            <td><i class="fa-solid fa-arrow-right fa-lg" style="color: #0db701;"></i></td>
                            <td>{{row.destino}}</span></td>
                            <td>{{row.fecha}}</td>
                            <td>{{row.nombre_atributo}}</td>
                            <td>{{row.monto}}</span></td>
                            <td>{{row.descripcion}}</span></td>
                            <!-- <td>
                                <button style="background:none;border:none" @click="abrirModal(row.id_movimientos,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarMovimientos(row.id_movimientos);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
                                <button style="background:none;border:none" @click="abrirModalSaldo(row.id_movimientos, row.saldo);"><i class="fa-solid fa-square-plus fa-lg" style="color: #41e154;"></i></button>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- MODAL -->

    <!-- <b-modal v-model="modal" scrollable no-close-on-backdrop>
        <template slot="modal-header">
            <h5 style="color:white">Generar Movimiento</h5>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close" style="color:#f50f0f">
                <span aria-hidden="true">×</span>
            </button>
        </template>
        <b-container fluid>
            <div>
                <b-form>
                    <b-form-group class="mb-10 mt-10" label="Ingresa el monto:">
                        <b-form-input type="number" v-model="saldo" placeholder="Ingresa el saldo" class="mb-3" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Detalle del movimiento:">
                        <b-form-input type="text" v-model="detalle" placeholder="Escribe la descripción" class="mb-3" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Empresa:">
                        <b-form-select v-model="id_empresa" class="mb-3" @change="obtenerSucursal();">
                            <b-form-select-option value='' disabled>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in empresaColleccion" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Sucursal:">
                        <b-form-select v-model="id_sucursal" class="mb-3" @change="obtenerCaja();">
                            <b-form-select-option value='' disabled>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in sucursalColleccion" v-bind:key="row.id_sucursal" :value="row.id_sucursal">{{row.nombre_sucursal}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Selecciona la Caja:">
                        <b-form-select v-model="id_caja" class="mb-3">
                            <b-form-select-option value='' disabled>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in cajaColleccion" v-bind:key="row.id_caja" :value="row.id_caja">{{row.nombre_caja}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarMovimientos();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarMovimientos();"><i class="fa-regular fa-pen-to-square"></i></b-button> -->
    <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
    <!-- </div>
    </b-modal> -->

    <!-- Agregar Saldo -->

    <!-- <b-modal v-model="saldoModal" no-close-on-backdrop>
        <template slot="modal-header">
            <h5 style="color:white">Agregar Saldo</h5>
            <button type="button" class="close" @click="cerrarModalSaldo()" aria-label="Close" style="color:#f50f0f">
                <span aria-hidden="true">×</span>
            </button>
        </template>
        <b-container fluid>
            <div>
                <b-form>
                    <b-form-group class="mb-10 mt-10" label="Ingresa el saldo que desea añadir:">
                        <b-form-input type="number" v-model="saldoadd" placeholder="Ingresa el saldo" require></b-form-input>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button variant="success" class="float-right ml-2" @click="editarSaldo();"><i class="fa-solid fa-square-plus"></i></b-button>
        </div>
    </b-modal> -->

    <!-- modal cargando -->
    <div v-if="charge" class="modal-mask" style="height:50%">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #001E31;">
                <div class="modal-body" style="background-color: #001E31;border:none">
                    <img width="100%" src="../images/loading-48.gif">
                </div>
            </div>
        </div>
    </div>


</div>

<script type="text/javascript" src="../js/movimientos/movimientos.js"></script>

<?php
include '../footer.php';
?>