<?php

namespace DropTable\LibraryBundle\Provider;

use Buzz\Browser;
use DropTable\LibraryBundle\Parser\GoogleProviderParser;

class GoogleProvider implements BookProviderInterface
{
    protected $buzz;
    protected $parser;

    public function __construct(Browser $buzz, GoogleProviderParser $parser)
    {
        $this->buzz = $buzz;
        $this->parser = $parser;
    }

    public function getBook($isbn)
    {
        $url = "https://www.googleapis.com/books/v1/volumes/?q=isbn:{$isbn}";

        $booksJson = $this->buzz->get($url)->getContent();
        $books = $this->parser->getBookEntities($booksJson);

        return $books;
    }
}
