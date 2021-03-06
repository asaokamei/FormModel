<?php
declare(strict_types=1);

namespace WScore\FormModel\ToString;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use IteratorAggregate;
use Traversable;
use WScore\FormModel\Element\ElementInterface;
use WScore\FormModel\Html\HtmlFormInterface;
use WScore\Validator\Interfaces\ResultInterface;

class ViewModel implements ArrayAccess, IteratorAggregate
{
    /**
     * @var ToStringFactoryInterface
     */
    private $toString;

    /**
     * @var HtmlFormInterface
     */
    private $html;

    /**
     * @var ElementInterface
     */
    private $element;

    /**
     * @var ResultInterface
     */
    private $result;

    /**
     * @var ToStringFactoryInterface
     */
    private $factory;

    public function __construct(ToStringFactoryInterface $factory, HtmlFormInterface $html, ResultInterface $result = null)
    {
        $this->factory = $factory;
        $this->toString = $factory->create($html, $result);
        $this->html = $html;
        $this->element = $html->getElement();
        $this->result = $result;
    }

    public function hasError(): bool
    {
        if ($this->result) {
            return !$this->result->isValid();
        }
        return false;
    }

    public function show(): string
    {
        if ($this->element->isFormType()) {
            return $this->showForm();
        }
        return $this->row();
    }

    private function showForm(): string
    {
        $html = $this->label() . $this->error();
        foreach ($this->getIterator() as $item) {
            $html .= $item->show();
        }
        return $html;
    }

    public function row(): string
    {
        return $this->toString->row();
    }

    public function label(): string
    {
        return $this->toString->label();
    }

    public function widget(): string
    {
        return $this->toString->widget();
    }

    public function error(): string
    {
        return $this->toString->error();
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->html->has($offset);
    }

    /**
     * @param string $offset
     * @return ViewModel
     */
    public function offsetGet($offset)
    {
        $html = $this->html->get($offset);
        return $html
            ? new ViewModel($this->factory, $html, $this->result[$offset] ?? null)
            : null;
    }

    /**
     * @param string $offset
     * @param ViewModel $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException('cannot set new html.');
    }

    /**
     * @param string
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new BadMethodCallException('cannot unset html.');
    }

    /**
     * @return Traversable|ViewModel[]
     */
    public function getIterator()
    {
        $list = [];
        foreach ($this->html->getChildren() as $name => $child) {
            $list[] = new ViewModel($this->factory, $child, $this->result[$name] ?? null);
        };
        return new ArrayIterator($list);
    }

    public function __toString()
    {
        return $this->row();
    }
}