var caja = new Vue({

    el: '#caja',

    data: {


        // caja
        cajaColleccion: [],

        // Controlador
        path: '../controller/c_caja.php',

        // Modal
        modal: false,
        title: '',
        nombre_caja: '',
        saldo: 0,
        saldo_dolar: 0,
        id_empresa: '',
        id_moneda: '',
        esactivo: '',
        id_caja: '',
        id_sucursal:'',

        // combo

        monedaColleccion: [],
        empresaColleccion: [],
        sucursalColleccion: [],

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

        obtenerCaja() {
            this.charge = true;
            let t = this;
            const parametros = {
                accion: 'obtenerCaja',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.cajaColleccion = response.data;
                for (let i = 0; i < t.cajaColleccion.length; i++) {
                     t.cajaColleccion[i].saldo = (Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(t.cajaColleccion[i].saldo));
                     t.cajaColleccion[i].saldo_dolar = (Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(t.cajaColleccion[i].saldo_dolar));
                     t.paginaCollection = response.data;
                     t.paginator(1);
                    
                }
                t.charge = false;

            }).catch(function (error) {
            })
        },

        insertarCaja() {
            this.charge = true;
            let t = this

            if (this.nombre_caja != ''  && this.id_empresa != '') {
                const parametros = {
                    accion: 'insertarCaja',
                    nombre_caja: this.nombre_caja,
                    saldo: this.saldo,
                    saldo_dolar: this.saldo_dolar,
                    id_empresa: this.id_empresa,
                    id_sucursal: this.id_sucursal,
                    id_moneda: this.id_moneda,
                    esactivo: this.esactivo,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        t.charge = false;
                        swal.fire(
                            'Datos Insertados!',
                            'Se ha creado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerCaja();
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

        editarCaja() {
            let t = this;

            if (this.nombre_caja != '') {
                const parametros = {
                    accion: 'editarCaja',
                    id: this.id_caja,
                    esactivo: this.esactivo,
                    nombre_caja: this.nombre_caja,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        swal.fire(
                            'Datos Editados!',
                            'Se ha editado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerCaja();
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

        eliminarCaja(idcj) {

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
                        accion: 'eliminarCaja',
                        id: idcj,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerCaja();
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
                this.obtenerMoneda();
                this.obtenerEmpresa();

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.id_caja = id;
                this.nombre_caja = row.nombre_caja;
                this.saldo = row.saldo;
                this.id_empresa = row.id_empresa;
                this.id_moneda = row.id_moneda;
                this.id_sucursal = row.id_sucursal;
                this.obtenerMoneda();
                this.obtenerEmpresa();
                this.obtenerSucursal();
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
            this.nombre_caja = '';
            this.saldo = '';
            this.id_empresa = '';
            this.id_moneda = '';
            this.id_sucursal ='';
            this.esactivo = false;
        },

        // combos

        obtenerMoneda() {
            let t = this;
            const parametros = {
                accion: 'obtenerMoneda',
            }
            const response = axios.post('../controller/c_moneda.php', parametros).then(function (response) {
                t.monedaColleccion = response.data;
            }).catch(function (error) {
            })
        },

        obtenerEmpresa() {
            let t = this;
            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post('../controller/c_empresa.php', parametros).then(function (response) {
                t.empresaColleccion = response.data;
            }).catch(function (error) {
            })
        },

        obtenerSucursal() {
            let t = this;
            const parametros = {
                accion: 'obtenerSucursalEmpresa',
                id_empresa: this.id_empresa,
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalColleccion = response.data;
            });
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
                var salde =Number(this.saldoActual.replace(/[^0-9.-]+/g,""));
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
                        t.crearHistorial()
                        swal.fire(
                            'Saldo Agregado!',
                            'Se ha agregado $'+ t.saldoadd + ' de saldo',
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

        crearHistorial(s) {

            let t = this;

            let datosH = [];

            datosH.push({
                id_caja: this.id_caja2,
                monto: this.saldoadd,
                descripcion: 'Saldo agregado manualmente',
                tipo: 5,
            });

            for (let i = 0; i < datosH.length; i++) {
                const element = datosH[i];
                const parametros = {
                    accion: 'crearHistorial',
                    model: element,
                }
                const response = axios.post('../controller/c_movimientos.php', parametros).then(function (response) {
                    if (response.data == true) {
                        console.log('Historial creado');
                    } else {
                    }
                }).catch(function (error) {
                })

            }


        },

        cajaDepa(ca, su, em){
            window.location.href = '../view/caja_departamento.php?id_caja='+ca+'&id_sucursal='+su+'&id_empresa='+em;
        },


        // Paginador

        paginator(i) {
            let cantidad_pages = Math.ceil(this.cajaColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.cajaColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.cajaColleccion[index];
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

        this.obtenerCaja();

    }





});