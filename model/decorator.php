<?php
abstract class JModelDecorator extends JModel implements JModelDecoratorInterface
{
	protected $name = 'decorator';
	protected $chain;
	protected $model;

	/**
	 * Constructor.
	 *
	 * @param   string  $name  Optional name for this model instance.
	 */
	public function __construct($name = '')
	{
		if ($name != '')
		{
			$this->name = $name;
		}
	}

	/**
	 * Magic method forwarding function.
	 *
	 * If a 'before' . $methodName method exists it will be called before forwarding.
	 * If an 'after' . $methodName method exists it will be called after forwarding.
	 *
	 * Note: A maximum of 5 arguments will be forwarded in the method call.
	 *       Attempting to forward more than 5 will throw an exception.
	 *
	 * @param   string  $methodName  Method name called.
	 * @param   array   $arguments   Array of method arguments.
	 *
	 * @return  mixed Whatever the forwarded method returns.
	 * @throws  RuntimeException
	 */
	public function __call($methodName, array $arguments)
	{
		// Is the method being called a "before" something method?
		if (substr($methodName, 0, 6) == 'before')
		{
			// Invoke onBeforeModel[model-name][method-name]
			return $this->chain->invoke('before.' . substr($methodName, 6), $arguments[0]);
		}

		// Is the method being called an "after" something method?
		if (substr($methodName, 0, 5) == 'after')
		{
			// Invoke onAfterModel[model-name][method-name]
			return $this->chain->invoke('after.' . substr($methodName, 5), $arguments[0]);
		}

		// Assemble the context.
		$context = new JModelContext($this->name, $this->model);
		$context->setArguments($arguments);

		// Construct the names of the before and after methods.
		$beforeMethod = 'before' . ucfirst($methodName);
		$afterMethod = 'after' . ucfirst($methodName);

		// Execute the method, wrapped in the before and after method calls.
		if ($this->$beforeMethod($context) === true)
		{
			// Get argument list.
			$args = $context->getArguments();

			// Get the model.
			$model = $context->getModel();

			// Execute the requested method.
			switch (count($args))
			{
				case 0:
					$context->setResults($model->$methodName());
					break;
				case 1:
					$context->setResults($model->$methodName($args[0]));
					break;
				case 2:
					$context->setResults($model->$methodName($args[0], $args[1]));
					break;
				case 3:
					$context->setResults($model->$methodName($args[0], $args[1], $args[2]));
					break;
				case 4:
					$context->setResults($model->$methodName($args[0], $args[1], $args[2], $args[3]));
					break;
				case 5:
					$context->setResults($model->$methodName($args[0], $args[1], $args[2], $args[3], $args[4]));
					break;
				default:
					throw new RuntimeException('Too many arguments in method call to ' . $methodName);
			}

			// Execute the after method.
			$this->$afterMethod($context);
		}

		return $context->getResults();
	}

	/**
	 * Set the command chain.
	 *
	 * @param   JCommandChain  $chain  Command chain to use.
	 *
	 * @return  JModelDecorator This model for method chaining.
	 */
	public function setCommandChain(JCommandChain $chain)
	{
		$this->chain = $chain;

		return $this;
	}

	/**
	 * Set the inner model.
	 *
	 * @param   JModel  $model  Model to be wrapped inside this one.
	 *
	 * @return  JModelDecorator This model for method chaining.
	 */
	public function setInnerModel(JModel $model)
	{
		$this->model = $model;

		return $this;
	}

	/**
	 * Get an inner model.
	 *
	 * If a name is specified then the call will be forwarded so that the
	 * named model is returned.  If no name is specified then the next
	 * immediate inner model is returned.
	 *
	 * @param   string  $modelName  Optional name of the inner model to return.
	 *
	 * @return  JModel  The inner model requested.
	 * @throws  RuntimeException if the named inner model cannot be found.
	 */
	public function getInnerModel($modelName)
	{
		if ($modelName == '')
		{
			return $this->model;
		}

		if ($this->name == $modelName)
		{
			return $this;
		}

		if (!method_exists($this->model, 'getInnerModel'))
		{
			throw new RuntimeException('Inner model not found: ' . $modelName);
		}

		return $this->model->getInnerModel($modelName);
	}
}

