<?php

namespace FDT\MetadataBundle\Document\Tipologie;

use Doctrine\ODM\MongoDB\Mapping\Annotations\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations\UniqueIndex;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Index;
use Gedmo\Translatable\Document\AbstractTranslation;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Gedmo\Translatable\Document\Translation
 *
 * @Document(repositoryClass="Gedmo\Translatable\Document\Repository\TranslationRepository", collection="tipologie.translation"))
 * @UniqueIndex(name="lookup_unique_idx", keys={
 *         "locale",
 *         "object_class",
 *         "foreign_key",
 *         "field"
 * })
 * @Index(name="translations_lookup_idx", keys={
 *      "locale",
 *      "object_class",
 *      "foreign_key"
 * })
 */
class TipologiaTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
     

}