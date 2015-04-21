<?php
namespace DropTable\LibraryBundle\Service;

use DropTable\LibraryBundle\Provider\BookProviderInterface;

class BookProviderService
{
    /** @var BookProviderInterface $provider */
    protected $provider;

    public function __construct(BookProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function searchBookOnlineByISBN($isbn)
    {
        $books = $this->provider->getBook($isbn);
        return $books;
    }
}