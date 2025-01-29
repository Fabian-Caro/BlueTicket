<?php
require_once(__DIR__ . '/../Database/Conexion.php');
require_once(__DIR__ . '/../Persistence/ClienteDAO.php');

class Cliente
{
    private $idCliente;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $estado;

    public function __construct(
        $idCliente = 0,
        $nombre = "",
        $apellido = "",
        $correo = "",
        $clave = "",
        $estado = 0
    ) {
        $this->idCliente = $idCliente;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->estado = $estado;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    public function autenticar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO(null, null, null, $this->correo, $this->clave, null);
        $conexion->ejecutarConsulta($clienteDAO->autenticar());
        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        } else {
            $registro = $conexion->siguienteRegistro();
            $this->idCliente = $registro[0];
            $this->estado = $registro[1];
            $conexion->cerrarConexion();
            return true;
        }
    }

    public function consultar()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $clienteDAO = new ClienteDAO($this->idCliente);

        $conexion->ejecutarConsulta($clienteDAO->consultar());

        $registro = $conexion->siguienteRegistro();

        if ($registro) {
            $this->idCliente = $registro[0];
            $this->nombre = $registro[1];
            $this->apellido = $registro[2];
            $this->correo = $registro[3];
        } else {
            throw new Exception("Cliente no encontrado.");
        }
        $conexion->cerrarConexion();
    }

    public function consultarGastoCliente()
    {
        $cliente_gasto = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO();
        $conexion->ejecutarConsulta($clienteDAO->consultarGastoCliente());
        while ($registro = $conexion->siguienteRegistro()) {
            $gasto = $registro[1];
            if (is_null($gasto)) {
                $gasto = 0;
            }
            array_push($cliente_gasto, array($registro[0], $gasto));
        }
        $conexion->cerrarConexion();
        return $cliente_gasto;
    }

    public function registrar($nombre, $apellido, $correo, $clave)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO();
        $conexion->ejecutarConsulta($clienteDAO->insertar($nombre, $apellido, $correo, $clave));
        $conexion->cerrarConexion();
        return true;
    }

    public function activarCuenta($idCliente)
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $clienteDAO = new ClienteDAO();
        $conexion->ejecutarConsulta($clienteDAO->activarCuenta($idCliente));
        return true;
    }
}
