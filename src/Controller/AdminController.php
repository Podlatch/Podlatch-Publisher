<?php
/**
 * Copyright (c) Benjamin Issleib 2017.
 * This file is part of the Podlatch Podcast Publisher.
 * Podlatch Podcast Publisher is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 *  Podlatch Podcast Publisher is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with the Podlatch Podcast Publisher. If not, see http://www.gnu.org/licenses/.
 */
/**
 * AdminController.php
 *
 * Made with <3 with PhpStorm
 * @author Benjamin Issleib
 * @copyright 2017 Benjamin Issleib
 * @license    GPLv3
 * @see
 * @since      File available since Release
 * @deprecated File deprecated in Release
 */

namespace App\Controller;
use AlterPHP\EasyAdminExtensionBundle\Controller\AdminController as BaseAdminController;
use Doctrine\ORM\QueryBuilder;
use App\Entity\PodcastShow;


class AdminController extends BaseAdminController
{
    protected function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    protected function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    protected function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    protected function preUpdatePodcastEntity($entity)
    {

        /**
         * @var $entity PodcastShow
         */
        $loggedInUser =  $this->get('security.token_storage')->getToken()->getUser();
        $entity -> addUser($loggedInUser);

        parent::persistEntity($entity);
    }

    protected function persistPodcastEntity($entity)
    {

        /**
         * @var $entity PodcastShow
         */
        $loggedInUser =  $this->get('security.token_storage')->getToken()->getUser();
        $entity -> addUser($loggedInUser);
        parent::updateEntity($entity);

    }

    protected function createPodcastListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter)
    {

        $loggedInUser =  $this->get('security.token_storage')->getToken()->getUser();
        /**
         * show only entities in list that are assigned to the logged in user
         * @var $queryBuilder QueryBuilder
         */
        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
        return $queryBuilder;
        $queryBuilder
            -> join('entity.users', 'user')
            ->andWhere('user.id = ?1')
            ->setParameter(1, $loggedInUser->getId());

        return $queryBuilder;
    }

    protected function createPodcastEpisodeListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter)
    {

        $loggedInUser =  $this->get('security.token_storage')->getToken()->getUser();
        /**
         * show only entities in list that are assigned to the logged in user
         * @var $queryBuilder QueryBuilder
         */
        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
        $queryBuilder
            -> join('entity.podcastShow', 'podcast')
            -> join('podcast.users', 'user')
            ->andWhere('user.id = ?1')
            ->setParameter(1, $loggedInUser->getId());

        return $queryBuilder;
    }

}
