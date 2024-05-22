var menu = new Vue({

    el: '#menu',

    data: {


        // menu
        menuColleccion: [],
        nombre: '',

        // Controlador
        path: '../controller/c_menu.php',

        // Modal
        modal: false,
        title: '',
        nombre: '',
        orden: '',
        esmenu: '',
        esactivo: '',
        svg: '',
        url: '',
        id_menu: '',

        // modalRelacion

        modalRelacion: false,
        id_empresa: '',
        empresaCollection: [],
        id_menu2: '',
        relacionCollection: [],
        relacionExist: null,

        //paginador
        numByPag: 10,
        paginas: [],
        paginaCollection: [],
        paginaActual: 1,


    },


    methods: {

        // Metodos al controlador

        obtenerMenu() {
            let t = this;
            const parametros = {
                accion: 'obtenerMenu',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.menuColleccion = response.data;
                t.paginaCollection = response.data
                t.paginator(1);

            }).catch(function (error) {
            })
        },

        insertarMenu() {
            let t = this

            if (this.nombre != '' && this.svg != '' && this.url != '' && this.orden != '') {
                const parametros = {
                    accion: 'insertarMenu',
                    nombre: this.nombre,
                    svg: this.svg,
                    url: this.url,
                    orden: this.orden,
                    esmenu: this.esmenu,
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
                        t.obtenerMenu();
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

        editarMenu() {
            let t = this;

            if (this.nombre != '' && this.svg != '' && this.url != '' && this.orden != '') {
                const parametros = {
                    accion: 'editarMenu',
                    id: this.id_menu,
                    nombre: this.nombre,
                    svg: this.svg,
                    url: this.url,
                    orden: this.orden,
                    esmenu: this.esmenu,
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
                        t.obtenerMenu();
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

        eliminarMenu(idm) {

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
                        accion: 'eliminarMenu',
                        id: idm,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerMenu();
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
                this.nombre = row.nombre;
                this.orden = row.orden;
                this.url = row.url;
                this.svg = row.svg;
                this.id_menu = id;
                if (row.pagina_principal == 'SI') {
                    this.esmenu = true;
                }
                else {
                    this.esmenu = false;
                }
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
            this.orden = '';
            this.url = '';
            this.svg = '';
            this.esmenu = false;
            this.esactivo = false;
        },

        // seccion modalRelacion

        obtenerEmpresa() {
            let t = this;

            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post(t.path, parametros).then(function (response) {
                t.empresaCollection = response.data;
            });
        },

        agregarRelacion() {
            let t = this;
            let insertar = true;

            for (let i = 0; i < t.relacionCollection.length; i++) {
                const element = t.relacionCollection[i];
                console.log(element);
                if (element.id_empresa == t.id_empresa) {
                    insertar = false;

                }
            }
            if (insertar == true) {
                const parametros = {
                    accion: 'agregarRelacion',
                    id: t.id_menu2,
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
                id: t.id_menu2,
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


        abrirModalRelacion(id) {
            this.modalRelacion = true;
            this.id_menu2 = id;
            this.obtenerEmpresa();
            this.listarRelacion();
        },

        cerrarModalRelacion() {
            this.modalRelacion = false;
        },


        // swal info

        info() {
            Swal.fire({
                text: "Para que el menú agregado sea visible, es necesario CERRAR SESION y acceder de nuevo. ¿Desea CERRAR SESION?",
                icon: 'info',
                width: '60%',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, cerrar',
                cancelButtonText: 'Permanecer'
            }).then((result) => {
                if (result.value == true) {
                    window.location.href = '../logout.php'
                }
            })
        },

         // paginador

         paginator(i) {
            let cantidad_pages = Math.ceil(this.menuColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.menuColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.menuColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }




    },

    async mounted() {

        this.obtenerMenu();

    }





});