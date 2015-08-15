<?php

namespace Silly\Data\LazyLoad;

use \Silly\Exceptions\ObjectLoadException,
    \Silly\Collections\Enumerable,
    \Silly\Linq\Query;

class HashSet extends Enumerable implements ISet
{
    
    private $type;
    private $is_primitive = false;

    public function __construct($type, $collection = []) {
        switch($type) {
            case "boolean":
            case "integer":
            case "double":
            case "string":
            case "resource":
                $this->is_primitive = true;
                break;
            case "array":
                break;
            case "object":
                if (!\class_exists($type, true) && !\interface_exists($type, true)) {
                    throw new ObjectLoadException("The object type '{$type}' can not be found.");
                }
                break;
        }
        
        $this->type = $type;
        
        $this->items = Query::from($collection)->distinct();
        
        if ($this->items->count() && !$this->items->all(function($item) use (&$this) {
            return $this->checkType($item);
        })) {
            throw new InvalidArgumentException("The collection has some items with different types.");
        }
    }
    
    private function checkType($item) {
        if($this->is_primitive) {
            switch($this->type) {
                case "boolean":
                    return \is_bool($item);
                case "integer":
                    return \is_integer($item);
                case "double":
                    return \is_double($item);
                case "string":
                    return \is_string($item);
                case "resource":
                    return \is_resource($item);
            }
        }
        
        return $this->type === get_class($item);
    }

}