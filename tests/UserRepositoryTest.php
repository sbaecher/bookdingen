<?php

include_once 'TestingInterface.php';
include_once '../src/Repository/UserRepository.php';
include_once '../src/Entity/User.php';

class UserRepositoryTest implements TestingInterface
{
    private UserRepository $userRepository;
    private User $user;

    public function __construct()
    {
        $this->userRepository = new UserRepository();

        $this->user = new User();
        $this->user->setFullName('Test User');
        $this->user->setEmail('testuser@sascha-baecher.dev');
        $this->user->setPassword('example');
        $this->user->setRole('user');
        $this->user->setUserName('TestUser');
    }

    public function startTests(): bool
    {
        $testCreate = $this->testCreate();
        $testGetByEmail = $this->testGetByEmail();
        $testGetAll = $this->testAll();
        $testGetById = $this->testGetById();
        $testUpdate = $this->testUpdate();
        $testDelete = $this->testDelete();

        if (!(
            $testCreate
            || $testGetByEmail
            || $testGetAll
            || $testGetById
            || $testUpdate
            || $testDelete
        )) {
            return false;
        }

        return true;
    }

    public function testCreate(): bool
    {
        return $this->userRepository->create($this->user);
    }

    public function testUpdate(): bool
    {
        $this->user->setFullName('Test UserUpdate');
        $this->user->setEmail('testuser@sascha-baecher.devUpdate');
        $this->user->setPassword('exampleUpdate');
        $this->user->setRole('userUpdate');
        $this->user->setUserName('TestUserUpdate');

        if (!$this->userRepository->update($this->user)) {
            return false;
        }

        $updateUser = $this->userRepository->getById($this->user->getId());

        if (
            str_contains($updateUser->getFullName(), 'Update')
            && str_contains($updateUser->getEmail(), 'Update')
            && str_contains($updateUser->getPassword(), 'Update')
            && str_contains($updateUser->getRole(), 'Update')
            && str_contains($updateUser->getUserName(), 'Update')
        ) {
            return true;
        }

        return false;
    }

    public function testGetByEmail(): bool
    {
        $testUser = $this->userRepository->getByEmail('testuser@sascha-baecher.dev');

        if (empty($this->testUser)) {
            return false;
        }

        $this->user = $testUser;

        return false;
    }

    public function testAll(): bool
    {
        return count($this->userRepository->all()) > 0;
    }

    public function testDelete(): bool
    {
        return $this->userRepository->delete($this->user->getId());
    }

    public function testGetById(): bool
    {
        return !empty($this->userRepository->getById($this->user->getId()));
    }
}
