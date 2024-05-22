<?php
include '../header.php';
?>

<div class="container-fluid px-1" id="moneda">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5">
            <h2 class="men">Moneda</h2>
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
                            <th>Nombre</th>
                            <th>Moneda</th>
                            <th>Activo</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in monedaColleccion" style="text-align:center">
                            <td>{{row.id_moneda}}</td>
                            <td>{{row.nombre_moneda}}</td>
                            <td>{{row.moneda}}</span></td>
                            <td>{{row.esactivo}}</td>
                            <td>
                                <button style="background:none;border:none" @click="abrirModal(row.id_moneda,'Editar', row);"><i class="fa-solid fa-square-pen fa-lg" style="color: #3976c6;"></i></button>
                                <button style="background:none;border:none" @click="eliminarMoneda(row.id_moneda);"><i class="fa-solid fa-trash fa-lg" style="color: #f50f0f;"></i></button>
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
                        <b-form-input type="text" v-model="nombre_moneda" placeholder="Ingresa el nombre" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10" label="Ingresa la Moneda:">
                        <b-form-input type="text" v-model="moneda" placeholder="Ingresa la moneda" require></b-form-input>
                    </b-form-group>
                    <b-form-group class="mb-10 mt-10">
                        <b-form-checkbox v-model="esactivo"><label>Activo</label></b-form-checkbox>
                    </b-form-group>
                </b-form>
            </div>
        </b-container>
        <div slot="modal-footer" class="w-100">
            <b-button v-if="title == 'Agregar'" variant="success" class="float-right ml-2" @click="insertarMoneda();"><i class="fa-solid fa-floppy-disk"></i></b-button>
            <b-button v-else variant="primary" class="float-right ml-2" @click="editarMoneda();"><i class="fa-regular fa-pen-to-square"></i></b-button>
            <!-- <b-button variant="danger" class="float-right" @click=""></button> -->
        </div>
    </b-modal>


</div>

<script type="text/javascript" src="../js/moneda/moneda.js"></script>

<?php
include '../footer.php';
?>