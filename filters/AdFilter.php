<?php 

namespace app\filters;

class AdFilter extends Filter
{
    public function location(int $value)
    {
        return $this->activeQuery->andWhere('location_id=:location_id', [':location_id' => $value]);
    }

    public function city(int $value)
    {
        return $this->activeQuery->andWhere('city_id=:city_id', [':city_id' => $value]);
    }

    public function category(int $value)
    {
        return $this->activeQuery->andWhere('category_id=:category_id', [':category_id' => $value]);
    }

    public function subcategory(int $value)
    {
        return $this->activeQuery->andWhere('subcategory_id=:subcategory_id', [':subcategory_id' => $value]);
    }

    public function price(int $value)
    {
        if ($value == 1) {
            return $this->activeQuery->andWhere('bargain=0');
        } else if ($value == 2) {
            return $this->activeQuery->andWhere('bargain=1');
        } else {
            return $this->activeQuery;
        }
    }

    public function currency(int $value)
    {
        return $this->activeQuery->andWhere('currency_id=:currency_id', [':currency_id' => $value]);
    }
}