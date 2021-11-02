<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SetAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-admin-user
                            {id : User ID}
                            {--U|unset : Make user not an administrator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make user an admin (by given user ID)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = (int)$this->argument('id');
        $unset = $this->option('unset');

        try {
            $user = User::findOrFail($userId);
            $user->is_admin = (int)!$unset;
            $user->save();
        } catch (ModelNotFoundException $e) {
            $this->error("Can't find specified user ID");
            return Command::FAILURE;
        } catch (Exception $e) {
            $this->error('Something went wrong!');
            return Command::FAILURE;
        }

        $this->info('The command was successful!');
        return Command::SUCCESS;
    }
}
