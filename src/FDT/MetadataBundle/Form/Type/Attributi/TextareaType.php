<?php
namespace FDT\MetadataBundle\Form\Type\Attributi;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormError;

/**
* La classe form base per ciascun gli attributi di tipo textarea
*/
class TextareaType extends AbstractAttributoType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder = $this->buildBaseFields ($builder);
        $languages = $this->getLanguages();
        $builder->add('value', 'form', array('required'=>$this->getConfig ()->getIsObligatory(), 'label' => $this->getAttributo ()->getName()));
        if ($this->attributoMusBeTranslated()) {
            $builder->add('value', 'form', array('required'=>$this->getConfig ()->getIsObligatory(), 'label' => $this->getAttributo ()->getName()));
            foreach ($this->getLanguages() as $key => $value) {
                 $builder->get('value')->add($key, 'textarea', array('required'=>$this->getConfig ()->getIsObligatory(), 'label' => $this->getAttributo ()->getName()));
                 if ($this->getConfig ()->getIsObligatory()) {
                    $builder->get('value')->
                    addValidator(new CallbackValidator(function(\Symfony\Component\Form\Form  $form) use ($key)
                                                       {
                                                            if (!$form[$key]->getData()) {
                                                                $form->addError(new FormError(sprintf('Il campo name %s nel form ContenutoType deve essere compilato', $key)));
                                                            }
                                                       }
                                               )
                                );
                 }
            }
        } else {
            $builder->add('value', 'textarea', array('required'=>$this->getConfig ()->getIsObligatory(), 'label' => $this->getAttributo ()->getName()));
            if ($this->getConfig ()->getIsObligatory()) {
                    $name = $this->getAttributo ()->getName();
                    $builder->addValidator(new CallbackValidator(function(\Symfony\Component\Form\Form  $form) use ($name)
                                                       {
                                                            if (!$form['value']->getData()) {
                                                                $form->addError(new FormError(sprintf('Il campo %s nel form attributi deve essere compilato', $name)));
                                                            }
                                                       }
                                               )
                                );
            }
        }
    }

    public function getName()
    {
        return 'TextAreaType';
    }
}
