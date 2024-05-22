<?php
include '../header.php';
?>

<div class="container-fluid px-1" id="caja">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5 mt-3">
            <h2 class="men" style="width: 70%;">Caja Sucursal</h2>
        </div>
    </div>
    <br>

    <nav aria-label="Page navigation example">
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
    <div>
        <button type="button" class="btn btn-outline-success" @click="abrirModal('', 'Agregar','');"><i class="fa-solid fa-square-plus"></i> Agregar</button>
        <!-- <button type="button" class="btn btn-outline-primary" @click="info();"><i class="fa-solid fa-circle-info"></i></button> -->
    </div>
    <br>


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr style="text-align:center">
                            <th>#</th>
                            <th>Caja</th>
                            <th>Saldo (MXN)</th>
                            <th>Saldo (USD)</th>
                            <th>Sucursal</th>
                            <th>Ultimo Movimiento</th>
                            <th>Historial</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in paginaCollection" style="text-align:center">
                            <td>{{row.id_caja}}</td>
                            <td>{{row.nombre_caja}}</td>
                            <td style="font-weight: 800;">{{row.saldo}}</span></td>
                            <td style="font-weight: 800;">{{row.saldo_dolar}}</span></td>
                            <td>{{row.nombre_sucursal}}</span></td>
                            <td>{{row.historico_descripcion}}</span></td>
                            <td><a :href="'../view/historial.php?id_caja=' + row.id_caja"><i class="fa-solid fa-clock-rotate-left fa-lg" style="color: #6500a8;"></i> Historial</a></td>
                            <td>{{row.esactivo}}</td>
                            <td>
                                <!-- <button style="background:none;border:none" @click="cajaDepa(row.id_caja, row.id_sucursal, row.id_empresa);"><i class="fa-solid fa-box-open" style="color: #e69305;"></i></button> -->
                                <button style="background:none;border:none" @click="abrirModal(row.id_caja,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarCaja(row.id_caja);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
                                <!-- <button style="background:none;border:none" @click="abrirModalSaldo(row.id_caja, row.saldo);"><i class="fa-solid fa-square-plus fa-lg" style="color: #41e154;"></i></button> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!-- MODAL -->

    <b-modal v-model="modal" scrollable no-close-on-backdrop>
        <template slot="modal-header">
            <h5 style="color:white">{{title}}</h5>
            <button type="button" class="close" @click="cerrarModal()" aria-label="Close" style="color:#f50f0f">
                <span aria-hidden="true">×</span>
            </button>
        </template>
        <b-container fluid>
            <div>
                <b-form>
                    <b-form-group class="mb-10 mt-10" label="Nombre de la Caja:">
                        <b-form-input type="text" v-model="nombre_caja" placeholder="Ingresa el nombre" require></b-form-input>
                    </b-form-group>
                    <!-- <b-form-group class="mb-10 mt-10" label="Ingresa el saldo con el que contará la caja:" v-if="title == 'Agregar'">
                        <b-form-input type="number" v-model="saldo" placeholder="Ingresa el saldo" require></b-form-input>
                    </b-form-group> -->
                    <b-form-group class="mb-10 mt-10" label="Selecciona la Empresa:" v-if="title == 'Agregar'">
                        <b-form-select v-model="id_empresa" @change="obtenerSucursal();">
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in empresaColleccion" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Sucursal:" v-if="title == 'Agregar'">
                        <b-form-select v-model="id_sucursal">
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in sucursalColleccion" v-bind:key="row.id_sucursal" :value="row.id_sucursal">{{row.nombre_sucursal}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <!-- <b-form-group class="mb-10 mt-10" label="Selecciona la Moneda:" v-if="title == 'Agregar'">
                        <b-form-select v-model="id_moneda">
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in monedaColleccion" v-bind:key="row.id_moneda" :value="row.id_moneda">{{row.moneda}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group> -->
                    <b-form-group class="mb-10 mt-10" label="Empresa:" v-if="title == 'Editar'">
                        <b-form-select v-model="id_empresa" disabled>
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in empresaColleccion" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Sucursal:" v-if="title == 'Editar'">
                        <b-form-select v-model="id_sucursal" disabled>
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in sucursalColleccion" v-bind:key="row.id_sucursal" :value="row.id_sucursal" disabled>{{row.nombre_sucursal}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <!-- <b-form-group class="mb-10 mt-10" label="Moneda:" v-if="title == 'Editar'">
                        <b-form-select v-model="id_moneda" disabled>
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in monedaColleccion" v-bind:key="row.id_moneda" :value="row.id_moneda">{{row.moneda}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group> -->
                    <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarCaja();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarCaja();"><i class="fa-regular fa-pen-to-square"></i></b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>
    </b-modal>

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

<script type="text/javascript" src="../js/caja/caja.js"></script>

<?php
include '../footer.php';
?>