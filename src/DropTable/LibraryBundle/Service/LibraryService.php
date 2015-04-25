<?php
namespace DropTable\LibraryBundle\Service;

use DropTable\LibraryBundle\Provider\BookProviderInterface;

/**
 * Class LibraryService.
 *
 * @package DropTable\LibraryBundle\Service
 */
class LibraryService
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
     * @param string $isbn
     *
     * @return mixed
     */
    public function getBookOnlineByISBN($isbn)
    {
        $books = $this->provider->getBook($isbn);

        return $books;
    }
}
