<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {modelName} {--namespace=} {--api=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it takes modelName required , namespace & api  are optional params for web / api controllers & requests';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $ds = DIRECTORY_SEPARATOR;
        $name = $this->argument('modelName');
        $modelObject = Str::camel($name);
        $modelName = ucfirst($modelObject);
        $apiNamespace = $this->option('api');
        $this->info($this->createRepository($modelName, $ds));
        $this->info($this->createContract($modelName, $ds));
        $this->info($this->createApiController($modelName, $ds, $modelObject, $apiNamespace));
        $this->info($this->createApiRequest($modelName, $ds, $apiNamespace));
        $this->info($this->createResource($modelName, $ds));
    }


    public function createRepository($modelName, $ds): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/RepositoryTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getRepositoriesPath();
        $this->makeDirectory($directory . 'SQL');
        $filePath = $directory . 'SQL';
        $fileName = $modelName . 'Repository' . '.php';
        return $this->saveTemplateCopy($filePath, $fileName, $ds, $templateClass);
    }

    public function createContract($modelName, $ds): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/ContractTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getRepositoriesPath();
        $this->makeDirectory($directory . 'Contracts');
        $filePath = $directory . 'Contracts';
        $fileName = $modelName . 'Contract' . '.php';
        return $this->saveTemplateCopy($filePath, $fileName, $ds, $templateClass);
    }

    public function createController($modelName, $ds, $modelObject, $webNamespace = null, $apiNamespace = null): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/ControllerTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName, $webNamespace, $modelObject, $apiNamespace);
        $directory = $this->getControllerPath($webNamespace);
        $this->makeDirectory($directory);
        $fileName = $modelName . 'Controller' . '.php';
        return $this->saveTemplateCopy($directory, $fileName, $ds, $templateClass);
    }

    public function createApiController($modelName, $ds, $modelObject, $webNamespace = null): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/ApiControllerTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName, $webNamespace, $modelObject);
        $directory = $this->getApiControllerPath($webNamespace);
        $this->makeDirectory($directory);
        $fileName = $modelName . 'Controller' . '.php';
        return $this->saveTemplateCopy($directory, $fileName, $ds, $templateClass);
    }

    public function createRequest($modelName, $ds, $webNamespace = null): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/RequestTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName, $webNamespace);
        $directory = $this->getRequestPath($webNamespace);
        $this->makeDirectory($directory);
        $fileName = $modelName . 'Request' . '.php';
        return $this->saveTemplateCopy($directory, $fileName, $ds, $templateClass);
    }

    public function createApiRequest($modelName, $ds, $webNamespace = null): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/ApiRequestTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName, $webNamespace);
        $directory = $this->getApiRequestPath($webNamespace);
        $this->makeDirectory($directory);
        $fileName = $modelName . 'Request' . '.php';
        return $this->saveTemplateCopy($directory, $fileName, $ds, $templateClass);
    }

    public function createResource($modelName, $ds): string
    {
        $template = file_get_contents(__DIR__ . $ds . '/repositoryFilesTemplate/ApiResourceTemplate.stub');
        $templateClass = $this->replaceTemplateContent($template, $modelName);
        $directory = $this->getResourcePath();
        $this->makeDirectory($directory);
        $fileName = $modelName . 'Resource' . '.php';
        return $this->saveTemplateCopy($directory, $fileName, $ds, $templateClass);
    }

    public function replaceTemplateContent($template, $modelName, $webNamespace = null, $modelObject = null, $apiNamespace = null): array|string
    {
        $search = [
            '{{modelName}}',
            '{{namespace}}',
            '{{modelObject}}',
            '{{apiNamespace}}'
        ];
        $replace = [
            $modelName,
            (isset($webNamespace) && $webNamespace) ? '\\' . str_replace('/', '\\', $webNamespace) : '',
            $modelObject ?? '',
            (isset($apiNamespace) && $apiNamespace) ? '\\' . str_replace('/', '\\', $apiNamespace) : '',
        ];
        return str_replace($search, $replace, $template);
    }

    public function getRepositoriesPath(): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $appBase = app_path() . $ds;
        $repositoriesNamespace = 'Repositories' . $ds;
        return $appBase . $repositoriesNamespace;
    }

    public function getControllerPath($webNamespace = null): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $appBase = app_path() . $ds;
        $controllerNamespace = 'Http' . $ds . 'Controllers' . $ds;
        return $appBase . $controllerNamespace . $webNamespace;
    }

    public function getApiControllerPath($webNamespace = null): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $appBase = app_path() . $ds;
        $controllerNamespace = 'Http' . $ds . 'Controllers' . $ds . 'Api' . $ds;
        return $appBase . $controllerNamespace . $webNamespace;
    }

    public function getRequestPath($webNamespace = null): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $appBase = app_path() . $ds;
        $requestNamespace = 'Http' . $ds . 'Requests' . $ds;
        return $appBase . $requestNamespace . $webNamespace;
    }

    public function getApiRequestPath($webNamespace = null): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $appBase = app_path() . $ds;
        $requestNamespace = 'Http' . $ds . 'Requests' . $ds . 'Api' . $ds;
        return $appBase . $requestNamespace . $webNamespace;
    }

    public function getResourcePath(): string
    {
        $ds = DIRECTORY_SEPARATOR;
        $appBase = app_path() . $ds;
        $requestNamespace = 'Http' . $ds . 'Resources' . $ds;
        return $appBase . $requestNamespace;
    }

    public function makeDirectory($directory): ?bool
    {
        if (!is_dir($directory)) {
            return mkdir($directory, 0755, true);
        }
        return null;
    }

    public function saveTemplateCopy($filePath, $fileName, $ds, $template): string
    {
        file_put_contents($filePath . $ds . $fileName, $template);
        return $fileName . ' has been created';
    }
}
