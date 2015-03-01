<?php
interface JModelDecoratorInterface
{
	public function setCommandChain(JCommandChain $chain);
	public function setInnerModel(JModel $model);
	public function getInnerModel($modelName);
}

