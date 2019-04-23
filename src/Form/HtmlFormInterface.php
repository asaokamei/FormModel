<?php
namespace WScore\FormModel\Form;

use ArrayAccess;

interface HtmlFormInterface extends ArrayAccess
{
    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function label();

    /**
     * @return string
     */
    public function value();

    /**
     * @return string
     */
    public function form();

    /**
     * @return self[]
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
}