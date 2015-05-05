<?php
namespace DropTable\LibraryBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsbnLength extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The length of "%string%" should be 10 or 13 charecters.';
}
