<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditDataComp extends Component
{
    /**
     * Create a new component instance.
     */

    public $dataType; // 'user' or 'product'
    public $data; // The actual user or product data
    public $allTags; // Role tag or tags for products, it's a list of all available tags. Could probably make a function that loads it, depending on the dataType
    public $columnsToShow; // Which columns to show in the edit table
    public $selectedItem; // The item currently being edited

    private $columnsForUser = ['id', 'name', 'email', 'is_admin', 'created_at', 'updated_at'];
    private $columnsForProduct = ['id', 'name', 'description', 'product_type_id', 'image', 'created_at', 'updated_at'];

    public function getColumnsForDataType($dataType)
    {
        if ($dataType === 'user') {
            return $this->columnsForUser;
        } elseif ($dataType === 'product') {
            return $this->columnsForProduct;
        } else {
            return [];
        }
    }

    public function __construct($dataType, $data, $selectedItem = null, $columnsToShow = [])
    {
        $this->dataType = $dataType;
        $this->data = $data;
        // $this->allTags = $allTags;
        $this->columnsToShow = !empty($columnsToShow) ? $columnsToShow : $this->getColumnsForDataType($dataType);
        $this->selectedItem = $selectedItem;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-data-comp', [
            'dataType' => $this->dataType,
            'data' => $this->data,
            'columnsToShow' => $this->columnsToShow,
            'selectedItem' => $this->selectedItem,
        ]);
    }

    public function isColumnVisible($column)
    {
        return in_array($column, $this->columnsToShow);
    }

    public function getTagName($tag)
    {
        if ($this->dataType === 'user') {
            return $tag->role_name;
        } elseif ($this->dataType === 'product') {
            return true; //$tag->tag_name; // Not implemented yet
        }
    }
}
