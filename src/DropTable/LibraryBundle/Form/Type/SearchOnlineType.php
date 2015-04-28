<?php

namespace DropTable\LibraryBundle\Form\Type;

use DropTable\LibraryBundle\Validator\Constraints\ContainsAlphanumeric;
use DropTable\LibraryBundle\Validator\Constraints\IsbnLength;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

/**
 * Class SearchOnlineType.
 *
 * @package DropTable\LibraryBundle\Form\Type
 */
class SearchOnlineType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'isbn',
                'text',
                [
                    'constraints' => [
                        new IsbnLength(),
                        new ContainsAlphanumeric(),
                    ],
                ]
            )
            ->add('Save', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'search_book';
    }
}
