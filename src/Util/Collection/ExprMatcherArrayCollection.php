<?php

namespace Deliverea\CoffeeMachine\Util\Collection;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;

abstract class ExprMatcherArrayCollection
{
    protected ArrayCollection $collection;
    protected Comparison $expr;

    public function __construct(ArrayCollection $collection)
    {
        $this->collection = $collection;
    }

    protected function buildComparison(string $attribute, string $value, string $operator): void
    {
        $this->expr = new Comparison($attribute, $operator, $value);
    }

    protected function match()
    {
        $criteria = (new Criteria())->where($this->expr);

        return $this->collection->matching($criteria);
    }
}