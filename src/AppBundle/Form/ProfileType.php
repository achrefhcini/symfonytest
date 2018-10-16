<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 16/10/2018
 * Time: 15:12
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('age');
        $builder->add('famille');
        $builder->add('race');
        $builder->add('nourriture');



    }
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'user_edit_profile';
    }
    public function getName() {
        return 'user_edit_profile';
    }

}