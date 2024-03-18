<?php

include_once __DIR__ . '/TestingInterface.php';
include_once __DIR__ . '/../src/Repository/MediaRepository.php';
include_once __DIR__ . '/../src/Entity/Media.php';

class MediaRepositoryTest implements TestingInterface
{
    private MediaRepository $mediaRepository;
    private Media $media;

    public function __construct()
    {
        $this->mediaRepository = new MediaRepository();

        $this->media = new Media();
        $this->media->setTitle('Test Book');
        $this->media->setMediaCode('1234-1234-1234-1234');
        $this->media->setAuthor('Test Author');
        $this->media->setDescription('Test Description');
        $this->media->setCategory('book');
    }

    public function startTests(): bool
    {
        $testCreate = $this->testCreate();
        $testGetAll = $this->testAll();
        $testGetById = $this->testGetById();
        $testUpdate = $this->testUpdate();
        $testDelete = $this->testDelete();

        if (!(
            $testCreate
            || $testGetAll
            || $testGetById
            || $testUpdate
            || $testDelete
        )) {
            return false;
        }

        return true;
    }

    public function testDelete(): bool
    {
        return $this->mediaRepository->delete($this->media->getId());
    }

    public function testGetById(): bool
    {
        return !empty($this->mediaRepository->getById($this->media->getId()));
    }

    public function testUpdate(): bool
    {
        $this->media->setTitle('Test BookUpdate');
        $this->media->setMediaCode('1234-1234-1234-1234Update');
        $this->media->setAuthor('Test AuthorUpdate');
        $this->media->setDescription('Test DescriptionUpdate');
        $this->media->setCategory('bookUpdate');

        if (!$this->mediaRepository->update($this->media)) {
            return false;
        }

        $updateMedia = $this->mediaRepository->getById($this->media->getId());

        if (
            str_contains($updateMedia->getTitle(), 'Update')
            && str_contains($updateMedia->getMediaCode(), 'Update')
            && str_contains($updateMedia->getAuthor(), 'Update')
            && str_contains($updateMedia->getDescription(), 'Update')
            && str_contains($updateMedia->getCategory(), 'Update')
        ) {
            return true;
        }

        return false;
    }

    public function testCreate(): bool
    {
        return $this->mediaRepository->create($this->media);
    }

    public function testAll(): bool
    {
        return count($this->mediaRepository->all()) > 0;
    }
}
