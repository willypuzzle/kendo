<?php

namespace Willypuzzle\Kendo\Classes\Grid;

use Willypuzzle\Kendo\Grid\Request;
use Illuminate\Support\Collection;

class Main {
    private $app;

    /**
     * Datatables request object.
     *
     * @var \Willypuzzle\Kendo\Grid\Request
     */
    protected $request;

    public function __construct($app)
    {
        $this->app = $app;
        $this->request = new Request($this->app['request']);
    }

    /**
     * Gets query and returns instance of class.
     *
     * @param  mixed $source
     * @return mixed
     * @throws \Exception
     */
    public static function of($source)
    {
        $datatables = app('willypuzzle.kendo.grid');
        $config     = app('config');
        $engines    = $config->get('kendo_grid.engines');
        $builders   = $config->get('kendo_grid.builders');

        if (is_array($source)) {
            $source = new Collection($source);
        }

        foreach ($builders as $class => $engine) {
            if ($source instanceof $class) {
                $class = $engines[$engine];

                return new $class($source, $datatables->getRequest());
            }
        }

        throw new \Exception('No available engine for ' . get_class($source));
    }

    /**
     * Get request object.
     *
     * @return \Willypuzzle\Kendo\Grid\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Datatables using Query Builder.
     *
     * @param \Illuminate\Database\Query\Builder|mixed $builder
     * @return \Willypuzzle\Kendo\Engines\Grid\QueryBuilderEngine
     */
    public function queryBuilder($builder)
    {
        return new \Willypuzzle\Kendo\Engines\Grid\QueryBuilderEngine($builder, $this->request);
    }

    /**
     * Datatables using Eloquent Builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder|mixed $builder
     * @return \Willypuzzle\Kendo\Engines\Grid\EloquentEngine
     */
    public function eloquent($builder){
        return new \Willypuzzle\Kendo\Engines\Grid\EloquentEngine($builder, $this->request);
    }


    /**
     * Datatables using Collection.
     *
     * @param \Illuminate\Support\Collection|mixed $collection
     * @return \Willypuzzle\Kendo\Engines\Grid\CollectionEngine
     */
    public function collection($collection)
    {
        if (is_array($collection)) {
            $collection = new Collection($collection);
        }

        return new \Willypuzzle\Kendo\Engines\Grid\CollectionEngine($collection, $this->request);
    }
}