var header = new Vue({

    el: '#header',

    data() {
        return {

            path: 'controller/header.php',
            empleadoCollection: [],
            password: '',
            user: '',

        }
    },


    methods: {




        cerrarSesion() {
            window.location.href = '../logout.php'
        },


    },

    mounted() {


    }





});