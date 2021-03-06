<?php

/*
 * This file is part of ibrand/edu-backend.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Backend\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return config('auth.providers.users.model');
    }

    public function getUsersPaginate($where, $limit = 15)
    {
        $query = $this->scopeQuery(function ($query) use ($where) {
            if (count($where) > 0) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        list($operate, $va) = $value;
                        $query = $query->where($key, $operate, $va);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }

            return $query->orderBy('updated_at', 'desc');
        });

        if (0 == $limit) {
            return $query->all();
        }

        return $query->paginate($limit);
    }

    public function getUserByLoginName($loginName)
    {
        if (is_mail($loginName)) {
            return $this->findByField('email', $loginName)->first();
        }
        /*if (isUsername($loginName)) {

        }*/
        if (is_mobile($loginName)) {
            return $this->findByField('mobile', $loginName)->first();
        }

        return $this->findByField('user_name', $loginName)->first();
    }
}
