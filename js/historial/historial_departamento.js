var historial = new Vue({

    el: '#historial-departamento',

    data: {


        // historial
        historialColleccion: [],
        id_empresa:'',
        id_caja:'',
        id_sucursal:'',

        // Controlador
        path: '../controller/c_historial.php',

        // Modal
        modal: false,
        title: '',
        nombre_historial:'',
        nombre_corto:'',
        esactivo: '',
        id_historial: '',

        //paginador
        numByPag: 10,
        paginas: [],
        paginaCollection: [],
        paginaActual: 1,


    },


    methods: {

        // Metodos al controlador

        obtenerHistorial() {
            const idcaja = document.getElementById('id_caja_departamento');
            let t = this;
            const parametros = {
                accion: 'obtenerHistorialD',
                id_caja: idcaja.value,
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.historialColleccion = response.data;
                t.paginaCollection = response.data;
                t.paginator(1);
            }).catch(function (error) {
            })
        },
        

        insertarHistorial() {
            let t = this

            if (this.nombre_empresa != '' && this.nombre_corto != '') {
                const parametros = {
                    accion: 'insertarHistorial',
                    nombre_empresa: this.nombre_empresa,
                    nombre_corto: this.nombre_corto,
                    esactivo: this.esactivo,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        swal.fire(
                            'Datos Insertados!',
                            'Se ha creado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerHistorial();
                    } else {
                        swal.fire(
                            'Error!',
                            'No se ha podido crear el registro',
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

        editarHistorial() {
            let t = this;

            if (this.nombre_empresa != '' && this.nombre_corto != '') {
                const parametros = {
                    accion: 'editarHistorial',
                    id: this.id_empresa,
                    nombre_empresa: this.nombre_empresa,
                    nombre_corto: this.nombre_corto,
                    esactivo: this.esactivo,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        swal.fire(
                            'Datos Editados!',
                            'Se ha editado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerHistorial();
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

        eliminarHistorial(idemp) {

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
                        accion: 'eliminarHistorial',
                        id: idemp,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerHistorial();
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

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.id_empresa = id;
                this.nombre_empresa = row.nombre_empresa;
                this.nombre_corto = row.nombre_corto;
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
            this.nombre_empresa = '';
            this.nombre_corto = '';
            this.esactivo = false;
        },

        paginator(i) {
            let cantidad_pages = Math.ceil(this.historialColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.historialColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.historialColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }
    },

    async mounted() {
        const empresa = document.getElementById('id_empresa');
        const sucursal = document.getElementById('id_sucursal');
        const caja = document.getElementById('id_caja');
        this.id_empresa = empresa;
        this.id_sucursal = sucursal;
        this.id_caja = caja;
        this.obtenerHistorial();

    }





});