<?php

namespace DropTable\LibraryBundle\Provider;

use Buzz\Browser;
use DropTable\LibraryBundle\Parser\GoogleProviderParser;

/**
 * Class GoogleProvider.
 *
 * @package DropTable\LibraryBundle\Provider
 */
class GoogleProvider implements BookProviderInterface
{
    /**
     * @var Browser
     */
    protected $buzz;

    /**
     * @var GoogleProviderParser
     */
    protected $parser;

    /**
     * @param Browser              $buzz
     * @param GoogleProviderParser $parser
     */
    public function __construct(Browser $buzz, GoogleProviderParser $parser)
    {
        $this->buzz = $buzz;
        $this->parser = $parser;
    }

    /**
     * @param string $isbn
     *
     * @return array
     */
    public function getBook($isbn)
    {
        $url = "https://www.googleapis.com/books/v1/volumes/?q=isbn:{$isbn}";

        $booksJson = $this->buzz->get($url)->getContent();
        $books = $this->parser->getBookEntities($booksJson);

        return $books;
    }
}
