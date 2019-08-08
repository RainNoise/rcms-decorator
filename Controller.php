<?php

namespace Modules\Decorator;

use \App\Controller as BaseController;
use App\Core;
use ReflectionException;
use RuntimeException;


class Controller extends BaseController {
	/**
	 * Controller constructor.
	 * @param Core $core
	 * @throws ReflectionException
	 */
	public function __construct(Core $core) {
		parent::__construct($core);
	}

	/**
	 * @param $params
	 * @param $core
	 * @param $hook
	 */
	public function event_Decorate($params, $core, &$hook) {
		$hook = $this->core->compileTemplate($this->getTemplateFile($params['module'], $params['view']), $hook);
	}

	/**
	 * @param $params
	 * @param $core
	 * @param $hook
	 */
	public function event_AfterGlobalAction($params, $core, &$hook) {
		$hook = $this->core->compileTemplate($this->getTemplateFile('core', 'master'), $hook);
	}

	private function getTemplateFile($moduleName, $view) {
		return $this->themeDir() . '/' . "$moduleName.$view.php";
	}
	/**
	 * @return string
	 */
	private function themeDir() {
		return $this->getDataDir() . '/themes/' . $this->currentTheme();
	}

	/**
	 * @return string
	 */
	private function currentTheme(): string {
		return $this->cfg('theme');
	}

}