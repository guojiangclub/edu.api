<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) 果酱社区 <https://guojiang.club>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GuoJiangClub\Edu\Core\Console;

use DB;
use GuoJiangClub\Edu\Backend\Seeds\EduBackendMenuSeeder;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'ibrand:edu-install';

    protected $description = 'ibrand:edu-install.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('key:generate');

        //$this->call('vendor:publish',[0]);

        $this->call('storage:link');

        $this->call('ibrand:backend-install');

        $this->call('passport:keys');

        if (!DB::table(config('admin.database.menu_table'))->where('title', '在线教育')->first()) {
            $this->call('db:seed', ['--class' => EduBackendMenuSeeder::class]);
        }

        $this->info('ibrand:edu-install successfully.');
    }
}
