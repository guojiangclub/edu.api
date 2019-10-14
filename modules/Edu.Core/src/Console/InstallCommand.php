<?php

/*
 * This file is part of ibrand/edu-core.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Edu\Core\Console;

use Illuminate\Console\Command;
use iBrand\Edu\Backend\Seeds\EduBackendMenuSeeder;
use DB;

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

        $this->call('vendor:publish',[0]);

        $this->call('storage:link');

        $this->call('ibrand:backend-install');

        $this->call('passport:install');

        if(!DB::table(config('admin.database.menu_table'))->where('title','在线教育')->first()){

            $this->call('db:seed', ['--class' => EduBackendMenuSeeder::class]);
        }

        $this->info('ibrand:edu-install successfully.');
    }
}
