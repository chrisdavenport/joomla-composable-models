<?php
class JModelMydecorator3 extends JModelDecorator
{
	protected $name = 'mydecorator3';

	public function read(JRegistry $criteria)
	{
		echo __METHOD__ . "\n";

		return parent::read($criteria);
	}

}

