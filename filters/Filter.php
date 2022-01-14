<?php

namespace app\filters;

use yii\db\ActiveQuery;

class Filter
{
    protected $activeQuery;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function apply(ActiveQuery $activeQuery)
    {
        $this->activeQuery = $activeQuery;
        $filters = $this->filters();

        foreach ($filters as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->activeQuery;
    }

    private function filters()
    {
        $data = $this->request->get();
        $filters = [];
        foreach ($data as $key => $item) {
            if ($item != 0) {
                $filters[$key] = $item;
            }
        }

        return $filters;
    }
}