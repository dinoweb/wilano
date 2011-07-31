<?php
namespace FDT\MetadataBundle\Form\Type;

use Symfony\Component\Form\FormBuilder;
use FDT\MetadataBundle\Document\Tipologie\BaseTipologia;
use FDT\MetadataBundle\Document\Attributi\Config;
use FDT\MetadataBundle\Document\Attributi\Attributo;
use FDT\MetadataBundle\Services\AttributiTypeManager;
use FDT\MetadataBundle\Exception\NotValidClassException;


/**
* La classe form base per ciascun contenuto con titpologia
*/
class AttributiType extends AbstractContenutoType
{
    private $attributiConfig;
    private $attributiTypeManager; 
    
    public function setConfigObject (BaseTipologia $tipologia, $service = FALSE)
    {
        $this->attributiConfig = $tipologia->getAttributiTree();
        if ($service and get_class($service) == 'FDT\MetadataBundle\Services\AttributiTypeManager') {
            $this->attributiTypeManager = $service;
        } else {
            throw new NotValidClassException(sprintf('Il servizio %s deve essere invece  FDT\MetadataBundle\Services\AttributiTypeManager', get_class($service)));
        }
        
    }
    
    private function getAttributiTypeManager ()
    {
        
        return $this->attributiTypeManager;
        
    }
    
    public function getFormForAttributo(Config $config)
    {
        $attributoTipo = $config->getAttributo ()->getTipo();
        $formClassForAttributo = $this->getAttributiTypeManager()->getFormTypeClass ($attributoTipo);
        if (class_exists($formClassForAttributo)) {
            return new $formClassForAttributo($config, $this->getAttributiTypeManager());
        } else {
            throw new NotValidClassException(sprintf('La classe %s non esiste', $formClassForAttributo));
        }
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        foreach ($this->attributiConfig as $key => $attributoConfig) {
            $this->getFormForAttributo($attributoConfig);
            $builder->add($attributoConfig->getAttributo()->getUniqueSlug(), $this->getFormForAttributo($attributoConfig), array ('required' => true));
        }
    }

    public function getName()
    {
        return 'attributi';
    }
}
