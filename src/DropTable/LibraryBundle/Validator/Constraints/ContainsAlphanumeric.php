<?php
namespace DropTable\LibraryBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The string "%string%" is not valid ISBN number.';
}
