<?php
namespace DropTable\LibraryBundle\Parser;

/**
 * Interface BookProviderParserInterface.
 *
 * @package DropTable\LibraryBundle\Parser
 */
interface BookProviderParserInterface
{
    /**
     * Function to convert json data to entities.
     *
     * @param string $data
     *
     * @return array
     */
    public function getBookEntities($data);
}
