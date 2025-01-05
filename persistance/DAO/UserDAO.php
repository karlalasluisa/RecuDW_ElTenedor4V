<?php

require_once(dirname(__FILE__) . '/../../persistance/conf/PersistentManager.php');
require_once(dirname(__FILE__) . '/../../app/models/User.php');

class UserDAO
{
    private $connection;

    public function __construct()
    {
        $this->connection = PersistentManager::getInstance()->get_connection();
    }

    // Encontrar usuario por ID
    public function findById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE idUser = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $this->mapRowToUser($row);
        }

        return null;
    }

    // Encontrar usuario por nombre de usuario
    public function findByEmail($email)
    {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $this->mapRowToUser($row);
        }

        return null;
    }

    // Crear nuevo usuario
    public function create(User $user)
    {
        $stmt = $this->connection->prepare("
            INSERT INTO users (email, password, type) 
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param(
            "sss",
            $user->getUsername(),
            $user->getPsswd(),
            $user->getTipoUser()
        );

        return $stmt->execute();
    }

    // Actualizar usuario
    public function update(User $user)
    {
        $stmt = $this->connection->prepare("
            UPDATE users 
            SET email = ?, password = ?, type = ?
            WHERE idUser = ?
        ");
        $stmt->bind_param(
            "sss",
            $user->getEmail(),
            $user->getPsswd(),
            $user->getType(),
            $user->getIdUser()
        );

        return $stmt->execute();
    }

    // Eliminar usuario
    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM users WHERE idUser = ?");
        $stmt->bind_param("s", $id);

        return $stmt->execute();
    }

    // Listar todos los usuarios
    public function findAll()
    {
        $result = $this->connection->query("SELECT * FROM users");
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $this->mapRowToUser($row);
        }

        return $users;
    }

    // Mapear una fila de la base de datos a un objeto User
    private function mapRowToUser($row)
    {
        $user = new User($row['idUser'], $row['email'], $row['password'], $row['type']);
        return $user;
    }
}
