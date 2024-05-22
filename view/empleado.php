<?php
include '../header.php';
?>

<div class="container-fluid px-1" id="empleado">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5">
            <h2 class="men">Empleado</h2>

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
                            <th>Empleado</th>
                            <th>Usuario</th>
                            <th>Empresa</th>
                            <th>Sucursal</th>
                            <th>Departamento</th>
                            <th>Rol</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in paginaCollection" style="text-align:center">
                            <td>{{row.id_empleado}}</td>
                            <td>{{row.empleado}}</td>
                            <td class="status">{{row.nombre_usuario}}</span></td>
                            <td>{{row.nombre_empresa}}</td>
                            <td>{{row.nombre_sucursal}}</td>
                            <td>{{row.nombre_departamento}}</td>
                            <td>{{row.rol}}</td>
                            <td>{{row.esactivo}}</td>
                            <td>
                                <button style="background:none;border:none" @click="abrirModal(row.id_empleado,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarEmpleado(row.id_empleado);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
                                <!-- <button style="background:none;border:none" @click="abrirModalRelacion(row.id_menu);"><i class="fa-solid fa-link fa-lg" style="color: #e2f019;"></i></button> -->
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
                    <b-form-group class="mb-10 mt-10" label="Nombre:">
                        <b-form-input type="text" v-model="nombre" placeholder="Ingresa el nombre" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Apellido Paterno:">
                        <b-form-input type="text" v-model="paterno" placeholder="Ingresa el apellido paterno" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Apellido Materno:">
                        <b-form-input type="text" v-model="materno" placeholder="Ingresa el apellido materno" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Usuario:">
                        <b-form-input type="text" v-model="nombre_usuario" placeholder="Ingresa el Usuario" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Empresa:" v-if="title == 'Editar'">
                        <b-form-select v-model="id_empresa" class="mb-3" disabled>
                            <b-form-select-option value=''>Selecciona la empresa</b-form-select-option>
                            <b-form-select-option v-for="row in empresaColleccion" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Sucursal:" v-if="title == 'Editar'">
                        <b-form-select v-model="id_sucursal" class="mb-3" disabled>
                            <b-form-select-option value=''>Selecciona la sucursal</b-form-select-option>
                            <b-form-select-option v-for="row in sucursalColleccion" v-bind:key="row.id_sucursal" :value="row.id_sucursal">{{row.nombre_sucursal}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Departamento:" v-if="title == 'Editar'">
                        <b-form-select v-model="id_departamento" class="mb-3" disabled>
                            <b-form-select-option value=''>Selecciona el Departamento</b-form-select-option>
                            <b-form-select-option v-for="row in departamentoColleccion" v-bind:key="row.id_departamento" :value="row.id_departamento">{{row.nombre_departamento}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Empresa:" v-if="title == 'Agregar'">
                        <b-form-select v-model="id_empresa" class="mb-3" @change="obtenerSucursal();">
                            <b-form-select-option value='' disabled>Selecciona la empresa</b-form-select-option>
                            <b-form-select-option v-for="row in empresaColleccion" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Sucursal:" v-if="title == 'Agregar'">
                        <b-form-select v-model="id_sucursal" class="mb-3" @change="obtenerDepartamento();">
                            <b-form-select-option value='' disabled>Selecciona la sucursal</b-form-select-option>
                            <b-form-select-option v-for="row in sucursalColleccion" v-bind:key="row.id_sucursal" :value="row.id_sucursal">{{row.nombre_sucursal}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Departamento:" v-if="title == 'Agregar'">
                        <b-form-select v-model="id_departamento" class="mb-3">
                            <b-form-select-option value='' disabled>Selecciona el Departamento</b-form-select-option>
                            <b-form-select-option v-for="row in departamentoColleccion" v-bind:key="row.id_departamento" :value="row.id_departamento">{{row.nombre_departamento}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Selecciona el rol:">
                        <b-form-select v-model="id_rol" class="mb-3">
                            <b-form-select-option value='' disabled>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in rolColleccion" v-bind:key="row.id_rol" :value="row.id_rol">{{row.rol}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarEmpleado();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarEmpleado();"><i class="fa-regular fa-pen-to-square"></i></b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>
    </b-modal>

    <!-- MODAL RELACION -->
    <!-- <b-modal v-model="modalRelacion" size="lg" scrollable no-close-on-backdrop>

        <template slot="modal-header">
            <h5 style="color:white">Roles</h5>
            <button type="button" class="close" @click="cerrarModalRelacion()" aria-label="Close" style="color:#f50f0f">
                <span aria-hidden="true">×</span>
            </button>
        </template>
        <b-container fluid>
            <b-form-group class="mb-10 mt-10" label="Selecciona el rol:">
                <b-form-select v-model="id_rol" class="mb-3">
                    <b-form-select-option value='' disabled>Selecciona...</b-form-select-option>
                    <b-form-select-option v-for="row in rolColleccion" v-bind:key="row.id_rol" :value="row.id_rol">{{row.rol}}</b-form-select-option>
                </b-form-select>
            </b-form-group>
            <div>
                <div class="table-responsive">
                    <table class="tableperso">
                        <thead>
                            <tr style="color: white;">
                                <th scope="col">Empresa (Relación)</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in relacionCollection" style="color:white;">
                                <th scope="row">- {{row.nombre_empresa}}</th>
                                <th scope="row">
                                    <b-button style="background: none ;" class="float-right ml-2" @click="eliminarRelacion(row.id_menu_relacion);">
                                        <i class="fa-solid fa-delete-left" style="color: #e70d0d;"></i>
                                    </b-button>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button variant="success" class="float-right ml-2" @click="cerrarModalRelacion();">Listo</b-button> -->
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        <!-- </div>

    </b-modal> -->








</div>

<script type="text/javascript" src="../js/empleado/empleado.js"></script>

<?php
include '../footer.php';
?>