<?php
include '../header.php';
if (isset($_GET['id_caja'])) {
    echo '<input id="id_caja" value="' . $_GET['id_caja'] . '" style="display:none" >';
}
?>

<div class="container-fluid px-1" id="historial">
    <div class="row justify-content-center">

        <div class="col-md-6 text-center mb-5">
            <h2 class="men">Historial</h2>
        </div>
    </div>
    <br>


    <div>
        <a href="../view/caja.php"><button type="button" class="btn btn-outline-primary"><i class="fa-solid fa-angles-left"></i></button></a>
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


    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr style="text-align:center">
                            <th></th>
                            <th>#</th>
                            <th>Caja</th>
                            <th>Monto</th>
                            <th>Tipo</th>
                            <th>Fecha Movimiento</th>
                            <th>Descripción</th>
                            <th>Concepto</th>
                            <th>Ticket</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="row in paginaCollection" style="text-align:center">
                            <td v-if="row.nombre_atributo == 'Salida'"><i class="fa-solid fa-circle-minus fa-lg" style="color: #e2222b;"></i></td>
                            <td v-else><i class="fa-solid fa-circle-plus fa-lg" style="color: #55f236;"></i></td>
                            <td>{{row.id_historial}}</td>
                            <td>{{row.nombre_caja}}</td>
                            <td>{{row.monto}} ({{row.moneda}})</td>
                            <td>{{row.nombre_atributo}}</td>
                            <td>{{row.creado}}</td>
                            <td>{{row.descripcion}}</td>
                            <td>{{row.concepto}}</td>
                            <td><button data-toggle="modal" class="btn btn-outline-info" @click="verTicket(row.id_historial);"><i class="fa-solid fa-receipt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <b-modal v-model="ticket" scrollable no-close-on-backdrop size="xl">
        <transition name="model">
            <div class="modal-mask">
                <div class="modal-dialog" style="max-width: 90%; max-height: 50%" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Archivo</h4>
                            <button type="button" class="close" @click="cerrarTicket();"><span>&times;</span></button>
                        </div>

                        <div class="modal-body">
                            <div class="card-body">
                                <div style="text-align: center;">
                                    <iframe v-bind:src="`${ modalPDFContenido }`" style="width:100%;height:550px;" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-warning" @click="excelexistencia">Exportar Excel</button> -->
                            <button type="button" class="btn btn-danger" @click="cerrarTicket();">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </b-modal>

</div>


<script type="text/javascript" src="../js/historial/historial.js"></script>

<?php
include '../footer.php';
?>