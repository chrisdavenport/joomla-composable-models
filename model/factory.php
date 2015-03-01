<?php
class JModelFactory
{
	protected $model = null;

	public function __construct(JCommandChain $chain, JModel $datasource, array $decorators = array())
	{
		$this->model = $datasource;

		foreach ($decorators as $decorator)
		{
			$this->model = $decorator->setCommandChain($chain)->setInnerModel($this->model);
		}
	}

	public function getModel()
	{
		return $this->model;
	}
}

