<?php

include_once __DIR__ . '/AbstractRepository.php';
include_once __DIR__ . '/../Entity/User.php';

class UserRepository extends AbstractRepository
{
    public function create(User $user): bool
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO users (`full_name`, `user_name`, `email`, `password`) VALUES (?, ?, ?, ?)'
        );

        return $stmt->execute([
            $user->getFullName(),
            $user->getUserName(),
            $user->getEmail(),
            $user->getPassword()
        ]);
    }

    public function getById(int $id): ?User
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM users WHERE `id` = ?'
        );
        $stmt->execute([$id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        $user = new User();
        $user->setId($userData['id']);
        $user->setFullName($userData['full_name']);
        $user->setUserName($userData['user_name']);
        $user->setEmail($userData['email']);
        $user->setPassword($userData['password']);
        $user->setRole($userData['role']);

        return $user;
    }

    public function update(User $user): bool
    {
        $stmt = $this->connection->prepare(
            'UPDATE users SET `full_name` = ?, `user_name` = ?, `email` = ?, `password` = ? WHERE `id` = ?'
        );

        return $stmt->execute([
            $user->getFullName(),
            $user->getUserName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare(
            'DELETE FROM users WHERE `id` = ?'
        );

        return $stmt->execute([$id]);
    }

    public function getByEmail(string $email): ?User
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM users WHERE `email` = ?'
        );
        $stmt->execute([$email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$userData) {
            return null;
        }

        $user = new User();
        $user->setId($userData['id']);
        $user->setFullName($userData['full_name']);
        $user->setUserName($userData['user_name']);
        $user->setEmail($userData['email']);
        $user->setPassword($userData['password']);
        $user->setRole($userData['role']);

        return $user;
    }

    public function all(): array
    {
        $users = [];

        try {
            $stmt = $this->connection->query('SELECT * FROM users');

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new User();
                $user->setId($row['id']);
                $user->setFullName($row['full_name']);
                $user->setUserName($row['user_name']);
                $user->setEmail($row['email']);
                $user->setPassword($row['password']);
                $user->setRole($row['role']);

                $users[] = $user;
            }
        } catch (PDOException $e) {
        }

        return $users;
    }
}
