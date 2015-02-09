<?php
namespace Mostad\SocialGrant\Factory\Grant;

use Mostad\SocialGrant\Entity\GoogleInterface;
use Mostad\SocialGrant\Grant\GoogleGrant;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class GoogleGrantFactory
 *
 * @package Mostad\SocialGrant\Factory\Grant
 */
class GoogleGrantFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return GoogleGrant
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var \Doctrine\Common\Persistence\ObjectRepository    $userRepository
         * @var \Zend\ServiceManager\ServiceManager              $serviceManager
         * @var \ZfrOAuth2\Server\Service\TokenService           $accessTokenService
         * @var \ZfrOAuth2\Server\Service\TokenService           $refreshTokenService
         * @var \ZfrOAuth2Module\Server\Grant\GrantPluginManager $serviceLocator
         */
        $serviceManager      = $serviceLocator->getServiceLocator();
        $accessTokenService  = $serviceManager->get('ZfrOAuth2\Server\Service\AccessTokenService');
        $refreshTokenService = $serviceManager->get('ZfrOAuth2\Server\Service\RefreshTokenService');
        $userRepository      = $serviceManager->get('Mostad\ObjectManager')->getRepository(GoogleInterface::class);

        return new GoogleGrant(
            $accessTokenService,
            $refreshTokenService,
            $userRepository
        );
}}
