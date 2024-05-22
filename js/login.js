var index = new Vue({

    el: '#index-login',

    data() {
        return {

            path: 'controller/c_login.php',
            empleadoCollection: [],
            password: '',
            user: '',

        }
    },


    methods: {

        async buscarUsuarios() {

            // let t = this;
            if (this.password != '' && this.user != '') {

                const parametros = {
                    accion: 'buscarUsuarios',
                    user: this.user,
                    password: this.password,
                }

                const response = await axios.post(this.path, parametros).then(function (response) {

                    if (response.data != null && response.data.length > 0) {
                        const rol = response.data[0].id_rol;
                        index.acceder(rol);

                    } else {
                        Swal.fire(
                            'Error!',
                            'El usuario no existe.',
                            'error'
                        );
                    }


                });
            } else {


                Swal.fire({
                    title: 'Campos incompletos!',
                    padding: '3em',
                    icon: 'error',
                    confirmButtonText: 'Intentar de nuevo'

                })


            }


        },

        

        acceder(r) {
            let t = this;

            const params = {
                user: t.user
                , password: t.password
                , rol: r
                , accion: 'acceder'
            };
            axios.post(this.path, params)
                .then(function (response) {
                    if (response.status == 200) {
                        console.log('ok');
                        window.location.href = "view/inicio.php";

                    } else {
                        console.log('error');
                        window.location.href = "view/inicio.php";

                    }

                })
                .catch(function (response) {
                    console.log(response);
                })




        },


    },



});