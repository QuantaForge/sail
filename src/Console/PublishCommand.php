<?php

namespace QuantaForge\Sail\Console;

use QuantaForge\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sail:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the QuantaForge Sail Docker files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', ['--tag' => 'sail-docker']);
        $this->call('vendor:publish', ['--tag' => 'sail-database']);

        file_put_contents(
            $this->quantaforge->basePath('docker-compose.yml'),
            str_replace(
                [
                    './vendor/quantaforge/sail/runtimes/8.3',
                    './vendor/quantaforge/sail/runtimes/8.2',
                    './vendor/quantaforge/sail/runtimes/8.1',
                    './vendor/quantaforge/sail/runtimes/8.0',
                    './vendor/quantaforge/sail/database/mysql',
                    './vendor/quantaforge/sail/database/pgsql'
                ],
                [
                    './docker/8.3',
                    './docker/8.2',
                    './docker/8.1',
                    './docker/8.0',
                    './docker/mysql',
                    './docker/pgsql'
                ],
                file_get_contents($this->quantaforge->basePath('docker-compose.yml'))
            )
        );
    }
}
