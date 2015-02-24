<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 6:00 PM
 */

namespace App\Libraries\Mitul\Generators\Generator;


use App\Libraries\Mitul\Generators\CommandData;
use Config;

class RepoControllerGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_controller', app_path('HTTP/Controllers/'));
		$this->namespace = Config::get('generator.namespace_controller', 'App\Http\Controllers');
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("ControllerRepo");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . "Controller.php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nController created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
		$templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

		return $templateData;
	}
}