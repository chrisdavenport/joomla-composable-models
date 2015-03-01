<?php
require_once 'model/model.php';
require_once 'model/decoratorinterface.php';
require_once 'model/decorator.php';
require_once 'model/database.php';
require_once 'model/context.php';
require_once 'mydecorator.php';
require_once 'mydecorator2.php';
require_once 'mydecorator3.php';
require_once 'commandchain.php';
require_once 'model/factory.php';

// A dummy database class.
class JDatabase {}

// A dummy registry class.
class JRegistry
{
	public function set($name, $value)
	{
		$this->$name = $value;
	}

	public function get($name, $default = '')
	{
		if (isset($this->$name))
		{
			return $this->$name;
		}

		return $default;
	}
}

// Create a sample model.
$modelFactory = new JModelFactory(
	new JCommandChain,
	new JModelDatabase(new JDatabase, 'articles'),
	array(
		new JModelMydecorator,
		new JModelMydecorator2,
	)
);

print_r($modelFactory->getModel());

// Try calling the read method.
class JSomething extends JRegistry {}
$params = new JSomething;
$params->set('a', 1);
$params->set('b', 2);
$modelFactory->getModel()->read($params);

