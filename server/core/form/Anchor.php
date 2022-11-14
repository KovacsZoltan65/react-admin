<?php

/**
 * Anchor.php
 * User: kzoltan
 * Date: 2022-06-30
 * Time: 13:20
 */

namespace app\core\form;

/**
 * Description of Anchor
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class Anchor
{
    const TYPE_BUTTON = 'button',
        TYPE_ANCHOR = '';
    public string $type = self::TYPE_BUTTON;
    public array $attributes = [];

    /**
     *
     * @param array $attributes
     *              [
     *                  'id'    => '',
     *                  'name'  => '',
     *                  'class' => '',
     *                  'title' => '',
     *                  'href'  => '',
     *                  'icon'  => '',
     *              ]
     */
    public function __construct(array $attributes)
    {
        $this->type = self::TYPE_BUTTON;
        $this->attributes = $attributes;
    }

    public function __toString()
    {
        $name = (!isset($this->attributes['name']) || $this->attributes['name'] == '') ? $this->attributes['id'] : $this->attributes['name'];
        $style = (isset($this->attributes['style']) ? 'style="' . $this->attributes['style'] . '"' : '');
        
        $anchor = '<a id="' . $this->attributes['id'] . '" 
                      name="' . $name . '" 
                      class="' . $this->attributes['class'] . '" 
                      ' . $style . '
                      type="' . $this->type . '" 
                      href="' . $this->attributes['href'] . '">';
        $anchor .= (isset($this->attributes['icon']) ? '<i class="' . $this->attributes['icon'] . '"></i>' : $this->attributes['title']);
        $anchor .= '</a>';

        return $anchor;
    }

    public function button(): Anchor
    {
        $this->type = self::TYPE_BUTTON;
        return $this;
    }

    public function anchor(): Anchor
    {
        $this->type = self::TYPE_ANCHOR;
        return $this;
    }
}