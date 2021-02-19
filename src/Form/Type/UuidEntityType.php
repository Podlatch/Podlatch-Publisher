<?php
/**
 *  _________________________
 * / made with <3 by kampfq  \
 * \ on 22.01.21 14:17       /
 *  -------------------------
 *                    \
 *                     `(งツ)ว
 */


namespace App\Form\Type;

use Doctrine\Persistence\ObjectManager;
use App\Form\Custom\ORMUuidQueryBuilderLoader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UuidEntityType extends EntityType
{
	public function getLoader(ObjectManager $manager, $queryBuilder, $class)
	{
		$platform = $queryBuilder->getEntityManager()->getConnection()->getDatabasePlatform();
		return new ORMUuidQueryBuilderLoader($queryBuilder, $platform);
	}
}