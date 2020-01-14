<?php

namespace QuetzalStudio\MapleSortable;

class MapleSortable
{
    /**
     * Request data for sort
     * 
     * @var array
     */
    private $sortRequest;
    
    /**
     * Default sort data
     * 
     * @var array
     */
    private $defaultSort;

    /**
     * Sort fields with real field name
     * 
     * @var array
     */
    private $sortFields;
    
    /**
     * Sort order (asc, desc)
     * 
     * @var array
     */
    private $sortOrders;
    
    /**
     * Sort fields with table name
     * 
     * @var array
     */
    private $fieldsTable;
    
    /**
     * Sort data for filter
     * 
     * @var array
     */
    private $sort;

    /**
     * Create a new sort intance
     * 
     * @param array $sortRequest
     * @param array $defaultSort
     * @param array $sortFields
     * @param array $fieldsTable
     */
    public function __construct(
        array $sortRequest,
        array $defaultSort,
        array $sortFields,
        array $fieldsTable
    )
    {
        $this->sortRequest = $sortRequest;
        $this->defaultSort = $defaultSort;

        $this->sortFields = $sortFields;
        $this->sortOrders = ['asc', 'desc'];
        $this->fieldsTable = $fieldsTable;

        $this->create();
    }

    /**
     * Check sort request
     * 
     * @return boolean
     */
    private function isValidRequest()
    {
        return (is_array($this->sortRequest) && count($this->sortRequest) == 2);
    }

    /**
     * Check sort field and sort order
     * 
     * @return boolean
     */
    private function isValidSort()
    {
        return $this->isValidField() && $this->isValidOrder();
    }

    /**
     * Check sort field available or not in field list
     * 
     * @return boolean
     */
    private function isValidField()
    {
        $fields = array_keys($this->sortFields);

        return in_array($this->sortRequest[0], $fields);
    }

    /**
     * Check sort order, asc or desc
     * 
     * @return boolean
     */
    private function isValidOrder()
    {
        return in_array($this->sortRequest[1], $this->sortOrders);
    }

    /**
     * Set sort from default or request
     * 
     * @return void
     */
    private function create()
    {
        $this->sort = $this->defaultSort;

        if ($this->isValidRequest() && $this->isValidSort()) {
            $this->sort = $this->sortRequest;
        }
    }

    /**
     * Get sort field (table_name.field_name)
     * 
     * @return string
     */
    public function getField()
    {
        if (is_null($this->fieldsTable[$this->sort[0]])) {
            return $this->sortFields[$this->sort[0]];
        }

        return $this->fieldsTable[$this->sort[0]].'.'.$this->sortFields[$this->sort[0]];
    }

    /**
     * Get sort order (asc or desc)
     * 
     * @return string
     */
    public function getOrder()
    {
        return $this->sort[1];
    }

    /**
     * Get sort filter
     * 
     * @return array
     */
    public function sort()
    {
        return $this->sort;
    }
}
