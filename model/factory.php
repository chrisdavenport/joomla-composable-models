<?php
class JModelFactory
{
	public static function create(JCommandChain $chain, JModel $model, array $decorators = array())
	{
		foreach ($decorators as $decorator)
		{
			$model = $decorator->setCommandChain($chain)->setInnerModel($model);
		}

		return $model;
	}
}

