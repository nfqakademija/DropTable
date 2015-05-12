<?php

namespace DropTable\LibraryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                'categories',
                'collection',
                [
                    'type' => new CategoryType(),
                    'allow_add' => true,
                ]
            )
            ->add(
                'authors',
                'collection',
                [
                    'type' => new AuthorType(),
                    'allow_add' => true,
                ]
            )
            ->add(
                'publishers',
                'collection',
                [
                    'type' => new PublisherType(),
                    'allow_add' => true,
                ]
            )
//            ->add('thumbnail', 'file', ['image_path' => 'thumbnail'])
            ->add('description', 'textarea')
            ->add('pages')
            ->add('created_at', 'date')
            ->add('Save', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'DropTable\LibraryBundle\Entity\Book',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'library_book';
    }
}
