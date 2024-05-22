var empresa = new Vue({

    el: '#empresa',

    data: {


        // empresa
        empresaColleccion: [],

        // Controlador
        path: '../controller/c_empresa.php',

        // Modal
        modal: false,
        title: '',
        nombre_empresa:'',
        nombre_corto:'',
        esactivo: '',
        id_empresa: '',

    },


    methods: {

        // Metodos al controlador

        obtenerEmpresa() {
            let t = this;
            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.empresaColleccion = response.data;
            }).catch(function (error) {
            })
        },

        insertarEmpresa() {
            let t = this

            if (this.nombre_empresa != '' && this.nombre_corto != '') {
                const parametros = {
                    accion: 'insertarEmpresa',
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
                        t.obtenerEmpresa();
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

        editarEmpresa() {
            let t = this;

            if (this.nombre_empresa != '' && this.nombre_corto != '') {
                const parametros = {
                    accion: 'editarEmpresa',
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
                        t.obtenerEmpresa();
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

        eliminarEmpresa(idemp) {

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
                        accion: 'eliminarEmpresa',
                        id: idemp,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerEmpresa();
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
    },

    async mounted() {

        this.obtenerEmpresa();

    }





});