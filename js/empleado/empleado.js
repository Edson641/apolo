var empleado = new Vue({

    el: '#empleado',

    data: {


        // rol
        empleadoColleccion: [],

        // Controlador
        path: '../controller/c_empleado.php',

        // Modal
        modal: false,
        title: '',
        nombre: '',
        paterno: '',
        materno: '',
        nombre_usuario: '',
        id_departamento: '',
        esactivo: '',

         // modalRelacion

         modalRelacion: false,
         menuRelacionColleccion: [],
         id_menu: '',
         relacionCollection: [],
         relacionExist: null,
         id_rol2: '',
         nrol:'',
         rolColleccion:[],
         id_rol:'',

         //paginador
         numByPag: 10,
         paginas: [],
         paginaCollection: [],
         paginaActual: 1,

        //  combos

        empresaColleccion:[],
        id_empresa: '',
        sucursalColleccion:[],
        id_sucursal: '',
        departamentoColleccion:[],
        id_departamento:'',

       

    },


    methods: {

        // Metodos al controlador

        obtenerEmpleado() {
            let t = this;
            const parametros = {
                accion: 'obtenerEmpleado',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.empleadoColleccion = response.data;
                t.paginaCollection = response.data;
                t.paginator(1);
            }).catch(function (error) {
            })
        },

        insertarEmpleado() {
            let t = this

            if (this.nombre != '' && this.paterno != '' && this.materno != '' && this.nombre_usuario != '' && this.id_empresa != '' && this.id_sucursal != '' && this.id_departamento != '' && this.id_rol != '') {
                const parametros = {
                    accion: 'insertarEmpleado',
                    nombre: this.nombre,
                    paterno: this.paterno,
                    materno: this.materno,
                    nombre_usuario: this.nombre_usuario,
                    id_empresa: this.id_empresa,
                    id_sucursal: this.id_sucursal,
                    id_departamento: this.id_departamento,
                    id_rol: this.id_rol,
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
                        t.obtenerEmpleado();
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

        editarEmpleado() {
            let t = this;

            if (this.nombre != '' && this.paterno != '' && this.materno != '' && this.nombre_usuario != '' && this.id_empresa != '' && this.id_sucursal != '' && this.id_departamento != '') {
                const parametros = {
                    accion: 'editarEmpleado',
                    id: this.id_empleado,
                    nombre: this.nombre,
                    paterno: this.paterno,
                    materno: this.materno,
                    nombre_usuario: this.nombre_usuario,
                    id_empresa: this.id_empresa,
                    id_sucursal: this.id_sucursal,
                    id_departamento: this.id_departamento,
                    id_rol: this.id_rol,
                    esactivo: this.esactivo,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        console.log(response);
                        swal.fire(
                            'Datos Editados!',
                            'Se ha editado el registro con exito!',
                            'success'
                        )
                        t.cerrarModal();
                        t.obtenerEmpleado();
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

        eliminarEmpleado(idemp) {

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
                        accion: 'eliminarEmpleado',
                        id: idemp,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerEmpleado();
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
                this.obtenerEmpresa();
                this.obtenerRol();
                this.esactivo = true;

            } else {
                this.title = 'Editar';
                this.modal = true;
                this.id_empleado = id;
                this.nombre = row.nombre;
                this.paterno = row.ap_paterno;
                this.materno = row.ap_materno;
                this.nombre_usuario = row.nombre_usuario;
                this.id_empresa = row.id_empresa;
                this.id_sucursal = row.id_sucursal;
                this.id_departamento = row.id_departamento;
                this.id_rol = row.id_rol;
                this.obtenerEmpresa();
                this.obtenerSucursal();
                this.obtenerDepartamento();
                this.obtenerRol();
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
            this.nombre = '';
            this.paterno = '';
            this.materno = '';
            this.nombre_usuario = '';
            this.id_empresa = '';
            this.id_sucursal = '';
            this.id_departamento = '';
            this.id_rol = '';
            this.esactivo = false;
        },

        // seccion modalRelacion

      

        obtenerMenuRelacion() {
            let t = this;

            const parametros = {
                accion: 'obtenerMenuRelacion',
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
            this.obtenerRol();
            this.listarRelacion();
        },

        cerrarModalRelacion() {
            this.modalRelacion = false;
            this.id_empresa ='';
            this.id_menu = '';
        },

        // combos

        obtenerEmpresa() {
            let t = this;

            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post('../controller/c_empresa.php', parametros).then(function (response) {
                t.empresaColleccion = response.data;
            });
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

        obtenerDepartamento() {
            let t = this;
            const parametros = {
                accion: 'obtenerDepartamentoSucursal',
                id_sucursal: this.id_sucursal,

            }
            const response = axios.post('../controller/c_departamento.php', parametros).then(function (response) {
                t.departamentoColleccion = response.data;
            }).catch(function (error) {
            })
        },

        obtenerRol() {
            let t = this;
            const parametros = {
                accion: 'obtenerRol',
            }
            const response = axios.post('../controller/c_rol.php', parametros).then(function (response) {
                t.rolColleccion = response.data;
            }).catch(function (error) {
            })
        },

        // paginador

        paginator(i) {
            let cantidad_pages = Math.ceil(this.empleadoColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.empleadoColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.empleadoColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }





    },

    async mounted() {

        this.obtenerEmpleado();

    }





});