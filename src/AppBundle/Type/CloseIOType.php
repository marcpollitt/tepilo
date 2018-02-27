<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 25-Jul-17
 * Time: 17:44
 */

namespace AppBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class CloseIOType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, ['label' => 'Email',  'attr' => ['placeholder' => 'Email']])
            ->add('company', TextType::class, ['label' => 'company',  'attr' => ['placeholder' => 'company']])
            ->add('equals', SubmitType::class, ['label' => 'Submit Email Address',]);
    }
}