<?php

namespace DropTable\LibraryBundle\Service;

use DropTable\LibraryBundle\Provider\BookProviderInterface;

class LibraryService
{
    protected $provider;

    public function __construct(BookProviderInterface $provider)
    {
        $this->provider = $provider;
    }
    public function getBookOnlineByISBN($isbn)
    {
        $books = $this->provider->getBook($isbn);
        return $books;
    }
}