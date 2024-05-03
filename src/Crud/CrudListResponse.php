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
     * Indicates the ordering direction of fields
     * 
     * @var string
     */
    protected $order_dir = 'asc';
    
    /**
     * Setter for $order
     * 
     * @param string $order
     * @return self
     */
    public function setOrder(string $order): self
    {
        if ($order[0] == '!') {
            $this->order = substr($order,1);
            $this->order_dir = 'desc';
            return $this;
        }
        $this->order = $order;
        $this->order_dir = 'asc';
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
     * Indicates if there should be a fulltext search field
     * @var boolean
     */
    protected $enable_search = false;
    
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

    /**
     * Setter for enable_search
     * @return self
     */
    public function enableSearch(): self
    {
        $this->enable_search = true;
        return $this;
    }
    
    /**
     * Stores the names and routes of methods that can be performed on more than one list
     * entry.
     * 
     * @var array
     */
    protected $group_actions = [];
    
    /**
     * Setter for group_actions
     * 
     * @param array $group_actions
     * @return self
     */
    public function setGroupActions(array $group_actions): self
    {
        $this->group_actions = $group_actions;
        return $this;
    }
    
    protected function doRoute($addition, $params)
    {
        return route($this->route_base.'.'.$addition, array_merge($this->route_params,$params));    
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
        return $this->doRoute('list', $lokal_params);        
    }
    
    /**
     * Assembles the data for the table header that includes the caption of the columns and
     * (if sortable) the link to the sort field
     * 
     * @return unknown[]|\StdClass[]
     */
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
        if ($this->enable_show) {
            $entry->name = '';
            $entry->title = ' ';
            $entry->class = 'link';            
            $return[] = $entry;
        }
        if ($this->enable_edit) {
            $entry->name = '';
            $entry->title = ' ';
            $entry->class = 'link';
            $return[] = $entry;
        }
        if ($this->enable_delete) {
            $entry->name = '';
            $entry->title = ' ';
            $entry->class = 'link';
            $return[] = $entry;
        }
        return $return;
    }
    
    protected function addLink(string $kind, string $title, $id)
    {
        $link = new \StdClass();
        $link->class = 'link '.$kind;
        $link->data = ['title'=>$title, 'link'=>$this->doRoute($kind, ['id'=>$id])];
        return $link;
    }
    
    protected function getDataRows()
    {
        $columns = $this->engine->getColumns();
        $data = $this->engine->getListEntries($this->offset, $this->limit, $this->order, $this->order_dir, $this->filter);
        
        $result = [];
        foreach ($data as $data_row) {
            $row = [];
            foreach ($data_row as $key => $value) {
                $column_data = new \StdClass();
                $column_data->data = $value;
                $column_data->id = $key;
                if (($column_data->class = $columns[$key]) == 'id') {
                    $id = $value; 
                }
                $row[] = $column_data;
            }
            if ($this->enable_show) {
                $row[] = $this->addLink('show','show',$id);
            }
            if ($this->enable_edit) {
                $row[] = $this->addLink('edit','edit',$id);
            }
            if ($this->enable_delete) {
                $row[] = $this->addLink('delete','delete',$id);
            }
            $result[] = $row;
        }
        return $result;    
    }
    
    /**
     * Creates a entry for the filter list
     * 
     * @param string $value
     * @param string $name
     * @return \StdClass
     */
    protected function getFilterEntry(string $value, string $name)
    {
        $entry = new \StdClass();
        $entry->value = $value;
        $entry->name = $name;
        return $entry;
    }
    
    /**
     * Creates the filter list or returns an empty list if there are none
     * 
     * @return array
     */
    protected function getFilters(): array
    {
        $filters = $this->engine->getFilters();
        $result = [];
        foreach ($filters as $filter => $name) {
            $result[] = $this->getFilterEntry($filter, $name);
        }
        if ($this->enable_userfilters) {
            $result[] = $this->getFilterEntry('userfilter','user defined filter...');            
        }
        return $result;
    }
    
    // ************************************ Paginator ****************************************
    protected function getPaginatorEntry(string $type, string $title, ?string $link = null)
    {
        $result = new \StdClass();
        $result->type = $type;
        if (!empty($link)) {
           $result->link = $link;
        }
        $result->title = $title;
        return $result;
    }
    
    protected function getPaginatorLink(int $offset, string $title)
    {
        return $this->getPaginatorEntry('link', $title, $this->doRoute('list', [
            'offset'=>$offset,
            'limit'=>$this->limit,
            'filter'=>$this->filter,
            'order'=>$this->order
        ]));
    }
    
    /**
     * Returns ths page nummer for the page that belongs to offset $offset
     * 
     * @param int $offset
     * @return number
     */
    protected function getPage(int $offset): int
    {
        return intval($offset/$this->limit)+1;    
    }

    /**
     * Checks if there is a "prev" page in this paginator (It is not if the current page is
     * the first page)
     * 
     * @param unknown $result
     */
    protected function checkForPrevPage(&$result)
    {
        if ($this->offset > 0) {
            $result[] = $this->getPaginatorLink($this->offset-$this->limit, 'prev');
        }
    }
    
    /**
     * Checks if there is a "next" page in this pagintor (It is not if the current page ist
     * teh last one)
     * 
     * @param unknown $result
     */
    protected function checkForNextPage(&$result)
    {
        if (($this->offset+$this->limit) < $this->engine->getElementCount($this->filter)) {
            $result[] = $this->getPaginatorLink($this->offset+$this->limit, 'next'); 
        }
    }
    
    /**
     * Adds an paginator entry for a page to $result. If $page is the current page
     * it marks it so
     * 
     * @param array $result
     * @param int $current
     * @param int $page
     */
    protected function addPageEntry(array &$result, int $current, int $page)
    {
        if ($page == $current) {
            $result[] = $this->getPaginatorEntry('current', $page);
        } else {
            $result[] = $this->getPaginatorLink(($page-1)*$this->limit, $page);
        }        
    }
    
    /**
     * Inserts a paginator without an ellipse (less than 12 entries)
     * 
     * @param int $page_count
     * @return array
     */
    protected function getNoEllipsePaginator(int $page_count): array
    {
        $result = [];
        $this->checkForPrevPage($result);
        $current = $this->getPage($this->offset);
        for ($i=1;$i<=$page_count;$i++) {
            $this->addPageEntry($result, $current, $i);
        }
        $this->checkForNextPage($result);
        return $result;
    }
    
    /**
     * Adds pagintor entries to $result for pages from $from till $till and marks them as 
     * current if it is so
     * 
     * @param unknown $result
     * @param int $current
     * @param int $from
     * @param int $till
     */
    protected function addPageEntries(&$result, int $current, int $from, int $till)
    {
        for ($i=$from;$i<=$till;$i++) {
            $this->addPageEntry($result, $current, $i);
        }
    }
    
    /**
     * Adds an ellipse entry to $result
     * 
     * @param array $result
     */
    protected function addEllipse(array &$result)
    {
        $result[] = $this->getPaginatorEntry('ellipse', '...');    
    }
    
    /**
     * Creates a paginator with at least one ellipse (more than 11 pages)
     * 
     * @param int $page_count
     * @return array
     */
    protected function getEllipsePaginator(int $page_count): array
    {
         $result = [];
         $this->checkForPrevPage($result);
         $current = $this->getPage($this->offset);
         $this->addPageEntry($result, $current, 1);
         if ($current < 6) {
             $this->addPageEntries($result, $current, 2, 10);
             $this->addEllipse($result);
         } else if ($current > $page_count - 10) {
             $this->addEllipse($result);
             $this->addPageEntries($result, $current, $page_count -10 , $page_count -1);             
         } else {
             $this->addEllipse($result);
             $this->addPageEntries($result, $current, $current - 5 , $current + 5);
             $this->addEllipse($result);             
         }
         $this->addPageEntry($result, $current, $page_count);         
         $this->checkForNextPage($result);          
         return $result;
    }
    
    /**
     * Returns the number of pages of this paginator
     * 
     * @return number
     */
    public function getPageCount()
    {
        return intval(ceil($this->engine->getElementCount($this->filter)/$this->limit));
    }
    
    /**
     * Depending on how many pages there are insert no paginator, a paginator without ellipse or
     * a paginator with at least one ellipse
     * 
     * @return array
     */
    protected function getPaginator(): array
    {
        $page_count = $this->getPageCount();
        if ($page_count < 2) {
            return [];
        }
        if ($page_count <= 11) {
            return $this->getNoEllipsePaginator($page_count);
        }
        return $this->getEllipsePaginator($page_count);
    }
    
    protected function getSearch(): array
    {
        return [];    
    }
    
    protected function getViewElements(): array
    {
        return [
            'element_count'=>$this->engine->getElementCount($this->filter),
            'columns'=>$this->getColumns(),
            'datarows'=>$this->getDataRows(),
            'filters'=>$this->getFilters(),
            'search'=>$this->getSearch(),
            'pagination'=>$this->getPaginator()
        ];
    }
}