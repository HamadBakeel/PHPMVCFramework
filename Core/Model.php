<?php

namespace app\core;

abstract class Model
{
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function validate()
    {
        
    }
}