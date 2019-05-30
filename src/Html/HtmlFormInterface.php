<?php
declare(strict_types=1);

namespace WScore\FormModel\Html;

use ArrayAccess;
use IteratorAggregate;
use WScore\FormModel\Interfaces\ToStringInterface;
use WScore\Html\Tags\Choices;
use WScore\Html\Tags\Input;
use WScore\Html\Tags\Tag;

interface HtmlFormInterface extends ArrayAccess, IteratorAggregate
{
    /**
     * @param null|string|array|ArrayAccess $inputs
     * @param null|string|array|ArrayAccess $errors
     */
    public function setInputs($inputs, $errors = null);

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function fullName();

    /**
     * @return string
     */
    public function label();

    /**
     * @return string|array|mixed
     */
    public function value();

    /**
     * @return string|array|mixed
     */
    public function error();

    /**
     * @return Input|Tag|Choices
     */
    public function form();

    /**
     * @return Input[]
     */
    public function choices();

    /**
     * @return string
     */
    public function __toString();

    /**
     * @return bool
     */
    public function hasChildren(): bool;

    /**
     * @return HtmlFormInterface[]
     */
    public function getChildren(): array;

    /**
     * @param mixed $offset
     * @return $this|HtmlFormInterface
     */
    public function offsetGet($offset);

    /**
     * @return ToStringInterface|null
     */
    public function toString(): ?ToStringInterface;
}