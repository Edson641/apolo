<?php include '../header.php'; ?>


<div class="container-fluid px-1" id="rol">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5">
            <h2 class="men">Rol</h2>

        </div>
    </div>
    <br>

    <!-- <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-caret-left"></i></a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-caret-right"></i></a></li>
        </ul>
    </nav> -->
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
                            <th>Rol</th>
                            <th>Es activo</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in rolColleccion" style="text-align:center">
                            <td class="status">{{row.id_rol}}</span></td>
                            <td>{{row.rol}}</td>
                            <td>{{row.esactivo}}</td>
                            <td>
                                <button style="background:none;border:none" @click="abrirModal(row.id_rol,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarRol(row.id_rol);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
                                <button style="background:none;border:none" @click="abrirModalRelacion(row.id_rol, row.rol);"><i class="fa-solid fa-link fa-lg" style="color: #e2f019;"></i></button>
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
                    <b-form-group class="mb-10 mt-10" label="Rol:">
                        <b-form-input type="text" v-model="rol" placeholder="Ingresa el Rol" require></b-form-input>
                    </b-form-group>

                    <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarRol();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarRol();"><i class="fa-regular fa-pen-to-square"></i></b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>
    </b-modal>

    <!-- MODAL RELACION -->
    <b-modal v-model="modalRelacion" size="lg" scrollable no-close-on-backdrop>

        <template slot="modal-header">
            <h5 style="color:white">Relación Menú - Rol: {{nrol}}</h5>
            <button type="button" class="close" @click="cerrarModalRelacion()" aria-label="Close" style="color:#f50f0f">
                <span aria-hidden="true">×</span>
            </button>
        </template>
        <b-container fluid>
            <b-form-group class="mb-10 mt-10" label="Selecciona la empresa:">
                <b-form-select v-model="id_empresa" class="mb-3" @change="obtenerMenuRelacion();">
                    <b-form-select-option value=''>Selecciona...</b-form-select-option>
                    <b-form-select-option v-for="row in empresaCollection" v-bind:key="row.id_empresa" :value="row.id_empresa">{{row.nombre_empresa}}</b-form-select-option>
                </b-form-select>
            </b-form-group>
            <b-form-group class="mb-10 mt-10" label="Selecciona las relaciones:">
                <b-form-select v-model="id_menu" class="mb-3" @change="agregarRelacion();">
                    <b-form-select-option value=''>Selecciona...</b-form-select-option>
                    <b-form-select-option v-for="row in menuRelacionColleccion" v-bind:key="row.id_menu" :value="row.id_menu">{{row.nombre}}</b-form-select-option>
                </b-form-select>
            </b-form-group>
            <div>
                <div class="table-responsive">
                    <table class="tableperso">
                        <thead>
                            <tr style="color: white;">
                                <th scope="col" style="text-align: center;">#</th>
                                <th scope="col" style="text-align: center;">Menú - Rol</th>
                                <th scope="col" style="text-align: center;">Empresa</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in relacionCollection" style="color:white;">
                                <th scope="col" style="text-align: center;">{{row.id_menu_rol}}</th>
                                <th scope="row" style="text-align: center;">{{row.nombre}}</th>
                                <th scope="row" style="text-align: center;">{{row.nombre_empresa}}</th>
                                <th scope="row">
                                    <b-button style="background: none ;" class="float-right ml-2" @click="eliminarRelacion(row.id_menu_rol);">
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
            <b-button variant="success" class="float-right ml-2" @click="cerrarModalRelacion();">Listo</b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>

    </b-modal>
</div>

<script type="text/javascript" src="../js/rol/rol.js"></script>



<?php include '../footer.php'; ?>