<?php

include_once __DIR__ . '/TestingInterface.php';
include_once __DIR__ . '/../src/Service/Database.php';
include_once __DIR__ . '/../src/Repository/BorrowedRepository.php';
include_once __DIR__ . '/../src/Entity/Borrowed.php';
include_once __DIR__ . '/../src/Repository/MediaRepository.php';
include_once __DIR__ . '/../src/Entity/Media.php';
include_once __DIR__ . '/../src/Repository/UserRepository.php';
include_once __DIR__ . '/../src/Entity/User.php';

class BorrowedRepositoryTest implements TestingInterface
{
    protected PDO $connection;

    private BorrowedRepository $borrowedRepository;
    private Borrowed $borrowed;
    private MediaRepository $mediaRepository;
    private Media $media;
    private UserRepository $userRepository;
    private User $user;

    public function __construct()
    {
        $this->connection = Database::getConnection();

        $this->mediaRepository = new MediaRepository();

        $this->media = new Media();
        $this->media->setTitle('Test Book');
        $this->media->setMediaCode('1234-1234-1234-1234');
        $this->media->setAuthor('Test Author');
        $this->media->setDescription('Test Description');
        $this->media->setCategory('book');
        $this->media->setId(1);

        $this->userRepository = new UserRepository();

        $this->user = new User();
        $this->user->setFullName('Test User');
        $this->user->setEmail('testuser@sascha-baecher.dev');
        $this->user->setPassword('example');
        $this->user->setRole('user');
        $this->user->setUserName('TestUser');

        $this->userRepository->create($this->user);
        $this->user = $this->userRepository->getByEmail('testuser@sascha-baecher.dev');

        $this->borrowedRepository = new BorrowedRepository();

        $this->borrowed = new Borrowed();
        $this->borrowed->setUserId($this->user->getId());
        $this->borrowed->setMediaId($this->media->getId());
        $this->borrowed->setTimestamp(time());
        $this->borrowed->setActive(true);
    }

    public function startTests(): bool
    {
        $testCreate = $this->testCreate();
        $testGetByMediaIdAndActive = $this->testGetByMediaIdAndActive();
        $testGetByMediaId = $this->testGetByMediaId();
        $testDelete = $this->testDelete();

        if (!(
            $testCreate
            || $testGetByMediaIdAndActive
            || $testGetByMediaId
            || $testDelete
        )) {
            return false;
        }

        $this->mediaRepository->delete($this->media->getId());
        $this->userRepository->delete($this->user->getId());

        return true;
    }

    public function testCreate(): bool
    {
        return $this->borrowedRepository->create($this->borrowed);
    }

    public function testGetByMediaId(): bool
    {
        $this->borrowed = $this->borrowedRepository->getByMediaId($this->media->getId());

        return !empty($this->borrowed);
    }

    public function testGetByMediaIdAndActive(): bool
    {
        return !empty($this->borrowedRepository->getByMediaIdAndActive($this->media->getId()));
    }

    public function testDelete(): bool
    {
        $stmt = $this->connection->prepare(
            'DELETE FROM borrowed WHERE `id` = ?'
        );

        return $stmt->execute([$this->borrowed->getId()]);
    }
}
