<?php
class JModelDatabase extends JModel
{
	protected $database;
	protected $tableName;

	public function __construct(JDatabase $database, $tableName)
	{
		$this->database = $database;
		$this->tableName = $tableName;
	}

	public function create(Iterator $data)
	{
		echo __METHOD__ . "\n";
	}

	public function read(JRegistry $criteria)
	{
		echo __METHOD__ . "\n";
	}

	public function update(JRegistry $criteria, Iterator $data)
	{
		echo __METHOD__ . "\n";
	}

	public function delete(JRegistry $criteria)
	{
		echo __METHOD__ . "\n";
		print_r($criteria);
	}

	public function something(JSomething $criteria, JRegistry $another)
	{
		echo __METHOD__ . "\n";
		print_r($criteria);
		print_r($another);
	}
}

