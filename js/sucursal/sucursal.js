var sucursal = new Vue({

    el: '#sucursal',

    data: {


        // sucursal
        sucursalColleccion: [],

        // Controlador
        path: '../controller/c_sucursal.php',

        // Modal
        modal: false,
        title: '',
        nombre_sucursal:'',
        esactivo: '',
        id_empresa: '',
        id_sucursal:'',
        empresaCollection:[],

          //paginador
          numByPag: 10,
          paginas: [],
          paginaCollection: [],
          paginaActual: 1,

    },


    methods: {

        // Metodos al controlador

        obtenerSucursal() {
            let t = this;
            const parametros = {
                accion: 'obtenerSucursal',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.sucursalColleccion = response.data;
                t.paginaCollection = response.data;
                t.paginator(1);
            }).catch(function (error) {
            })
        },

        insertarSucursal() {
            let t = this

            if (this.nombre_sucursal != '' && this.id_empresa != '') {
                const parametros = {
                    accion: 'insertarSucursal',
                    nombre_sucursal: this.nombre_sucursal,
                    id_empresa: this.id_empresa,
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
                        t.obtenerSucursal();
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

        editarSucursal() {
            let t = this;

            if (this.nombre_sucursal != '' && this.id_empresa != '') {
                const parametros = {
                    accion: 'editarSucursal',
                    id: this.id_sucursal,
                    nombre_sucursal: this.nombre_sucursal,
                    id_empresa: this.id_empresa,
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
                        t.obtenerSucursal();
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

        eliminarSucursal(idsuc) {

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
                        accion: 'eliminarSucursal',
                        id: idsuc,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerSucursal();
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

        obtenerEmpresa() {
            let t = this;

            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post('../controller/c_empresa.php', parametros).then(function (response) {
                t.empresaCollection = response.data;
            });
        },


        // seccion modal
        abrirModal(id, name, row = []) {
            if (name == 'Agregar') {
                this.title = 'Agregar';
                this.modal = true;
                this.obtenerEmpresa();

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.obtenerEmpresa();
                this.id_sucursal = id;
                this.nombre_sucursal = row.nombre_sucursal;
                this.id_empresa = row.id_empresa;
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
            this.nombre_sucursal = '';
            this.id_empresa = '';
            this.esactivo = false;
        },

        // paginador


        paginator(i) {
            let cantidad_pages = Math.ceil(this.sucursalColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.sucursalColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.sucursalColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }
    },

    async mounted() {

        this.obtenerSucursal();

    }





});