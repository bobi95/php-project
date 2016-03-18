<?php

namespace App\Helpers;

/**
 * Class DataTablesParser
 *
 * @package App\Libs
 */
class DataTablesParser
{
	protected $data;

	protected $fieldsMap = [];

	public function __construct(array $data, array $fieldsMap = NULL)
	{
		$this->data = $data;

		if (!is_null($fieldsMap))
			$this->fieldsMap = $fieldsMap;
	}

	public function isValid()
	{
		return array_key_exists('draw', $this->data)
			&& array_key_exists('start', $this->data)
			&& array_key_exists('length', $this->data)
			&& array_key_exists('columns', $this->data);
	}

	public function getOffset()
	{
		return (int) $this->data['start'];
	}

	public function getRequestId()
	{
		return (int) $this->data['draw'];
	}

	public function getLimit()
	{
		return (int) $this->data['length'];
	}

	/**
	 * Do we have any ordering requested by data tables?
	 *
	 * @return bool
	 */
	public function hasOrder()
	{
		return !empty($this->data['order']);
	}

	/**
	 * Get ordering requested by data tables
	 *
	 * @return array
	 */
	public function getOrders()
	{
		$orders = [];

		foreach ($this->data['order'] as $order)
		{
			if (!($column = $this->getColumn($order['column'])) || !$column['orderable'])
				continue;

			$orders[$this->getColumnName($column)] = $order['dir'];
		}

		return $orders;
	}

	/**
	 * Do we have a search filter
	 *
	 * @return bool
	 */
	public function hasFilter()
	{
		return !empty($this->data['search']['value']) && is_string($this->data['search']['value']);
	}

	/**
	 * Returns the searching criteria
	 *
	 * @return string
	 */
	public function getFilter()
	{
		return $this->data['search']['value'];
	}

	/**
	 * Get column by index
	 *
	 * @param int $index
	 *
	 * @return array
	 */
	public function getColumn($index)
	{
		if ((!is_int($index) && !is_string($index)) || !ctype_digit((string) $index) || !array_key_exists((int) $index, $this->data['columns']))
			return NULL;

		$index	= (int) $index;
		$column	= $this->data['columns'][$index];

		if (
			   !array_key_exists('data', $column)
			|| !array_key_exists('name', $column)
			|| !array_key_exists('orderable', $column)
			|| !array_key_exists('searchable', $column)
		)
			return NULL;

		return [
			'id'			=> $index,
			'data'			=> ctype_digit($column['data']) ? (int) $column['data'] : $column['data'],
			'name'			=> $column['name'],
			'orderable'		=> $column['orderable'] === 'true',
			'searchable'	=> $column['searchable'] === 'true',
		];
	}

	/**
	 * Resolves column name to use from column data using fields map
	 *
	 * @param array $column
	 *
	 * @return string
	 */
	protected function getColumnName($column)
	{
		if (array_key_exists($column['data'], $this->fieldsMap))
			return $this->fieldsMap[$column['data']];

		if (array_key_exists($column['id'], $this->fieldsMap))
			return $this->fieldsMap[$column['id']];

		return $column['data'] !== '' ? $column['data'] : $column['id'];
	}
}