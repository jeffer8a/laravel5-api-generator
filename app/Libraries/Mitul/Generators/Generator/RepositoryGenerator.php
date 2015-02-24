<?php
/**
 * User: Mitul
 * Date: 16/02/15
 * Time: 1:48 PM
 */

namespace App\Libraries\Mitul\Generators\Generator;


use App\Libraries\Mitul\Generators\CommandData;
use Config;

class RepositoryGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_repository', app_path('/Libraries/Repositories/'));
		$this->namespace = Config::get('generator.namespace_repository', 'App\Libraries\Repositories');
	}

	function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Repository");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . "Repository.php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nRepository created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
		$templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);

		return $templateData;
	}

}