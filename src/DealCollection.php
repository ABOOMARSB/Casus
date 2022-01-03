<?php

namespace App;

use App\Entity\Deal;
use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

class DealCollection extends ArrayCollection
{
    static function fromArrayCollection(ArrayCollection $collection) {
        return new self($collection->toArray());
    }

//    public function getDealsSortedByCity() {
//        $array = $this->toArray();
//        usort($array, function (Deal $first, Deal $second) {
//            return $first->getCity()->getName() <=> $second->getCity()->getName();
//        });
//
//        return $array;
//    }

//    public function getDealsSortedByCategory() {
//        $array = $this->toArray();
//        usort($array, function (Deal $first, Deal $second) {
//            return $first->getCategory()->getSort() <=> $second->getCategory()->getSort();
//        });
//
//        public function getCategory() {
//            return getCategory();
//        }
//
//        return $array;
//    }
}