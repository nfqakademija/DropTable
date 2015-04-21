<?php

namespace DropTable\LibraryBundle\Provider;

interface BookProviderInterface
{
    public function getBook($isbn);
}