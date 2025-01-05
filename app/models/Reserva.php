<?php

class Reserva
{
    private $id;
    private $fecha;
    private $hora;
    private $comensales;
    private $ip;

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function getComensales()
    {
        return $this->comensales;
    }

    public function getIp()
    {
        return $this->ip;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function setComensales($comensales)
    {
        $this->comensales = $comensales;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
    }
}
