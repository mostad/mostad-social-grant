<?php
namespace Mostad\SocialGrant\Grant;

/**
 * Interface SocialGrantInterface
 *
 * @package Mostad\SocialGrant\Grant
 */
interface SocialGrantInterface
{
    /**
     * @param string $token
     *
     * @return \Mostad\User\Entity\UserInterface
     */
    public function getOwner($token);
}
