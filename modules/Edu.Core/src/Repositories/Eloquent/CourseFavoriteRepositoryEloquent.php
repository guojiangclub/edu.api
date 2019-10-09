<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Repositories\Eloquent;

use iBrand\Edu\Core\Models\CourseFavorite;
use iBrand\Edu\Core\Repositories\CourseFavoriteRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseFavoriteRepositoryEloquent.
 */
class CourseFavoriteRepositoryEloquent extends BaseRepository implements CourseFavoriteRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseFavorite::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getFavoritesByUserId($userId, $sort = 'created_at', $order = 'desc', $limit = 15)
    {
        return $this->scopeQuery(function ($query) use ($sort, $order, $userId) {
            return $query
                ->where('user_id', $userId)
                ->orderBy($sort, $order);
        })->paginate($limit);
    }
}
