<?php
namespace Mostad\SocialGrant\Grant;

/**
 * Class GoogleGrant
 *
 * @package Mostad\SocialGrant\Grant
 */
class GoogleGrant extends AbstractSocialGrant
{
    const GRANT_TYPE = 'google';

    /**
     * {@inheritDoc}
     */
    public function getOwner($token)
    {
        // TODO: Implement getOwner() method.
    }
}

