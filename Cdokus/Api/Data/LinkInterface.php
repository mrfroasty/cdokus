<?php

namespace Zanbytes\Cdokus\Api\Data;

interface LinkInterface 
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID                = 'entity_id';
    const SKU                      = 'sku';
    const FILENAME                 = 'filename';
    const LABEL                    = 'label';
    const STORE_ID                 = 'store_id';
    const POSITION                 = 'position';
    const IS_ACTIVE                = 'is_active';
    const CREATED_AT               = 'created_at';
    const UPDATED_AT               = 'updated_at';
    /**#@-*/
    
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();
    
    /**
     * Get SKU
     *
     * @return string
     */
    public function getSku();
    
    /**
     * Get Filename
     *
     * @return string
     */
    public function getFilename();
    
    /**
     * Get label
     *
     * @return string
     */    
    public function getLabel();
    
    /**
     * Get store_id
     *
     * @return int|null
     */    
    public function getStoreId();
    

    /**
     * Get position
     *
     * @return int|null
     */
    public function getPosition();
        
    /**
     * Get Is Active
     *
     * @return int|null
     */    
    public function getIsActive();
    

    /**
     * Get created at
     *
     * @return string
     */    
    public function getCreatedAt();
    
    
    /**
     * Get ID
     *
     * @return int|null
     */    
    public function getUpdatedAt();
    
    
       /**
     * Get ID
     *
     * @return int|null
     */
    public function setId($id);
    
    /**
     * Get SKU
     *
     * @return string
     */
    public function setSku($sku);
    
    /**
     * Get Filename
     *
     * @return string
     */
    public function setFilename($filename);
    
    /**
     * Get label
     *
     * @return string
     */    
    public function setLabel($label);
    
    /**
     * Get store_id
     *
     * @return int|null
     */    
    public function setStoreId($storeId);
    

    /**
     * Get position
     *
     * @return int|null
     */
    public function setPosition($position);
        
    /**
     * Get Is Active
     *
     * @return int|null
     */    
    public function setIsActive($isActive);
    

    /**
     * Get created at
     *
     * @return string
     */    
    public function setCreatedAt($createdAt);
    
    
    /**
     * Get ID
     *
     * @return int|null
     */    
    public function setUpdatedAt($updatedAt);

    
}

