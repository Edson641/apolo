var cajadep = new Vue({

    el: '#cajadep',

    data: {


        // caja
        cajaDColleccion: [],

        // Controlador
        path: '../controller/c_caja_departamento.php',
        id_caja_departamento:'',

        // Modal
        modal: false,
        title: '',
        nombre_caja_departamento: '',
        saldo: '',
        id_empresa: '',
        id_moneda: '',
        esactivo: '',
        id_caja: '',
        id_departamento:'',

        // combo

        monedaColleccion: [],
        empresaColleccion: [],
        departamentoColleccion: [],
        sucursalColleccion: [],
        id_sucursal: '',
        id_departamento: '',

        // cargando 
        charge: false,

        // saldo
        saldoModal: false,
        saldoadd: 0,
        saldoActual: '',

        //paginador
        numByPag: 10,
        paginas: [],
        paginaCollection: [],
        paginaActual: 1,


    },


    methods: {

        // Metodos al controlador

        obtenerCajaD() {
            this.charge = true;
            let t = this;
            const cjid = document.getElementById('id_caja');
            const empid = document.getElementById('id_empresa')
            const suid = document.getElementById('id_sucursal');
            const parametros = {
                accion: 'obtenerCajaDepartamento',
                id_caja: cjid.value,
                id_empresa: empid.value,
                id_sucursal: suid.value,
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.cajaDColleccion = response.data;
                for (let i = 0; i < t.cajaDColleccion.length; i++) {
                     t.cajaDColleccion[i].saldo = (Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(t.cajaDColleccion[i].saldo));
                     t.paginaCollection = response.data;
                     t.paginator(1);
                    
                }
                t.charge = false;

            }).catch(function (error) {
            })
        },

        insertarCajaD() {
            this.charge = true;
            let t = this

            const caj = document.getElementById('id_caja');
            if (this.nombre_caja_departamento != '' && this.id_departamento != '') {
                const parametros = {
                    accion: 'insertarCajaDepartamento',
                    nombre_caja_departamento: this.nombre_caja_departamento,
                    id_empresa: this.id_empresa,
                    id_sucursal: this.id_sucursal,
                    id_departamento: this.id_departamento,
                    id_caja: caj.value,
                    esactivo: this.esactivo,
                }
                console.log(parametros);
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        t.charge = false;
                        swal.fire(
                            'Datos Insertados!',
                            'Se ha creado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerCajaD();
                    } else {
                        t.charge = false;
                        swal.fire(
                            'Error!',
                            'No se ha podido crear el registro',
                            'error')
                    }

                }).catch(function (error) {
                })
            } else {
                t.charge = false;

                swal.fire(
                    'Campos Vacíos!',
                    'Favor de llenar los campos',
                    'info'
                )
            }
        },

        editarCajaD() {
            let t = this;

            if (this.nombre_caja != '') {
                const parametros = {
                    accion: 'editarCajaD',
                    id: this.id_caja_departamento,
                    esactivo: this.esactivo,
                    nombre_caja_departamento: this.nombre_caja_departamento,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        swal.fire(
                            'Datos Editados!',
                            'Se ha editado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerCajaD();
                    } else {
                        swal.fire(
                            'Error!',
                            'No se ha podido editar el registro',
                            'error')
                    }

                }).catch(function (error) {
                })
            } else {
                swal.fire(
                    'Campos Vacios!',
                    'Favor de llenar los campos',
                    'info'
                )
            }

        },

        eliminarCajaD(idcjd) {

            let t = this;

            Swal.fire({
                title: "Eliminar Registro",
                text: "¿Estas seguro que quieres elminiar este registro?",
                icon: 'warning',
                width: '60%',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, elminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value == true) {
                    const parametros = {
                        accion: 'eliminarCajaDepartamento',
                        id: idcjd,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerCajaD();
                        } else {
                            swal.fire(
                                'Registro no elminado!',
                                'No se ha podido eliminar el registro',
                                'error'
                            )
                        }
                    });
                }
            })


        },


        // seccion modal
        abrirModal(id, name, row = []) {
            if (name == 'Agregar') {
                this.title = 'Agregar';
                this.modal = true;
                this.esactivo = true;
                this.obtenerEmpresaC();
                this.obtenerSucursal();
                this.obtenerDepartamento();
                this.id_empresa = document.getElementById('id_empresa').value;
                this.id_sucursal = document.getElementById('id_sucursal').value;

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.id_caja_departamento = id;
                this.nombre_caja_departamento = row.nombre_caja_departamento;
                this.saldo = row.saldo;
                this.id_empresa = row.id_empresa;
                this.id_departamento = row.id_departamento;
                this.obtenerEmpresaC();
                if (row.esactivo == 'SI') {
                    this.esactivo = true;
                }
                else {
                    this.esactivo = false;
                }
            }

        },

        cerrarModal() {
            this.modal = false;
            this.nombre_caja_departamento = '';
            this.id_departamento = '';
            this.id_empresa = '';
            this.esactivo = false;
        },

        // combos
        obtenerEmpresaC() {
            let t = this;
            const empresaid = document.getElementById('id_empresa');
            const parametros = {
                accion: 'obtenerEmpresaC',
                id_empresa: empresaid.value,
            }
            const response = axios.post('../controller/c_empresa.php', parametros).then(function (response) {
                t.empresaColleccion = response.data;
                this.idem = empresaid.value;
            }).catch(function (error) {
            })
        },

        obtenerSucursal() {
            let t = this;
            const empresaid = document.getElementById('id_empresa');
            const parametros = {
                accion: 'obtenerSucursalEmpresa',
                id_empresa: empresaid.value,
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalColleccion = response.data;
            });
        },

        obtenerDepartamento() {
            let t = this;
            const sucursalid = document.getElementById('id_sucursal');
            const parametros = {
                accion: 'obtenerDepartamentoSucursal',
                id_sucursal: sucursalid.value,

            }
            const response = axios.post('../controller/c_departamento.php', parametros).then(function (response) {
                t.departamentoColleccion = response.data;
            }).catch(function (error) {
            })
        },

        // Saldo

        abrirModalSaldo(id, sa) {
            this.saldoModal = true;
            this.saldoActual = sa;
            this.id_caja2 = id;
        },

        cerrarModalSaldo() {
            this.saldoModal = false;
            this.saldoadd = 0;
        },

        sumar() {
            let resultado;
            if(this.saldoActual == null || this.saldoActual == 'null'){
                this.saldoActual = 0
                resultado = parseInt(this.saldoActual) + parseInt(this.saldoadd);
                // console.log('hola soy 0');
                return resultado;
            }else{
                var salde = Number(this.saldoActual.replace(/[^0-9.-]+/g,""));
                resultado = salde + parseInt(this.saldoadd);
                // console.log('no soy 0');
                return resultado;

            }
            
        },

        editarSaldo() {
            let t = this;
            const sum = t.sumar();
                if (this.saldoadd != 0) {
                const parametros = {
                    accion: 'editarSaldo',
                    id: this.id_caja2,
                    saldo: sum,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        swal.fire(
                            'Saldo Agregado!',
                            'Se ha agregado saldo!',
                            'success'
                        )
                        t.cerrarModalSaldo();
                        t.obtenerCaja();
                    } else {
                        swal.fire(
                            'Error!',
                            'No se ha podido agregar el saldo',
                            'error')
                    }
                }).catch(function (error) {
                })
            } else {
                swal.fire(
                    'Campos Vacios!',
                    'Favor de llenar los campos',
                    'info'
                )
            }

        },

          // paginador


          paginator(i) {
            let cantidad_pages = Math.ceil(this.cajaDColleccion.length / this.numByPag);
            this.paginas = [];
            if (i === '<') {
                if (this.paginaActual == 1) { i = 1; } else { i = this.paginaActual - 1; }
            } else if (i === '>') {
                if (this.paginaActual == cantidad_pages) { i = cantidad_pages; } else { i = this.paginaActual + 1; }
            } else { this.paginaActual = i; }
            this.paginaActual = i;
            this.paginas.push({ 'element': '<' });
            for (let indexI = 0; indexI < cantidad_pages; indexI++) {
                this.paginas.push({ 'element': (indexI + 1) });
                if (indexI == (i - 1)) {
                    this.paginaCollection = [];
                    let inicio = (i == 1 ? 0 : ((i - 1) * parseInt(this.numByPag)));
                    inicio = parseInt(inicio);
                    let fin = (cantidad_pages == i ? this.cajaDColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.cajaDColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }

        // loading (){
        //     Swal.fire({
        //         // text: 'Cargando. . .',
        //         imageUrl: '../images/loading-48.gif',
        //         imageWidth: 400,
        //         imageHeight: 400,
        //         background: '#001E31',
        //         showConfirmButton: false,
        //         allowOutsideClick: false,
        //         allowEscapeKey: false,
        //       })
        // }

    },


    async mounted() {

        this.obtenerCajaD();

    }





});