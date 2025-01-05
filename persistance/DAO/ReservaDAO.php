<?php

require_once(dirname(__FILE__) . '/../conf/PersistentManager.php');
require_once(dirname(__FILE__) . '/../../app/models/Reserva.php');

class ReservaDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = PersistentManager::getInstance()->get_connection();
    }

    public function create(Reserva $reserva)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO reservations (fecha, hora, comensales, ip) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ssis",
            $reserva->getFecha(),
            $reserva->getHora(),
            $reserva->getComensales(),
            $reserva->getIp()
        );

        return $stmt->execute();
    }

    // Otros métodos (opcional)
}
