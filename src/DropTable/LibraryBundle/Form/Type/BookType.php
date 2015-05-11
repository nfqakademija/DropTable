<?php

namespace DropTable\LibraryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class BookType.
 *
 * @package DropTable\LibraryBundle\Form\Type
 */
class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isbn')
            ->add('title')
            ->add(
                'author',
                'entity',
                [
                    'class' => 'DropTableLibraryBundle:Author',
                    'property' => 'name',
                ]
            )
            ->add(
                'category',
                'entity',
                [
                    'class' => 'DropTableLibraryBundle:Category',
                    'property' => 'name',
                ]
            )
            ->add(
                'publisher',
                'entity',
                [
                    'class' => 'DropTableLibraryBundle:Publisher',
                    'property' => 'name',
                ]
            )
            ->add('description', 'textarea')
            ->add('pages')
            ->add('created_at', 'date')
            ->add('Save', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'library_book';
    }
}
