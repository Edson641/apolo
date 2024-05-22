var rol = new Vue({

    el: '#rol',

    data: {


        // rol
        rolColleccion: [],
        rol: '',

        // Controlador
        path: '../controller/c_rol.php',

        // Modal
        modal: false,
        title: '',
        rol: '',
        esactivo: '',
        id_rol: '',

         // modalRelacion

         modalRelacion: false,
         id_empresa: '',
         menuRelacionColleccion: [],
         id_menu: '',
         relacionCollection: [],
         relacionExist: null,
         empresaCollection:[],
         id_rol2: '',
         nrol:'',

       

    },


    methods: {

        // Metodos al controlador

        obtenerRol() {
            let t = this;
            const parametros = {
                accion: 'obtenerRol',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.rolColleccion = response.data;
            }).catch(function (error) {
            })
        },

        insertarRol() {
            let t = this

            if (this.rol != '') {
                const parametros = {
                    accion: 'insertarRol',
                    rol: this.rol,
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
                        t.obtenerRol();
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

        editarRol() {
            let t = this;

            if (this.rol != '') {
                const parametros = {
                    accion: 'editarRol',
                    id: this.id_rol,
                    rol: this.rol,
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
                        t.obtenerRol();
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

        eliminarRol(idr) {

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
                        accion: 'eliminarRol',
                        id: idr,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerRol();
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
                this.rol = row.rol;
                this.id_rol = row.id_rol;
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
            this.rol = '';
            this.esactivo = false;
        },

        // seccion modalRelacion

        obtenerEmpresa() {
            let t = this;

            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post('../controller/c_menu.php', parametros).then(function (response) {
                t.empresaCollection = response.data;
            });
        },

        obtenerMenuRelacion() {
            let t = this;

            const parametros = {
                accion: 'obtenerMenuRelacion',
                id_empresa: t.id_empresa,
            }
            const response = axios.post(t.path, parametros).then(function (response) {
                t.menuRelacionColleccion = response.data;
            });
        },

        agregarRelacion() {
            let t = this;
            let insertar = true;

            for (let i = 0; i < t.relacionCollection.length; i++) {
                const element = t.relacionCollection[i];
                if (element.id_menu == t.id_menu) {
                    insertar = false;

                }
            }
            if (insertar == true) {
                const parametros = {
                    accion: 'agregarRelacion',
                    id_rol: t.id_rol2,
                    id_menu: t.id_menu,
                    id_empresa: t.id_empresa,
                }
                const response = axios.post(t.path, parametros).then(function (response) {
                    if (response.data == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Se ha agregado la relación',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        t.id_empresa = '';
                        t.id_menu = '';
                        t.obtenerEmpresa();
                        t.listarRelacion();
                    }
                });
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Está relación ya existe!!',
                    showConfirmButton: false,
                    timer: 1000
                })
            }
        },

        listarRelacion() {
            let t = this;
            const parametros = {
                accion: 'listarRelacion',
                id: t.id_rol2,
            }
            const response = axios.post(t.path, parametros).then(function (response) {
                t.relacionCollection = response.data;
            });
        },

        eliminarRelacion(idmr) {

            let t = this;
            const parametros = {
                accion: 'eliminarRelacion',
                id: idmr,
            }
            const response = axios.post(t.path, parametros).then(function (response) {
                if (response.data == true) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Se ha eliminado está relación',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    t.id_empresa = '';
                    t.id_menu = '';
                    t.obtenerEmpresa();
                    t.listarRelacion();
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'No se ha podido eliminado está relación',
                        showConfirmButton: false,
                        timer: 1000
                    })
                }
            });
        },


        abrirModalRelacion(id, namerol) {
            this.modalRelacion = true;
            this.id_rol2 = id;
            this.nrol = namerol;
            this.obtenerEmpresa();
            this.listarRelacion();
        },

        cerrarModalRelacion() {
            this.modalRelacion = false;
            this.id_empresa ='';
            this.id_menu = '';
        },





    },

    async mounted() {

        this.obtenerRol();

    }





});