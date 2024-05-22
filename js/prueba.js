var prueba = new Vue({

    el: '#prueba',

    data() {
        return {

            path: 'controller/header.php',
            empleadoCollection: [],
            password: '',
            user: '',

        }
    },


    methods: {




        xddd() {
            Swal.fire({
                title: 'Campos incompletos!',
                padding: '3em',
                icon: 'warning',
                confirmButtonText: 'Intentar de nuevo'
              
              })
        },


    },

    mounted() {


    }





});