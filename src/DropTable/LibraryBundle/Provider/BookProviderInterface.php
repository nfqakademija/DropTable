<?php
namespace DropTable\LibraryBundle\Provider;

/**
 * Interface BookProviderInterface.
 *
 * @package DropTable\LibraryBundle\Provider
 */
interface BookProviderInterface
{
    /**
     * Search book by ISBN number.
     *
     * @param string $isbn
     *
     * @return mixed
     */
    public function getBook($isbn);
}
