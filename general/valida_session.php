<?php

class ValidaSession
{

public function verifica_session(){
    session_start();
    if (isset($_SESSION['usuarioApolo'])) {
          return true;
    }else{  
        session_destroy(); 
        return false; 
    }  
}

public function index_session(){
    session_start();
    if (isset($_SESSION['usuarioApolo'])) {
          return true;
    }else{  
        session_destroy(); 
        return false;
    }  
}

public function usuario_id(){
    session_start();
    $id =0;
    $rol='';
    $nombre = '';
      
    foreach ($_SESSION['usuarioApolo'] as $datos ) {
      $id = $datos['id_empleado'];
      $rol = $datos['nombre_rol'];
      $nombre = $datos['nombre'] .' '. $datos['paterno'];
      $id_empresa = $datos['id_empresa'];
    }

    return $id;
}


}
?>