<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use App\Models\UserProject;
use Illuminate\Console\Command;

class DeleteProjectsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'projects:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete projects not related  user';

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
     * @return mixed
     */
    public function handle()
    {
        $projects = UserProject::whereNull('user_id')->get();

        foreach ($projects as $project) {
            if (Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }
            $project->delete();
        }
        
    }
}
