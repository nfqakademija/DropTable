<?php

namespace DropTable\LibraryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('isbn')
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
