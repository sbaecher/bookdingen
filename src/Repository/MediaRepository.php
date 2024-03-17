<?php

include_once __DIR__ . '/AbstractRepository.php';
include_once __DIR__ . '/../Entity/Media.php';

class MediaRepository extends AbstractRepository
{
    public function create(Media $media): bool
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO media (`title`, `author`, `media_code`, `category`, `description`) VALUES (?, ?, ?, ?, ?)'
        );

        return $stmt->execute([
            $media->getTitle(),
            $media->getAuthor(),
            $media->getMediaCode(),
            $media->getCategory(),
            $media->getDescription()
        ]);
    }

    public function getById(int $id): ?Media
    {
        $stmt = $this->connection->prepare(
            'SELECT * FROM media WHERE `id` = ?'
        );
        $stmt->execute([$id]);
        $mediaData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$mediaData) {
            return null;
        }

        $media = new Media();
        $media->setId($mediaData['id']);
        $media->setTitle($mediaData['title']);
        $media->setAuthor($mediaData['author']);
        $media->setMediaCode($mediaData['media_code']);
        $media->setCategory($mediaData['category']);
        $media->setDescription($mediaData['description']);

        return $media;
    }

    public function update(Media $media): bool
    {
        $stmt = $this->connection->prepare(
            'UPDATE media SET `title` = ?, `author` = ?, `media_code` = ?, `category` = ?, `description` = ? WHERE `id` = ?'
        );

        return $stmt->execute([
            $media->getTitle(),
            $media->getAuthor(),
            $media->getMediaCode(),
            $media->getCategory(),
            $media->getDescription(),
            $media->getId()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare(
            'DELETE FROM media WHERE  `id` = ?'
        );

        return $stmt->execute([$id]);
    }

    public function all(): array
    {
        $medias = [];

        try {
            $stmt = $this->connection->query('SELECT * FROM media');

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $media = new Media();
                $media->setId($row['id']);
                $media->setTitle($row['title']);
                $media->setAuthor($row['author']);
                $media->setMediaCode($row['media_code']);
                $media->setCategory($row['category']);
                $media->setDescription($row['description']);

                $medias[] = $media;
            }
        } catch (PDOException $e) {
        }

        return $medias;
    }
}
