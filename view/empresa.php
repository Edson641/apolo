<?php
include '../header.php';
?>

<div class="container-fluid px-1" id="empresa">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5">
            <h2 class="men">Empresa</h2>
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
                            <th>Empresa</th>
                            <th>Nombre Corto</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in empresaColleccion" style="text-align:center">
                            <td>{{row.id_empresa}}</td>
                            <td>{{row.nombre_empresa}}</td>
                            <td>{{row.nombre_corto}}</span></td>
                            <td>{{row.esactivo}}</td>
                            <td>
                                <button style="background:none;border:none" @click="abrirModal(row.id_empresa,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarEmpresa(row.id_empresa);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
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
                        <b-form-input type="text" v-model="nombre_empresa" placeholder="Ingresa el nombre" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Nombre Corto:">
                        <b-form-input type="text" v-model="nombre_corto" placeholder="Ingresa el nombre corto" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarEmpresa();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarEmpresa();"><i class="fa-regular fa-pen-to-square"></i></b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>
    </b-modal>


</div>

<script type="text/javascript" src="../js/empresa/empresa.js"></script>

<?php
include '../footer.php';
?>