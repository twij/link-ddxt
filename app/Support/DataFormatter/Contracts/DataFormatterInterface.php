<?php

namespace App\Support\DataFormatter\Contracts;

use App\Support\DataFormatter\DataFormatter;

interface DataFormatterInterface
{
    /**
     * Load array data
     *
     * @param array $data Array
     *
     * @return void 
     */
    public function loadData(array $data): void;

    /**
     * Get formatted data
     *
     * @return array Formatted array
     */
    public function get(): array;

    /**
     * Append data via key
     *
     * @param string  $key    Key name
     * @param mixed   $value  Value
     *
     * @return void 
     */
    public function append(string $key, $value): void;

    /**
     * Append additional array data
     *
     * @param array $data Array data
     *
     * @return DataFormatter Self
     */
    public function withData(array $data): \App\Support\DataFormatter\DataFormatter;

    /**
     * Return json
     *
     * @return null|string Json data
     */
    public function toJson(): ?string;

    /**
     * Assign default values from defaults array
     *
     * @return array
     */
    public function assignDefaults(): array;

    /**
     * Reassign keys from reassign array
     *
     * @return array 
     */
    public function reassign(): array;

    /**
     * Validate the data
     *
     * @return array 
     */
    public function validate(): array;

    /**
     * Filter the data
     *
     * @return array 
     */
    public function filter(): array;
    
    /**
     * Called on get()
     *
     * @return mixed 
     */
    public function onGet();

    /**
     * Called on reassign
     *
     * @return mixed 
     */
    public function onReassigned();

    /**
     * Called on assign defaults
     *
     * @return mixed 
     */
    public function onAssignDefaults();

    /**
     * Called on validated
     *
     * @return mixed 
     */
    public function onValidated();

    /**
     * Called on filtered
     *
     * @return mixed 
     */
    public function onFiltered();
}
