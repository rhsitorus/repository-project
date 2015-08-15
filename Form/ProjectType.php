<?php

namespace Rofil\Repo\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'attr'  => [ 'class' => 'form-control', 'placeholder' => 'Masukan data title' ],
                'label' => '',
            ])
            ->add('published', 'choice', [
                'attr'  => [ 'class' => 'form-control', 'placeholder' => 'Masukan data published' ],
                'label' => '', 'expanded' => true, 'choices' => [ 1=> 'Published', 0 => 'Draft' ]
            ]) 
            ->add('imagePath', 'file', [
                'attr'  => [ 'class' => 'form-control', 'placeholder' => 'Masukan data image' ],
                'label' => '', 'required'=>false
            ])
            // ->add('file', null, [
            //     'attr'  => [ 'class' => 'form-control', 'placeholder' => 'Masukan data file' ],
            //     'label' => '',
            // ])
            ->add('body', 'ckeditor', [
                'attr'  => [ 'class' => 'form-control', 'placeholder' => 'Masukan data body' ],
                'label' => '',
            ])
            
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rofil\Repo\ContentBundle\Entity\Project'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rofil_repo_contentbundle_project';
    }
}
