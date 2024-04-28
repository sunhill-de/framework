<?php

namespace Sunhill\Framework\Crud;

use Sunhill\Framework\Response\ViewResponses\ViewResponse;

class CrudListResponse extends ViewResponse
{
    
    protected $template = 'framework::crud.list';
    
    protected $engine;
    
    public function __construct(AbstractCrudEngine $engine)
    {
        $this->engine = $engine;
    }
    
    /**
     * Offset indicates wich should be the first entry depending on order and filter
     * 
     * @var integer
     */
    protected $offset = 0;
    
    /**
     * Setter for offset
     * 
     * @param int $offset
     * @return self
     */
    public function setOffset(int $offset): self
    {
        $this->offset = $offset;    
        return $this;
    }
    
    /**
     * Limit indicates how many entries should be displayed
     * 
     * @var integer
     */
    protected $limit = 10;
    
    /**
     * Setter of $limit
     * 
     * @param int $limit
     * @return \Sunhill\Framework\Crud\CrudListResponse
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * Indicates the ordering of fields
     * 
     * @var unknown
     */
    protected $order;
    
    /**
     * Setter for $order
     * 
     * @param string $order
     * @return self
     */
    public function setOrder(string $order): self
    {
        $this->order = $order;
        return $this;
    }
    
    /**
     * Indicates if there is a filter on the dataset
     * 
     * @var unknown
     */
    protected $filter;
    
    /**
     * Setter for filter
     * 
     * @param string $filter
     * @return self
     */
    public function setFilter(string $filter): self
    {
        $this->filter = $filter;
        return $this;
    }
    
    /**
     * For links into this dataset what base should be used
     * 
     * @var unknown
     */
    protected $route_base;
    
    /**
     * Sette for route_base
     * 
     * @param string $route_base
     * @return self
     */
    public function setRouteBase(string $route_base): self
    {
        $this->route_base = $route_base;
        return $this;
    }
    
    /**
     * Sometimes the given route has some extra parameters that are not in crud control. These can be stored here
     * 
     * @var array
     */
    protected $route_params = [];
    
    /**
     * Setter for $route_params
     * 
     * @param array $params
     * @return self
     */
    public function setRouteParams(array $params): self
    {
       $this->route_params = $params;
       return $this;
    }
    
    /**
     * Indicates if the entries should be "showable" (meaning is there a show route)
     * @var boolean
     */
    protected $enable_show = false;
    
    /**
     * Indicates if the entries should be "editable"
     * @var boolean
     */
    protected $enable_edit = false;
    
    /**
     * Indicates if the entries should be deleteable
     * @var boolean
     */
    protected $enable_delete = false;
    
    /**
     * Indicates if there should be the possibility for user filters. These are individual filter conditions that could be stored 
     * permanent of temporary
     * @var boolean
     */
    protected $enable_userfilters = false;
    
    /**
     * Setter for enable_show
     * 
     * @return self
     */
    public function enableShow(): self
    {
        $this->enable_show = true;
        return $this;
    }
    
    /**
     * Setter for enable_edit
     *
     * @return self
     */
    public function enableEdit(): self
    {
        $this->enable_edit = true;
        return $this;
    }
    
    /**
     * Setter for enable_delete
     *
     * @return self
     */
    public function enableDelete(): self
    {
        $this->enable_delete = true;
        return $this;
    }
    
    /**
     * Setter for enable_edit
     *
     * @return self
     */
    public function enableUserfilters(): self
    {
        $this->enable_userfilters = true;
        return $this;
    }

    private function getColumnSortLink($column)
    {
        $lokal_params = [
            'offset'=>0,
            'limit'=>$this->limit,
            'order'=>$column,
        ];
        if (!is_null($this->filter)) {
            $lokal_params['filter'] = $this->filter;
        }
        return route($this->route_base.'.list', array_merge($this->route_params, $lokal_params));        
    }
    
    protected function getColumns()
    {
        $columns = $this->engine->getColumns();
        $return = [];
        foreach ($columns as $column=>$type) {
            $entry = new \StdClass();
            $entry->name = $column;
            $entry->title = $this->engine->getColumnTitle($column);
            $entry->class = $type;
            if ($entry->sortable = $this->engine->isSortable($column)) {
                $entry->link = $this->getColumnSortLink($column);
            }
            $return[] = $entry;
        }
        return $return;
    }
    
    protected function getDataRows()
    {
        return [];    
    }
    
    protected function getViewElements(): array
    {
        return [
            'element_count'=>$this->engine->getElementCount($this->filter),
            'columns'=>$this->getColumns(),
            'datarows'=>$this->getDataRows(),            
        ];
    }
}