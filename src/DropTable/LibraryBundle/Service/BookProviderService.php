<?php

namespace DropTable\LibraryBundle\Service;

use DropTable\LibraryBundle\Provider\BookProviderInterface;

/**
 * Class BookProviderService.
 *
 * @package DropTable\LibraryBundle\Service
 */
class BookProviderService
{
    /**
     * @var BookProviderInterface
     */
    protected $provider;

    /**
     * @param BookProviderInterface $provider
     */
    public function __construct(BookProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Function for searching books online using ISBN.
     *
     * @param string $isbn
     *
     * @return array
     */
    public function searchBookOnlineByISBN($isbn)
    {
        $books = $this->provider->getBook($isbn);

        return $books;
    }
}
