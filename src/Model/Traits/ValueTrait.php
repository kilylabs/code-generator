<?php

namespace Krlove\CodeGenerator\Model\Traits;

/**
 * Trait PHPValueTrait
 * @package Krlove\CodeGenerator\Model\Traits
 */
trait ValueTrait
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string|null
     */
    public function renderValue()
    {
        return $this->renderTyped($this->value);
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    protected function renderTyped($value)
    {
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                $value = $value ? 'true' : 'false';

                break;
            case 'int':
                // do nothing

                break;
            case 'string':
                $value = sprintf('\'%s\'', addslashes($value));

                break;
            case 'array':
                $parts = [];
                $is_numeric = true;
                foreach ($value as $key=>$item) {
                    $parts[$key] = $this->renderTyped($item);
                }
                if(isset($key) && is_numeric($key)) {
                    $value = '[' . implode(', ', $parts) . ']';
                } else {
                    $value = '['."\n";
                    foreach($parts as $k=>$v) {
                        $value .= "\t\t\t'".$k."' => ".$v.",\n";
                    }
                    $value .= "\t\t".']';
                }

                break;
            default:
                $value = null; // TODO: how to render null explicitly?
        }

        return $value;
    }
}
