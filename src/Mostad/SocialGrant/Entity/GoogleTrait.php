<?php
namespace Mostad\SocialGrant\Entity;

/**
 * Class GoogleTrait
 *
 * @package Mostad\SocialGrant\Entity
 */
trait GoogleTrait
{
    /**
     * @var string
     */
    protected $googleId;

    /**
     * {@inheritdoc}
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * {@inheritdoc}
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    }
}
