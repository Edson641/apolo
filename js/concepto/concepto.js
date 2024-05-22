var con = new Vue({

    el: '#con',

    data: {


        // departamento
        conceptoColleccion: [],

        // Controlador
        path: '../controller/c_concepto.php',

        // Modal
        modal: false,
        title: '',
        concepto:'',
        esactivo: '',

          //paginador
          numByPag: 10,
          paginas: [],
          paginaCollection: [],
          paginaActual: 1,

    },


    methods: {

        // Metodos al controlador

        obtenerConcepto() {
            let t = this;
            const parametros = {
                accion: 'obtenerConcepto',
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.conceptoColleccion = response.data;
                t.paginaCollection = response.data;
                t.paginator(1);
            }).catch(function (error) {
            })
        },

        insertarConcepto() {
            let t = this

            if (this.concepto != '') {
                const parametros = {
                    accion: 'insertarConcepto',
                    concepto: this.concepto,
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
                        t.obtenerConcepto();
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

        editarConcepto() {

            let t = this;

            if (this.concepto != '') {
                const parametros = {
                    accion: 'editarConcepto',
                    id: this.id_concepto,
                    concepto: this.concepto,
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
                        t.obtenerConcepto();
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

        eliminarConcepto(iddep) {

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
                        accion: 'eliminarConcepto',
                        id: iddep,
                    }
                    const response = axios.post(this.path, parametros).then(function (response) {
                        if (response.data == true) {
                            swal.fire(
                                'Registro Eliminado!',
                                'Se ha eliminado el registro con exito!',
                                'success'
                            )
                            t.obtenerConcepto();
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
                this.id_concepto = id;
                this.concepto = row.concepto;
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
            this.concepto = '';
            this.esactivo = false;
        },

        // paginador


        paginator(i) {
            let cantidad_pages = Math.ceil(this.conceptoColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.conceptoColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.conceptoColleccion[index];
                        this.paginaCollection.push(element);
                    }
                }
            }
            this.paginas.push({ 'element': '>' });
        }
    },

    async mounted() {

        this.obtenerConcepto();

    }





});