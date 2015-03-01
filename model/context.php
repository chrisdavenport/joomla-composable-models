<?php
class JModelContext extends JRegistry
{
	public function __construct($name, JModel $model)
	{
		$this->set('type', 'model');
		$this->set('name', $name);
		$this->set('model', $model);
		$this->set('results', null);
	}

	public function setModel(JModel $model)
	{
		$this->set('model', $model);

		return $this;
	}

	public function getModel()
	{
		return $this->get('model');
	}

	public function setCriteria(JRegistry $criteria)
	{
		$this->set('criteria', $criteria);

		return $this;
	}

	public function getCriteria()
	{
		return $this->get('criteria', new JRegistry);
	}

	public function setItems(Iterator $items = null)
	{
		$this->set('items', $items);

		return $this;
	}

	public function getItems()
	{
		return $this->get('items', new ArrayIterator(array()));
	}

	public function setResults(Iterator $results = null)
	{
		$this->set('results', $results);

		return $this;
	}

	public function getResults()
	{
		return $this->get('results', new ArrayIterator(array()));
	}

	public function setArguments(array $arguments)
	{
		$this->set('arguments', $arguments);

		return $this;
	}

	public function getArguments()
	{
		return $this->get('arguments');
	}
}

