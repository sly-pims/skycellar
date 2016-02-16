<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class WineType extends AbstractType
{
    private $isEdit = false;

    public function __construct ($isEdit = false)
    {
        $this->isEdit = $isEdit;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $saveLabel = 'New wine';
//
//        if ($this->isEdit) {
//            $saveLabel = 'Edit wine';
//        }

        $saveLabel = $this->isEdit ? 'Edit wine' : 'New wine';

        $builder
            ->add('name',TextType::class)
            ->add('color',ChoiceType::class,array(
                'choices'=> array(
                    'Red' => 'Red',
                    'Rose' => 'Rose',
                    'White' => 'White',
                )
            ))
            ->add('composition',TextareaType::class)
            ->add('vintage',IntegerType::class)
            ->add('method',TextareaType::class)
            ->add('history',TextareaType::class)
            ->add('keyPoint',TextareaType::class)
            ->add('hidden',ChoiceType::class,array(
                'choices'=> array(
                    0=> 'No',
                    1=> 'Yes',
                )
            ))
            ->add('style',TextType::class)
            ->add('testingNotes',TextareaType::class)
            ->add('region',EntityType::class,array('class'=>'AppBundle:Region', 'choice_label'=>'name'))
            ->add('save', SubmitType::class, array('label' => $saveLabel))
            ->getForm();

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Wine'
        ));
    }
}
