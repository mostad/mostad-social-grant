<?php
namespace Mostad\SocialGrant\Entity;

/**
 * Interface GoogleInterface
 *
 * @package Mostad\SocialGrant\Entity
 */
interface GoogleInterface
{
    /**
     * @return string
     */
    public function getGoogleId();

    /**
     * @param string $googleId
     */
    public function setGoogleId($googleId);
}
