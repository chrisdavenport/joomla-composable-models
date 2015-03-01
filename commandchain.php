<?php
class JCommandChain
{
	public function invoke($command, JModelContext $context)
	{
		list($beforeAfter, $action) = explode('.', $command, 2);

		// Construct event name.
		$eventName = 'on'
			. ucfirst($beforeAfter)
			. ucfirst($context->type)
			. ucfirst($context->name)
			. ucfirst($action)
			;

		echo 'BEGIN COMMAND ' . $eventName . "\n";

		if ($context->name == 'mydecorator' && $beforeAfter == 'before')
		{
			$context->setModel($this->phoney($context->getModel()));
		}

		echo 'END COMMAND ' . $eventName . "\n";
		echo "\n\n";

		return true;
	}

	private function phoney($model)
	{
		$decorator = new JModelMydecorator3;

		return $decorator->setCommandChain($this)->setInnerModel($model);
	}
}

