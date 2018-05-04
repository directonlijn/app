<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GitCommit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gitcommit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'git add ., git commit, git push -u origin master';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $commands = [
            // Add to git branch.
            'git add .',
            // Commit with generic message.
            'git commit --allow-empty -m "Update"',
            // Update local files before pushing.
            'git pull origin master',
            // Push if there were no merge problems.
            'git push -u origin master',
        ];

        foreach ($commands as $command) {
            $this->info($command);
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }
    }
}
