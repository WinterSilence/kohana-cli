<?php defined('SYSPATH') OR die('No direct script access.');
/**
 *
 */
abstract class Kohana_Controller_CLI {

	/**
	 *
	 */
	public $options = array();

	/**
	 *
	 */
	public function __construct(array $options = array())
	{
		$this->options = array_merge($this->options, $options);
	}

	/**
	 *
	 */
	public function before() {}

	/**
	 *
	 */
	public function after() {}

	/**
	 *
	 */
	public function execute()
	{
		
	}

}
