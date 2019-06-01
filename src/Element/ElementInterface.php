<?php
declare(strict_types=1);

namespace WScore\FormModel\Element;

use WScore\FormModel\Html\HtmlFormInterface;
use WScore\FormModel\Validation\Validator;

interface ElementInterface
{
    /**
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired(bool $required = true): ElementInterface;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return bool
     */
    public function isFormType(): bool;

    /**
     * @return bool
     */
    public function isRepeatedForm(): bool;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param string $label
     * @return ElementInterface
     */
    public function setLabel(string $label): ElementInterface;

    /**
     * @return Validator
     */
    public function createValidation(): Validator;

    /**
     * @param null|array|string $inputs
     * @param null|array|string $errors
     * @return HtmlFormInterface
     */
    public function createHtml($inputs = null, $errors = null): HtmlFormInterface;

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param array $attributes
     * @return ElementInterface
     */
    public function setAttributes(array $attributes): ElementInterface;

    /**
     * @return array
     */
    public function getFilters(): array;

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters): ElementInterface;
}