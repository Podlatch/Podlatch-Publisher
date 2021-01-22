<?php
/**
 *  _________________________
 * / made with <3 by kampfq  \
 * \ on 22.01.21 14:15       /
 *  -------------------------
 *                    \
 *                     `(งツ)ว
 */


namespace App\Form\Custom;

use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityLoaderInterface;
use Symfony\Component\Form\Exception\LogicException;

class ORMUuidQueryBuilderLoader implements EntityLoaderInterface
{
	/**
	 * @var QueryBuilder
	 */
	private QueryBuilder $queryBuilder;

	/**
	 * @var AbstractPlatform
	 */
	private AbstractPlatform $platform;

	public function __construct(QueryBuilder $queryBuilder, AbstractPlatform $platform)
	{
		$this->queryBuilder = $queryBuilder;
		$this->platform = $platform;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEntities()
	{
		return $this->queryBuilder->getQuery()->execute();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getEntitiesByIds($identifier, array $values)
	{
		$qb = clone $this->queryBuilder;
		$alias = current($qb->getRootAliases());
		$parameter = 'ORMUuidQueryBuilderLoader_getEntitiesByIds_' . $identifier;
		$parameter = str_replace('.', '_', $parameter);
		$where = $qb->expr()->in($alias . '.' . $identifier, ':' . $parameter);

		// Guess type
		$entity = current($qb->getRootEntities());
		$metadata = $qb->getEntityManager()->getClassMetadata($entity);
		if ('uuid_binary_ordered_time' !== $metadata->getTypeOfField($identifier)) {
			throw new LogicException(sprintf(
				'ORMUuidQueryBuilderLoader supports uuid_binary_ordered_time identifiers only, %s given.',
				$metadata->getTypeOfField($identifier)
			));
		}

		$parameterType = Connection::PARAM_STR_ARRAY;

		$values = array_map(function ($value) {
            return Type::getType('uuid_binary_ordered_time')->convertToDatabaseValue($value, $this->platform);
			//return Type::getType('uuid_binary')->convertToDatabaseValue($value, $this->platform);
		}, array_values(array_filter($values, function ($v) {
			return '' !== (string)$v;
		})));

		if (!$values) {
			return [];
		}

		return $qb->andWhere($where)
			->getQuery()
			->setParameter($parameter, $values, $parameterType)
			->getResult();
	}
}
 