<?php

namespace App\Console\Commands\Stub;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateRepository extends StubBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-repository {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate new repository';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $model = $this->argument('model');
        $intefaceName = 'I'.Str::ucfirst($model).'Interface';
        $interfaceStubPath = __DIR__.'/../../../Stubs/RepositoryInterfaceStub.stub';
        $interfaceSavePath = __DIR__.'/../../../Repositories/Contracts/'.$intefaceName.'.php';
        $interfaceArgs = [
            'name' => $intefaceName,
        ];
        $this->info('Generating repositories for '.$model);
        $this->generateStubAndSave($interfaceStubPath, $interfaceArgs, $interfaceSavePath);

        $this->info('Interface => '.$interfaceSavePath);

        $repositoryName = Str::ucfirst($model).'Repository';
        $repositoryStubPath = __DIR__.'/../../../Stubs/RepositoryStub.stub';
        $repositorySavePath = __DIR__.'/../../../Repositories/'.$repositoryName.'.php';
        $interfaceArgs = [
            'model' => $model,
            'interface' => $intefaceName,
            'name' => $repositoryName,
        ];

        $this->generateStubAndSave($repositoryStubPath, $interfaceArgs, $repositorySavePath);

        $this->info('Repository => '.$repositorySavePath);
    }
}
