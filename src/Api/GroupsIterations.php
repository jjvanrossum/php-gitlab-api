<?php

declare(strict_types=1);

/*
 * This file is part of the Gitlab API library.
 *
 * (c) Matt Humphrey <matth@windsor-telecom.co.uk>
 * (c) Graham Campbell <hello@gjcampbell.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gitlab\Api;

class GroupsIterations extends AbstractApi
{
    /**
     * @var string
     */
    public const STATE_ALL = 'all';

    /**
     * @var string
     */
    public const STATE_OPENED = 'opened';

    /**
     * @var string
     */
    public const STATE_CLOSED = 'closed';

    /**
     * @param int|string $group_id
     * @param array      $parameters {
     *
     *     @var int[]  $iids   return only the iterations having the given iids
     *     @var string $state  return only active or closed iterations
     *     @var string $search Return only iterations with a title or description matching the provided string.
     * }
     *
     * @return mixed
     */
    public function all($group_id, array $parameters = [])
    {
        $resolver = $this->createOptionsResolver();
        $resolver->setDefined('iids')
            ->setAllowedTypes('iids', 'array')
            ->setAllowedValues('iids', function (array $value) {
                return \count($value) === \count(\array_filter($value, 'is_int'));
            })
        ;
        $resolver->setDefined('state')
            ->setAllowedValues('state', [self::STATE_ALL, self::STATE_OPENED, self::STATE_CLOSED])
        ;
        $resolver->setDefined('search');
        $resolver->setDefined('updated_after');
        $resolver->setDefined('in');

        return $this->get('groups/'.self::encodePath($group_id).'/iterations', $resolver->resolve($parameters));
    }

    /**
     * @param int|string $group_id
     * @param int        $epic_id
     *
     * @return mixed
     */
    public function show($group_id, int $epic_id)
    {
        return $this->get('groups/'.self::encodePath($group_id).'/iterations/'.self::encodePath($epic_id));
    }

    /**
     * @param int|string $group_id
     * @param array      $params
     *
     * @return mixed
     */
    public function create($group_id, array $params)
    {
        return $this->post('groups/'.self::encodePath($group_id).'/iterations', $params);
    }

    /**
     * @param int|string $group_id
     * @param int        $epic_id
     * @param array      $params
     *
     * @return mixed
     */
    public function update($group_id, int $epic_id, array $params)
    {
        return $this->put('groups/'.self::encodePath($group_id).'/iterations/'.self::encodePath($epic_id), $params);
    }

    /**
     * @param int|string $group_id
     * @param int        $epic_id
     *
     * @return mixed
     */
    public function remove($group_id, int $epic_id)
    {
        return $this->delete('groups/'.self::encodePath($group_id).'/iterations/'.self::encodePath($epic_id));
    }

    /**
     * @param int|string $group_id
     * @param int        $epic_iid
     *
     * @return mixed
     */
    public function issues($group_id, int $epic_iid)
    {
        return $this->get('groups/'.self::encodePath($group_id).'/iterations/'.self::encodePath($epic_iid).'/issues');
    }

    /**
     * @param int|string $group_id
     * @param int        $epic_iid
     *
     * @return mixed
     */
    public function showDiscussions($group_id, int $epic_iid)
    {
        return $this->get('groups/'.self::encodePath($group_id).'/iterations/'.self::encodePath($epic_iid).'/discussions');
    }

    /**
     * @param int|string $group_id
     * @param int        $epic_iid
     *
     * @return mixed
     */
    public function showNotes($group_id, int $epic_iid)
    {
        return $this->get('groups/'.self::encodePath($group_id).'/iterations/'.self::encodePath($epic_iid).'/notes');
    }
}