<?php

namespace Pta\Menus\Presenters;

use Pta\Menus\MenuItem;

abstract class Presenter implements PresenterInterface
{
    /**
     * Get open tag wrapper.
     *
     * @return string
     */
    public function getOpenTagWrapper()
    {
    }

    /**
     * Get close tag wrapper.
     *
     * @return string
     */
    public function getCloseTagWrapper()
    {
    }

    /**
     * Get menu tag without dropdown wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
    }

    /**
     * Get divider tag wrapper.
     *
     * @return string
     */
    public function getDividerWrapper()
    {
    }

    /**
     * Get header dropdown tag wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getHeaderWrapper($item)
    {
    }

    /**
     * Get menu tag with dropdown wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMenuWithDropDownWrapper($item)
    {
    }

    /**
     * Get multi level dropdown menu wrapper.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getMultiLevelDropdownWrapper($item)
    {
    }

    /**
     * Get child menu items.
     *
     * @param \Pingpong\Menus\MenuItem $item
     *
     * @return string
     */
    public function getChildMenuItems(MenuItem $item)
    {
        $results = '';
        $children = $item->getChilds();
        foreach ($children as $child) {

            $hasRole = false;

            if(!isset($child->roles)){
                $child->roles = ['guest'];
            }

            if(in_array("guest", $child->roles)){
                $hasRole = true;
            }else {
                foreach($child->roles as $role){

                    if(\Guardian::hasRole(strtolower($role))){
                        $hasRole = true;
                        break;
                    }
                }
            }

            if($hasRole){

                if ($child->hasSubMenu()) {

                    $results .= $this->getMultiLevelDropdownWrapper($child);
                } elseif ($child->isHeader()) {
                    $results .= $this->getHeaderWrapper($child);
                } elseif ($child->isDivider()) {
                    $results .= $this->getDividerWrapper();
                } else {
                    $results .= $this->getMenuWithoutDropdownWrapper($child);
                }
            }
        }

        return $results;
    }
}
