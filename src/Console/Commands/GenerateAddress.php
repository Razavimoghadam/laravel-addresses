<?php
/*
 * This file is part of M.R.M
 *
 * (c) Mohsen Razavimoghadam <mohsen.razavimoghadam@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Rinvex\Addresses\Console\Commands;

use Illuminate\Config\Repository;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;

/**
 * Class GenerateAddress
 * @package Rinvex\Addresses\Console\Commands
 */
class GenerateAddress extends GeneratorCommand
{

    /**
     * @var string
     */
    protected $signature = 'rinvex:generate:model:addresses';

    /**
     * @var string
     */
    protected $description = 'Generate Address Model.';

    /**
     * GenerateAddress constructor.
     * @param Filesystem $files
     * @param Repository $config
     */
    public function __construct(Filesystem $files, Repository $config)
    {
        parent::__construct($files);
        $this->config = $config;
    }

    /**
     * @return bool|void|null
     */
    public function handle()
    {
        $this->runAddressBuilder();
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function runAddressBuilder()
    {
        $path = $this->getPathModelsAddress();

        $namespace = trim($this->config->get('rinvex.addresses.namespace.event'),'/');
        if (!isset ($namespace) || empty ($namespace))
            $namespace = 'App\Events';
        $addressContent = $this->buildAddress($namespace);

        $this->createFile($path, $addressContent);
    }


    /**
     * @return string
     */
    protected function getPathModelsAddress()
    {
        return __DIR__ . '/../../Models/Address.php';
    }

    /**
     * @param $namespace
     * @return GeneratorCommand|mixed|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildAddress($namespace = 'App\Events')
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this->replaceNamespace($stub, $namespace);

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/Address.stub';
    }

    /**
     * @param string $stub
     * @param string $name
     * @return GeneratorCommand|mixed|string
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace('DummyModelNamespace', $name, $stub);

        return $stub;
    }

    /**
     * @param $path
     * @param $content
     */
    protected function createFile($path, $content)
    {
        $this->files->put($path, $content);
    }
}
