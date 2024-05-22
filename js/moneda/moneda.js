var moneda = new Vue({

    el: '#moneda',

    data: {


        // moneda
        monedaColleccion: [],

        // Controlador
        path: '../controller/c_moneda.php',

        // Modal
        modal: false,
        title: '',
        nombre_moneda:'',
        moneda:'',
        esactivo: '',
        id_moneda: '',

    },


    methods: {

        // Metodos al controlador

        obtenerMoneda() {
            let t = this;
            const parametros = {
                accion: 'obtenerMoneda',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.monedaColleccion = response.data;
            }).catch(function (error) {
            })
        },

        insertarMoneda() {
            let t = this

            if (this.nombre_moneda != '' && this.moneda != '') {
                const parametros = {
                    accion: 'insertarMoneda',
                    nombre_moneda: this.nombre_moneda,
                    moneda: this.moneda,
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
                        t.obtenerMoneda();
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
                    'Campos Vacíos!',
                    'Favor de llenar los campos',
                    'info'
                )
            }
        },

        editarMoneda() {
            let t = this;

            if (this.nombre_moneda != '' && this.moneda != '') {
                const parametros = {
                    accion: 'editarMoneda',
                    id: this.id_moneda,
                    nombre_moneda: this.nombre_moneda,
                    moneda: this.moneda,
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
                        t.obtenerMoneda();
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

        eliminarMoneda(idmon) {

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
                        accion: 'eliminarMoneda',
                        id: idmon,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerMoneda();
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

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.id_moneda = id;
                this.nombre_moneda = row.nombre_moneda;
                this.moneda = row.moneda;
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
            this.nombre_moneda = '';
            this.moneda = '';
            this.esactivo = false;
        },
    },

    async mounted() {

        this.obtenerMoneda();

    }





});