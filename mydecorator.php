<?php
class JModelMydecorator extends JModelDecorator
{
	protected $name = 'mydecorator';

	public function read(JRegistry $criteria)
	{
		echo __METHOD__ . "\n";

		return parent::read($criteria);
	}

}

