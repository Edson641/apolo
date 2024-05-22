<?php
include '../header.php';
?>

<div class="container-fluid px-1" id="depa">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5">
            <h2 class="men">Departamento</h2>
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
                            <th>Departamento</th>
                            <th>Sucursal</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in paginaCollection" style="text-align:center">
                            <td>{{row.id_departamento}}</td>
                            <td>{{row.nombre_departamento}}</td>
                            <td>{{row.nombre_sucursal}}</span></td>
                            <td>{{row.esactivo}}</td>
                            <td>
                                <button style="background:none;border:none" @click="abrirModal(row.id_departamento,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarDepartamento(row.id_departamento);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
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
                        <b-form-input type="text" v-model="nombre_departamento" placeholder="Ingresa el nombre" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Selecciona la Sucursal:">
                        <b-form-select v-model="id_sucursal" class="mb-3">
                            <b-form-select-option value=''>Selecciona...</b-form-select-option>
                            <b-form-select-option v-for="row in sucursalCollection" v-bind:key="row.id_sucursal" :value="row.id_sucursal">{{row.nombre_sucursal}}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarDepartamento();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarDepartamento();"><i class="fa-regular fa-pen-to-square"></i></b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>
    </b-modal>


</div>

<script type="text/javascript" src="../js/departamento/departamento.js"></script>

<?php
include '../footer.php';
?>