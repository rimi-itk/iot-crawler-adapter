<?php

/*
 * This file is part of itk-dev/iot-crawler-adapter.
 *
 * (c) 2020 ITK Development
 *
 * This source file is subject to the MIT license.
 */

namespace App\DataFixtures\Loriot;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Loriot\DataManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Guard\Token\PostAuthenticationGuardToken;

class PayloadFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var DataManager */
    private $dataManager;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(DataManager $dataManager, TokenStorageInterface $tokenStorage)
    {
        $this->dataManager = $dataManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference('user:loriot');
        $token = new PostAuthenticationGuardToken($user, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        $finder = (new Finder())
            ->name('*.json')
            ->in(__DIR__.'/payload');
        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            $payload = json_decode(file_get_contents($file->getRealPath()), true);
            $dataFormat = basename($file->getPath());
            $this->dataManager->handle($payload, 'data', $dataFormat);
        }
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
