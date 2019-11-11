<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Repositories\Eloquent;

use GuoJiangClub\Edu\Core\Models\Category;
use GuoJiangClub\Edu\Core\Repositories\CategoryRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryRepositoryEloquent.
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getCategoryByCode($category)
    {
        return $this->findByField('code', $category)->first();
    }

    public function getRootCategories()
    {
        return $this->findByField('level', 0);
    }

    public function getCategoriesByLevel($level)
    {
        return $this->scopeQuery(function ($query) {
            return $query
                ->orderBy('weight', 'desc');
        })->findByField('level', $level);
    }
}
