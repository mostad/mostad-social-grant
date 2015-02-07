<?php
namespace Mostad\SocialGrant;

/**
 * Class Module
 *
 * @package Mostad\SocialGrant
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return (array) require __DIR__ .'/../../../config/module.config.php';
    }
}
