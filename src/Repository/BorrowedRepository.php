<?php

include_once __DIR__ . '/AbstractRepository.php';
include_once __DIR__ . '/../Entity/Borrowed.php';

class BorrowedRepository extends AbstractRepository
{
    public function create(Borrowed $borrowed): bool
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO borrowed (`user_id`, `media_id`, `timestamp`) VALUES (?, ?, ?)'
        );

        return $stmt->execute([
            $borrowed->getUserId(),
            $borrowed->getMediaId(),
            $borrowed->getTimestamp(),
        ]);
    }

    public function getByMediaId(int $id): ?Borrowed
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM borrowed WHERE `media_id` = ?'
        );
        $stmt->execute([$id]);
        $borrowedData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$borrowedData) {
            return null;
        }

        $borrowed = new Borrowed();
        $borrowed->setId($borrowedData['id']);
        $borrowed->setUserId($borrowedData['user_id']);
        $borrowed->setMediaId($borrowedData['media_id']);
        $borrowed->setTimestamp($borrowedData['timestamp']);

        return $borrowed;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare(
            'DELETE FROM borrowed WHERE  `id` = ?'
        );

        return $stmt->execute([$id]);
    }
}