var movimientos = new Vue({

    el: '#movimientos',

    data: {


        // movimientos
        movimientosColleccion: [],

        // Controlador
        path: '../controller/c_movimientos.php',

        // FORM
        modal: false,
        title: '',
        id_empresa_destino: '',
        id_empresa_origen: '',
        id_sucursal_destino: '',
        id_sucursal_origen: '',
        id_caja_destino: '',
        id_caja_origen: '',
        id_tipo: 1,
        monto: '',
        descripcion: '',
        id_departamento_destino: '',
        saldoDisp: '',
        saldo: [],
        saldoDispDestino: '',
        saldoD: [],
        movements: true,
        movin: false,
        movout: false,
        cliente:'',


        // BUSQUEDA

        id_empresa: '',
        id_sucursal: '',
        id_caja: 0,
        mes: 0,
        anio: '',

        // combo

        empresaColleccion: [],
        cajaColleccion: [],
        sucursalColleccion: [],
        empresaColleccion2: [],
        cajaColleccion2: [],
        sucursalColleccion2: [],
        tipoColleccion: [],
        conceptoColleccion: [],

        //combos departamento

        departamentoColleccion: [],
        empresaColleccionD: [],
        cajaColleccionD: [],
        sucursalColleccionD: [],

        // cargando 
        charge: false,
        showmoves: false,

        // saldo
        saldoModal: false,
        saldoadd: 0,
        saldoActual: '',

        //paginador
        numByPag: 10,
        paginas: [],
        paginaCollection: [],
        paginaActual: 1,

        // Insertar
        montoin: 0,
        caja: 0,
        moneda: 0,
        cajaColleccionIn: [],
        monedaColleccion: [],
        saldoIn: [],
        saldoAct: 0,
        concepto: 0,

        //  meses

        meses: [
            { no_mes: 1, mes: 'ENERO' },
            { no_mes: 2, mes: 'FEBRERO' },
            { no_mes: 3, mes: 'MARZO' },
            { no_mes: 4, mes: 'ABRIL' },
            { no_mes: 5, mes: 'MAYO' },
            { no_mes: 6, mes: 'JUNIO' },
            { no_mes: 7, mes: 'JULIO' },
            { no_mes: 8, mes: 'AGOSTO' },
            { no_mes: 9, mes: 'SEPTIEMBRE' },
            { no_mes: 10, mes: 'OCTUBRE' },
            { no_mes: 11, mes: 'NOVIEMBRE' },
            { no_mes: 12, mes: 'DICIEMBRE' },
        ]


    },


    methods: {

        // Metodos al controlador

        obtenerMovimientos() {
            this.charge = true;
            let t = this;
            const parametros = {
                accion: 'obtenerMovimientos',
                id_caja: this.id_caja,
                anio: this.anio.toString(),
                mes: this.mes
            }
            const response = axios.post(this.path, parametros).then(function (response) {
                t.movimientosColleccion = response.data;
                for (let i = 0; i < t.movimientosColleccion.length; i++) {
                    t.movimientosColleccion[i].monto = (Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(t.movimientosColleccion[i].monto));
                    t.paginaCollection = response.data;
                    t.paginator(1);
                    t.id_empresa = '';
                    t.id_sucursal = '';
                    t.id_caja = 0;

                }

                t.charge = false;

            }).catch(function (error) {
            })
        },

        insertarMovimiento() {
            // this.charge = true;
            let t = this;
            if (t.id_tipo != '' && t.descripcion != '' && t.concepto != 0) {
                if (t.id_caja_destino != t.id_caja_origen) {
                    if (t.id_empresa_origen != '' && t.id_sucursal_origen != '' && t.id_caja_origen != '' && t.monto != '' && t.moneda != 0) {
                        if (t.tipo != 2) {
                            if (t.id_empresa_destino != '' && t.id_sucursal_destino != '' && t.id_caja_destino != '') {
                                if (parseFloat(t.monto) <= parseFloat(t.saldoDisp)) {
                                    const parametros = {
                                        accion: 'insertarMovimientos',
                                        caja_origen: this.id_caja_origen,
                                        caja_destino: this.id_caja_destino,
                                        monto: this.monto,
                                        descripcion: this.descripcion,
                                        tipo: this.id_tipo,
                                    }
                                    const response = axios.post(this.path, parametros).then(function (response) {
                                        if (response.data == true) {
                                            t.restarSaldo();
                                            t.agregarSaldo();
                                            t.crearHistorial();
                                            // t.charge = false;
                                            swal.fire(
                                                'Datos Insertados!',
                                                'Se ha creado el registro con exito!',
                                                'success'
                                            )
                                            // t.cerrarModal();
                                            t.limpiar();
                                            t.obtenerMovimientos();
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
                                        'Saldo insuficiente',
                                        'La caja no cuenta con el monto necesario para la transferencia',
                                        'error'
                                    )
                                }

                            } else {
                                swal.fire(
                                    'Campos (DESTINO) incompletos',
                                    'Complete todos los campos de (Destino) para continuar',
                                    'info'
                                )
                            }
                        } else {
                            if (t.id_empresa_destino != '' && t.id_sucursal_destino != '' && t.id_caja_destino != '' && t.id_departamento_destino != '') {
                                if (parseFloat(t.monto) <= parseFloat(t.saldoDisp)) {

                                    if (this.moneda == 1) {
                                        const parametros = {
                                            accion: 'insertarMovimientos',
                                            caja_origen: this.id_caja_origen,
                                            caja_destino: this.id_caja_destino,
                                            monto: this.monto,
                                            descripcion: this.descripcion,
                                            tipo: this.id_tipo,
                                        }
                                        const response = axios.post(this.path, parametros).then(function (response) {
                                            if (response.data == true) {
                                                t.restarSaldo();
                                                t.agregarSaldo();
                                                t.crearHistorial();
                                                // t.charge = false;
                                                swal.fire(
                                                    'Datos Insertados!',
                                                    'Se ha creado el registro con exito!',
                                                    'success'
                                                )
                                                // t.cerrarModal();
                                                t.limpiar();
                                                t.obtenerMovimientos();
                                            } else {
                                                swal.fire(
                                                    'Error!',
                                                    'No se ha podido crear el registro',
                                                    'error')
                                            }
                                        }).catch(function (error) {
                                        })
                                    }
                                } else {
                                    swal.fire(
                                        'Saldo insuficiente',
                                        'La caja no cuenta con el monto necesario para la transferencia',
                                        'error'
                                    )
                                }

                            } else {
                                swal.fire(
                                    'Campos (DESTINO) incompletos',
                                    'Complete todos los campos de (Destino) para continuar',
                                    'info'
                                )
                            }
                        }

                    } else {
                        swal.fire(
                            'Campos (ORIGEN) incompletos',
                            'Complete todos los campos de (Origen) para continuar',
                            'info'
                        )
                    }
                } else {
                    this.id_sucursal_destino = '';
                    this.id_empresa_destino = '';
                    this.id_caja_destino = '';
                    swal.fire(
                        'info',
                        'No se puede seleccionar la caja de ORIGEN como DESTINO',
                        'info'
                    )
                }

            } else {
                t.limpiar();
                swal.fire(
                    'Campos Vacíos',
                    'Debes seleccionar un tipo de MOVIMIENTO, un CONCEPTO e insertar una DESCRIPCIÓN para continuar',
                    'info'
                )
            }
        },



        crearHistorial() {

            let t = this;

            let datosH = [];

            let montoN = 0 - t.monto;

            datosH.push({
                id_caja: this.id_caja_origen,
                monto: t.monto,
                descripcion: this.descripcion,
                tipo: 4,
                tipo_movimiento: this.id_tipo,
                id_concepto: this.concepto,
                moneda: this.moneda,
                monto_anterior: this.saldoDisp,


            });

            datosH.push({
                id_caja: this.id_caja_destino,
                monto: t.monto,
                descripcion: this.descripcion,
                tipo: 3,
                tipo_movimiento: this.id_tipo,
                id_concepto: this.concepto,
                moneda: this.moneda,
                monto_anterior: this.saldoDispDestino,


            });

            for (let i = 0; i < datosH.length; i++) {
                const element = datosH[i];
                const parametros = {
                    accion: 'crearHistorial',
                    model: element,
                }
                const response = axios.post(this.path, parametros).then(function (response) {
                    if (response.data == true) {
                        console.log('Historial creado');
                    } else {
                    }
                }).catch(function (error) {
                })

            }


        },

        mov() {
            this.movements = true;
            this.movin = false;
            this.movout = false;
            this.limpiar();
            this.obtenerConcepto();



        },
        ins() {
            this.movin = true;
            this.movements = false;
            this.movout = false;
            this.obtenerMoneda();
            this.obtenerConcepto();
            this.limpiar();




        },
        out() {
            this.movout = true;
            this.movements = false;
            this.movin = false;
            this.obtenerMoneda();
            this.obtenerConcepto();
            this.limpiar();


        },
        back() {
            this.showmoves = false;
        },

        agregarSaldo() {
            let t = this;

            if (t.id_tipo == 1) {


                const tot = parseFloat(t.saldoDispDestino) + parseFloat(t.monto)
                console.log(tot);
                console.log('no depa');

                if (this.moneda == 1) {

                    const parametros = {
                        accion: 'agregarSaldo',
                        id: this.id_caja_destino,
                        saldo: tot,
                    }
                    console.log(parametros);
                    const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                        if (response.data == true) {
                            console.log('Monto Agregado');
                        } else {
                            console.log('No se ha podido sumar el monto');
                        }

                    }).catch(function (error) {
                    })

                } else {
                    const parametros = {
                        accion: 'agregarSaldoDolar',
                        id: this.id_caja_destino,
                        saldo: tot,
                    }
                    console.log(parametros);
                    const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                        if (response.data == true) {
                            console.log('Monto Agregado');
                        } else {
                            console.log('No se ha podido sumar el monto');
                        }

                    }).catch(function (error) {
                    })

                }

            } else {
                const tot = parseFloat(t.saldoDispDestino) + parseFloat(t.monto)
                console.log('si depa');
                if (this.moneda == 1) {

                    const parametros = {
                        accion: 'agregarSaldo',
                        id: this.id_caja_destino,
                        saldo: tot,
                    }
                    console.log(parametros);
                    const response = axios.post('../controller/c_caja_departamento.php', parametros).then(function (response) {
                        if (response.data == true) {
                            console.log('Monto Agregado');
                        } else {
                            console.log('No se ha podido sumar el monto');
                        }
                    }).catch(function (error) {
                    })
                } else {
                    const parametros = {
                        accion: 'agregarSaldoDolar',
                        id: this.id_caja_destino,
                        saldo: tot,
                    }
                    console.log(parametros);
                    const response = axios.post('../controller/c_caja_departamento.php', parametros).then(function (response) {
                        if (response.data == true) {
                            console.log('Monto Agregado');
                        } else {
                            console.log('No se ha podido sumar el monto');
                        }
                    }).catch(function (error) {
                    })
                }

            }

        },

        restarSaldo() {
            let t = this;

            // if (t.id_tipo == 1) {


            const tot = t.saldoDisp - t.monto

            if (this.moneda == 1) {

                const parametros = {
                    accion: 'restarSaldo',
                    id: t.id_caja_origen,
                    saldo: tot,
                }
                const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                    if (response.data == true) {
                        console.log('Monto Restado');
                    } else {
                        console.log('No se ha podido restar el monto');
                    }

                }).catch(function (error) {
                })
            } else {

                const parametros = {
                    accion: 'restarSaldoDolar',
                    id: t.id_caja_origen,
                    saldo: tot,
                }
                const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                    if (response.data == true) {
                        console.log('Monto Restado');
                    } else {
                        console.log('No se ha podido restar el monto');
                    }

                }).catch(function (error) {
                })

            }

        },


        //// ORIGEN ///////


        obtenerTipo() {
            let t = this;
            const parametros = {
                accion: 'obtenerTipo',
            }
            const response = axios.post(t.path, parametros).then(function (response) {
                t.tipoColleccion = response.data;
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
                t.id_sucursal = '';
                t.id_caja = 0;
            }).catch(function (error) {
            })
        },

        obtenerSucursal() {
            let t = this;
            const parametros = {
                accion: 'obtenerSucursalEmpresa',
                id_empresa: this.id_empresa_origen,
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalColleccion = response.data;
            });
        },

        obtenerCaja() {

            let t = this;
            const parametros = {
                accion: 'obtenerCajaEmpresa',
                id_empresa: this.id_empresa_origen,
                id_sucursal: this.id_sucursal_origen,
            }
            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                t.cajaColleccion = response.data;

            }).catch(function (error) {
            })
        },

        obtenerSaldo() {

            let t = this;
            const parametros = {
                accion: 'obtenerSaldoCaja',
                id_caja: this.id_caja_origen,
            }
            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                t.saldo = response.data;
                if (t.moneda == 1) {
                    t.saldoDisp = t.saldo[0].saldo;
                } else {
                    t.saldoDisp = t.saldo[0].saldo_dolar;
                }

            }).catch(function (error) {
            })
        },

        obtenerSaldoD() {

            let t = this;
            if (this.id_tipo == 1) {

                const parametros = {
                    accion: 'obtenerSaldoCaja',
                    id_caja: this.id_caja_destino,
                }
                const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                    t.saldoD = response.data;
                    if (t.moneda == 1) {
                        t.saldoDispDestino = t.saldoD[0].saldo;
                    } else {
                        t.saldoDispDestino = t.saldoD[0].saldo_dolar;
                    }
                }).catch(function (error) {
                })
            } else {
                const parametros = {
                    accion: 'obtenerSaldoCaja',
                    id_caja: this.id_caja_destino,
                    id_departamento: this.id_departamento_destino,
                }
                const response = axios.post('../controller/c_caja_departamento.php', parametros).then(function (response) {
                    t.saldoD = response.data;
                    if (t.moneda == 1) {
                        t.saldoDispDestino = t.saldoD[0].saldo;
                    } else {
                        t.saldoDispDestino = t.saldoD[0].saldo_dolar;
                    }

                }).catch(function (error) {
                })
            }

        },

        obtenerConcepto() {
            let t = this;
            const parametros = {
                accion: 'obtenerConcepto',
            }
            const response = axios.post('../controller/c_concepto.php', parametros).then(function (response) {
                t.conceptoColleccion = response.data;
            }).catch(function (error) {
            })
        },

        // DESTINO ///////

        obtenerEmpresa2() {
            let t = this;
            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post('../controller/c_empresa.php', parametros).then(function (response) {
                t.empresaColleccion2 = response.data;
            }).catch(function (error) {
            })
        },

        obtenerSucursal2() {
            let t = this;
            const parametros = {
                accion: 'obtenerSucursalEmpresa',
                id_empresa: this.id_empresa_destino,
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalColleccion2 = response.data;
            });
        },

        obtenerCaja2() {

            let t = this;
            const parametros = {
                accion: 'obtenerCajaEmpresa',
                id_empresa: this.id_empresa_destino,
                id_sucursal: this.id_sucursal_destino,
            }
            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                t.cajaColleccion2 = response.data;

            }).catch(function (error) {
            })
        },

        // combos departamento

        obtenerEmpresaD() {
            let t = this;
            const parametros = {
                accion: 'obtenerEmpresa',
            }
            const response = axios.post('../controller/c_empresa.php', parametros).then(function (response) {
                t.empresaColleccionD = response.data;
            }).catch(function (error) {
            })
        },

        obtenerSucursalD() {
            let t = this;
            const parametros = {
                accion: 'obtenerSucursalEmpresa',
                id_empresa: this.id_empresa_destino,
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalColleccionD = response.data;
            });
        },
        obtenerDepartamento() {
            let t = this;
            const parametros = {
                accion: 'obtenerDepartamentoSucursal',
                id_sucursal: this.id_sucursal_destino,
            }
            const response = axios.post('../controller/c_departamento.php', parametros).then(function (response) {
                t.departamentoColleccion = response.data;
            });
        },

        obtenerCajaD() {

            let t = this;
            const parametros = {
                accion: 'obtenerCajaDepartS',
                id_departamento: this.id_departamento_destino,
            }
            const response = axios.post('../controller/c_caja_departamento.php', parametros).then(function (response) {
                t.cajaColleccionD = response.data;
                console.log(t.cajaColleccionD);

            }).catch(function (error) {
            })
        },

        // INSERTAR

        obtenerCajaIn() {

            let t = this;
            const parametros = {
                accion: 'obtenerCajaEmpresa',
                id_empresa: this.id_empresa_origen,
                id_sucursal: this.id_sucursal_origen,
            }
            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                t.cajaColleccionIn = response.data;

            }).catch(function (error) {
            })


        },

        obtenerSaldoIn() {

            let t = this;
            const parametros = {
                accion: 'obtenerSaldoCaja',
                id_caja: this.caja,
            }
            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                t.saldoIn = response.data;
                if (t.moneda == 1) {
                    t.saldoAct = t.saldoIn[0].saldo
                } else {
                    t.saldoAct = t.saldoIn[0].saldo_dolar
                }
            }).catch(function (error) {
            })

        },

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

        sumar() {


            let resultado;
            if (this.saldoAct == null || this.saldoAct == 'null') {
                this.saldoAct = 0
                resultado = parseInt(this.saldoAct) + parseInt(this.montoin);
                // console.log('hola soy 0');
                return resultado;
            } else {
                var salde = Number(this.saldoAct.replace(/[^0-9.-]+/g, ""));
                resultado = salde + parseInt(this.montoin);
                // console.log('no soy 0');
                return resultado;

            }

        },

        async agregarSaldoDolar() {
            if (this.id_empresa_origen != '' && this.id_sucursal_origen != "" && this.caja != 0 && this.moneda != 0 && this.montoin != 0 && this.descripcion != '' && this.concepto != 0 && this.cliente != '') {

                let t = this;

                if (parseFloat(t.montoin) > 0) {

                    const sum = t.sumar();
                    console.log(sum);
                    if (this.moneda == 1) {

                        const parametros = {
                            accion: 'editarSaldo',
                            id: this.caja,
                            saldo: sum,
                        }
                        const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                            if (response.data == true) {
                                t.crearHistorialIn();
                                Swal.fire({
                                    title: 'Se han guardado los datos',
                                    text: 'Se ha agregado $' + t.montoin + ' de saldo en Pesos',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonColor: '#2596be',
                                    cancelButtonColor: '#D0DC2E',
                                    confirmButtonText: 'Ver Historial',
                                    cancelButtonText: 'Continuar en Movimientos'
                                }).then((result) => {
                                    if (result.value) {

                                        window.location.href = '../view/historial.php?id_caja=' + t.caja;
                                    } else {
                                        t.limpiar();

                                    }
                                })
                                // t.cerrarModalSaldo();
                                // t.obtenerCaja();
                            } else {
                                swal.fire(
                                    'Error!',
                                    'No se ha podido agregar el saldo',
                                    'error')
                            }
                        }).catch(function (error) {
                        })

                    } else {

                        const parametros = {
                            accion: 'editarSaldoDolar',
                            id: this.caja,
                            saldo: sum,
                        }
                        const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                            if (response.data == true) {
                                t.crearHistorialIn()

                                Swal.fire({
                                    title: 'Se han guardado los datos',
                                    text: 'Se ha agregado $' + t.montoin + ' de saldo en Dolares',
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonColor: '#2596be',
                                    cancelButtonColor: '#D0DC2E',
                                    confirmButtonText: 'Ver Historial',
                                    cancelButtonText: 'Continuar en Movimientos'
                                }).then((result) => {
                                    if (result.value) {

                                        window.location.href = '../view/historial.php?id_caja=' + t.caja;
                                    } else {
                                        t.limpiar();

                                    }
                                })
                                                            // t.cerrarModalSaldo();
                                // t.obtenerCaja();
                            } else {
                                swal.fire(
                                    'Error!',
                                    'No se ha podido agregar el saldo',
                                    'error')
                            }
                        }).catch(function (error) {
                        })

                    }
                    return;
                } else {
                    swal.fire(
                        'Monto No Admitido',
                        'No se pueden ingresar numeros negativos',
                        'error'
                    )
                }


            } else {
                swal.fire(
                    'Campos Vacios!',
                    'Favor de llenar los campos',
                    'info'
                )

            }


        },


        confirmar() {


        },

        crearHistorialIn(s) {

            let t = this;

            let datosH = [];

            datosH.push({
                id_caja: this.caja,
                monto: this.montoin,
                descripcion: this.descripcion,
                id_concepto: this.concepto,
                moneda: this.moneda,
                monto_anterior: this.saldoAct,
                tipo: 3,
                cliente: this.cliente
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


        async restarSaldoDolar() {
            if (this.id_empresa_origen != '' && this.id_sucursal_origen != "" && this.caja != 0 && this.moneda != 0 && this.montoin != 0 && this.descripcion != '' && this.concepto != 0 && this.cliente != '') {
                let t = this;

                if (parseFloat(t.montoin) <= parseFloat(t.saldoAct)) {
                    if (parseFloat(t.montoin) > 0) {

                        const tot = t.saldoAct - t.montoin

                        console.log(tot);

                        if (this.moneda == 1) {

                            const parametros = {
                                accion: 'editarSaldoOut',
                                id: this.caja,
                                saldo: tot,
                            }
                            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                                if (response.data == true) {
                                    t.crearHistorialOut();
                                    swal.fire(
                                        'Saldo Retirado!',
                                        'Se ha retirado $' + t.montoin + ' de saldo en Pesos',
                                        'success'
                                    )
                                    Swal.fire({
                                        title: 'Se han guardado los datos',
                                        text: 'Se ha retirado $' + t.montoin + ' de saldo en Pesos',
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonColor: '#2596be',
                                        cancelButtonColor: '#D0DC2E',
                                        confirmButtonText: 'Ver Historial',
                                        cancelButtonText: 'Continuar en Movimientos'
                                    }).then((result) => {
                                        if (result.value) {
    
                                            window.location.href = '../view/historial.php?id_caja=' + t.caja;
                                        } else {
                                            t.limpiar();
    
                                        }
                                    })
                                    // t.cerrarModalSaldo();
                                    // t.obtenerCaja();
                                } else {
                                    swal.fire(
                                        'Error!',
                                        'No se ha podido retirar el saldo',
                                        'error')
                                }
                            }).catch(function (error) {
                            })

                        } else {

                            const parametros = {
                                accion: 'editarSaldoDolarOut',
                                id: this.caja,
                                saldo: tot,
                            }
                            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                                if (response.data == true) {
                                    t.crearHistorialOut()
                                    Swal.fire({
                                        title: 'Se han guardado los datos',
                                        text: 'Se ha retirado $' + t.montoin + ' de saldo en Dolares',
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonColor: '#2596be',
                                        cancelButtonColor: '#D0DC2E',
                                        confirmButtonText: 'Ver Historial',
                                        cancelButtonText: 'Continuar en Movimientos'
                                    }).then((result) => {
                                        if (result.value) {
    
                                            window.location.href = '../view/historial.php?id_caja=' + t.caja;
                                        } else {
                                            t.limpiar();
    
                                        }
                                    })
                                    // t.cerrarModalSaldo();
                                    // t.obtenerCaja();
                                } else {
                                    swal.fire(
                                        'Error!',
                                        'No se ha podido retirar el saldo',
                                        'error')
                                }
                            }).catch(function (error) {
                            })

                        }
                        return;

                    } else {
                        swal.fire(
                            'Monto No Admitido',
                            'No se pueden ingresar numeros negativos',
                            'error'
                        )
                    }

                } else {
                    swal.fire(
                        'Saldo insuficiente',
                        'La caja no cuenta con el monto necesario para el retiro',
                        'error'
                    )
                }


            } else {
                swal.fire(
                    'Campos Vacios!',
                    'Favor de llenar los campos',
                    'info'
                )

            }


        },

        crearHistorialOut(s) {

            let t = this;

            let datosH = [];

            datosH.push({
                id_caja: this.caja,
                monto: this.montoin,
                descripcion: this.descripcion,
                id_concepto: this.concepto,
                moneda: this.moneda,
                monto_anterior: this.saldoAct,
                tipo: 4,
                cliente: this.cliente
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

        // Buscador

        obtenerSucursalS() {
            let t = this;
            const parametros = {
                accion: 'obtenerSucursalEmpresa',
                id_empresa: this.id_empresa,
            }
            const response = axios.post('../controller/c_sucursal.php', parametros).then(function (response) {
                t.sucursalColleccion = response.data;
            });
        },

        obtenerCajaS() {

            let t = this;
            const parametros = {
                accion: 'obtenerCajaEmpresa',
                id_empresa: this.id_empresa,
                id_sucursal: this.id_sucursal,
            }
            const response = axios.post('../controller/c_caja.php', parametros).then(function (response) {
                t.cajaColleccion = response.data;

            }).catch(function (error) {
            })
        },

        // buscarConcepto() {

        //     let input = document.getElementById('searchbar').value
        //     input = input.toLowerCase();
        //             // let x = this.conceptoColleccion;

        //     let x = document.getElementsByClassName('animals');

        //     for (i = 0; i < x.length; i++) { 
        //         if (!x[i].innerHTML.toLowerCase().includes(input)) {
        //             x[i].style.display="none";
        //         }
        //         else {
        //             x[i].style.display="list-item";                 
        //         }
        //     }


        // },

        // complementos

        limpiar() {
            this.id_departamento_destino = '';
            this.id_sucursal_destino = '';
            this.id_empresa_destino = '';
            this.id_empresa_origen = '';
            this.id_sucursal_origen = '';
            this.id_caja_destino = '';
            this.id_caja_origen = '';
            // this.id_tipo = '';
            this.monto = '';
            this.descripcion = '';
            this.id_departamento_destino = '';
            this.moneda = 0;
            this.descripcion = '';
            this.concepto = 0;
            this.montoin = 0;
            this.caja = 0;
            this.cliente = '';

        },

        verTabla() {
            this.showmoves = false;
        },

        verForm() {
            this.showmoves = true;
            this.id_empresa = '';
            this.id_sucursal = '';
            this.id_caja = 0;
            this.anio = '';
            this.mes = 0;
        },

        // Paginador

        paginator(i) {
            let cantidad_pages = Math.ceil(this.movimientosColleccion.length / this.numByPag);
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
                    let fin = (cantidad_pages == i ? this.movimientosColleccion.length : (parseInt(inicio) + parseInt(this.numByPag)));
                    for (let index = inicio; index < fin; index++) {
                        const element = this.movimientosColleccion[index];
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
        this.obtenerTipo();
        this.obtenerConcepto();
        this.obtenerEmpresa();
        this.obtenerEmpresa2();
        this.obtenerEmpresaD();
        this.obtenerMovimientos();

    }





});