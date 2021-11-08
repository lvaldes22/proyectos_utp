<?php
require_once('modelo.php');
class encuestas extends modeloCredencialesBD{
    public function __construct(){
        parent::__construct();
    }
    public function listar_det_enc(){
        $instruccion = "CALL sp_listar_det_enc()";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function listar_det_encp($id_enc){
        $instruccion = "CALL sp_listar_det_encp('".$id_enc."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function listar_res_enc(){
        $instruccion = "CALL sp_listar_res_enc()";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }

    public function insertar_resp($id_enc,$id_det_enc,$nombre,$cedula){
        $instruccion = "CALL sp_insertar_resp('".$id_enc."','".$id_det_enc."','".$nombre."','".$cedula."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function listar_respuestas($id_enc){
        $instruccion = "CALL sp_listar_respuestas('".$id_enc."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function listar_encuestas(){
        $instruccion = "CALL sp_listar_encuestas()";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function insertar_encuesta($nom_enc,$tipo){
        $instruccion = "CALL sp_insertar_encuesta('".$nom_enc."','".$tipo."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function eliminar_encuesta($id_enc){
        $instruccion = "CALL sp_delete_encuesta('".$id_enc."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function eliminar_detalle($id_det,$id_enc){
        $instruccion = "CALL sp_delete_detalle('".$id_det."','".$id_enc."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function insertar_det_encuesta($id,$nom_enc,$id_det,$det_enc,$tipo){
        $instruccion = "CALL sp_insertar_det_encuesta('".$id."','".$nom_enc."','".$id_det."','".$det_enc."','".$tipo."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function buscar_maximo($id_enc){
        $instruccion = "CALL sp_buscar_maximo('".$id_enc."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function modificar_encuesta($id,$nom_enc,$tipo){
        $instruccion = "CALL sp_modificar_encuesta('".$id."','".$nom_enc."','".$tipo."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function listar_encuestas_sp($id){
        $instruccion = "CALL sp_listar_encuesta_sp('".$id."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function modificar_detalle($id,$nom_det){
        $instruccion = "CALL sp_modificar_detalle('".$id."','".$nom_det."')";
        $actualiza=$this->_db->query($instruccion);
        if ($actualiza){
            return $actualiza;
            $actualiza->close();
            $this->_db->close();
        }
    }
    public function listar_detalle_sp($id){
        $instruccion = "CALL sp_listar_detalle_sp('".$id."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function validar_resp_enc_sp($id){
        $instruccion = "CALL sp_validar_resp_enc('".$id."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
    public function validar_resp_det_sp($id,$id_det){
        $instruccion = "CALL sp_validar_resp_det('".$id."','".$id_det."')";
        $consulta=$this->_db->query($instruccion);
        $resultado=$consulta->fetch_all(MYSQLI_ASSOC);
        if($resultado){
            return $resultado;
            $resultado->close();
            $this->_db->close();
        }
    }
}