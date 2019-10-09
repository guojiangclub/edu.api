<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Listeners\Notifications;

class NotificationsListener
{
    public function subscribe($events)
    {
        $events->listen(
            'edu.course.order.success.wechat.notification',
            'iBrand\Edu\Core\Listeners\Notifications\CourseOrderSuccess'
        );

    }
}
