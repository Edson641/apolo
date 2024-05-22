var depa = new Vue({

    el: '#depa',

    data: {


        // departamento
        departamentoColleccion: [],

        // Controlador
        path: '../controller/c_departamento.php',

        // Modal
        modal: false,
        title: '',
        nombre_departamento:'',
        esactivo: '',
        id_sucursal:'',
        sucursalCollection:[],

          //paginador
          numByPag: 10,
          paginas: [],
          paginaCollection: [],
          paginaActual: 1,

    },


    methods: {

        // Metodos al controlador

        obtenerDepartamento() {
            let t = this;
            const parametros = {
                accion: 'obtenerDepartamento',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.departamentoColleccion = response.data;
                t.paginaCollection = response.data;
                t.paginator(1);
            }).catch(function (error) {
            })
        },

        insertarDepartamento() {
            let t = this

            if (this.nombre_departamento != '' && this.id_sucursal != '') {
                const parametros = {
                    accion: 'insertarDepartamento',
                    nombre_departamento: this.nombre_departamento,
                    id_sucursal: this.id_sucursal,
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
                        t.obtenerDepartamento();
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

        editarDepartamento() {
            let t = this;

            if (this.nombre_departamento != '' && this.id_sucursal != '') {
                const parametros = {
                    accion: 'editarDepartamento',
                    id: this.id_departamento,
                    nombre_departamento: this.nombre_departamento,
                    id_sucursal: this.id_sucursal,
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
                        t.obtenerDepartamento();
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

        eliminarDepartamento(iddep) {

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
                        accion: 'eliminarDepartamento',
                        id: iddep,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerDepartamento();
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

        obtenerSucursal() {
            let t = this;

            const parametros = {
                accion: 'obtenerSucursal',
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalCollection = response.data;
            });
        },


        // seccion modal
        abrirModal(id, name, row = []) {
            if (name == 'Agregar') {
                this.title = 'Agregar';
                this.modal = true;
                this.esactivo = true;
                this.obtenerSucursal();

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.obtenerSucursal();
                this.id_departamento = id;
                this.nombre_departamento = row.nombre_departamento;
                this.id_sucursal = row.id_sucursal;
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
            this.nombre_departamento = '';
            this.id_sucursal = '';
            this.esactivo = false;
        },

        // paginador


        paginator(i) {
            let cantidad_pages = Math.ceil(this.departamentoColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.departamentoColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.departamentoColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }
    },

    async mounted() {

        this.obtenerDepartamento();

    }





});