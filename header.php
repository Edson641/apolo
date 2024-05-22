<?php

session_start();
$id = 0;
$rol = '';
$id_rol = '';
$nombre = '';


foreach ($_SESSION['usuarioApolo'] as $datos) {
    $id = $datos['id_empleado'];
    $rol = $datos['rol'];
    $nombre = $datos['nombre'] . ' ' . $datos['ap_paterno'];
    $id_empresa = $datos['id_empresa'];
}

if ($id == 0 && $rol == '') {

    session_destroy();
    header('Location: ../index.php');
    exit();
} else {
    //header('Location: ../index.php');
}

?>



<!doctype html>
<html lang="en">

<head>
    <title>APolo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://kit.fontawesome.com/0b4c293cdb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script><!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-vue/2.23.1/bootstrap-vue.min.js"></script>
    <script src="https://unpkg.com/axios@0.26.0/dist/axios.min.js"></script>

    <link rel="stylesheet" href="../sidebar/css/style.css">




</head>

<body>





    <div class="wrapper d-flex align-items-stretch">

        <nav id="sidebar">

            <div class="img bg-wrap text-center py-4" id="header">
                <div class="user-logo">
                    <a class="navbar-brand ps-3 text-white" href="inicio.php" style="margin-left:35%">APolo <i class="fa-solid fa-feather-pointed" style="color: #f1df1e;"></i></a>
                    <h3 style="margin-top:4%"><?php echo $nombre ?></h3>
                    <a style="color: #EDBF11;cursor:pointer" @click="cerrarSesion();"><span class="fa fa-sign-out mr-3"></span>Cerrar Sesion</a>

                </div>
            </div>
            <ul class="list-unstyled components mb-5">
                <?php

                foreach ($_SESSION['menuLucas'] as $menu) {
                    echo '
                <li class="nav-item">
                <a class="nav-link text-white" href=' . $menu['url'] . '>
                    ' . $menu['svg'] . '
                    ' . $menu['nombreurl'] . '
                </a>
            </li>
            ';
                }
                ?>

            </ul>

        </nav>
    

        <!-- Page Content  -->
        <div style="width:100%">
            <nav class="sb-topnav navbar navbar-expand navbar-dark">
                <a class="navbar-brand ps-3" style="margin-left:3%"> <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" aria-label="Toggle navigation" aria-controls="navbarSupportedContent" aria-expanded="false" data-mdb-target="#navbarSupportedContent">
                        <button type="button" id="sidebarCollapse" class="btn" style="background-color:#132C40">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-layout-sidebar-inset" viewBox="0 0 16 16" style="color: #ffffff" ;>
                                <path d="M14 2a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h12zM2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z" />
                                <path d="M3 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg>

                        </button>
                    </button></a>
                <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>

                <!-- Navbar-->
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">

                    </li>
                </ul>
            </nav>

            <div id="content" class="p-4 p-md-5 pt-5">

                <main>




                    <!-- <script src="../sidebar/js/jquery.min.js"></script> -->
                    <!-- <script src="../sidebar/js/popper.js"></script> -->
                    <!-- <script src="../sidebar/js/bootstrap.min.js"></script> -->
                    <script src="../sidebar/js/main.js"></script>
                    <script type="text/javascript" src="../js/header.js"></script>