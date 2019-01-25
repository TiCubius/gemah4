<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Class QueryFilters
 *
 * @see https://medium.com/@mykeels/writing-clean-composable-eloquent-filters-edd242c82cc8
 */
class QueryFilters
{
	protected $request;

	/**
	 * @var Builder
	 */
	protected $builder;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply(Builder $builder)
	{
		$this->builder = $builder;
		foreach ($this->filters() as $name => $value) {
			if (!method_exists($this, $name)) {
				continue;
			}
			if (strlen($value)) {
				$this->$name($value);
			} else {
				$this->$name();
			}
		}
		return $this->builder;
	}

	public function filters()
	{
		return $this->request->all();
	}
}