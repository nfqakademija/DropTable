<?php

namespace DropTable\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DropTableUserBundle
 * @package DropTable\UserBundle
 */
class DropTableUserBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
