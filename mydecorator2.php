<?php
class JModelMydecorator2 extends JModelDecorator
{
	protected $name = 'mydecorator2';

	public function read(JRegistry $criteria)
	{
		echo __METHOD__ . "\n";

		return parent::read($criteria);
	}

}

