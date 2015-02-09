<?php
namespace Mostad\SocialGrant\Delegator;

use DoctrineModule\Validator\NoObjectExists;
use Mostad\SocialGrant\Entity\GoogleInterface;
use Mostad\SocialGrant\Grant\GoogleGrant;
use Zend\Filter\StringTrim;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfrOAuth2\Server\AuthorizationServer;

/**
 * Class GoogleInputFilterDelegator
 *
 * @package Mostad\SocialGrant\Factory\Delegator
 */
class GoogleInputFilterDelegator implements DelegatorFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        /**
         * @var \Zend\InputFilter\InputFilterInterface     $inputFilter
         * @var \Zend\InputFilter\InputFilterPluginManager $serviceLocator
         */
        $inputFilter = $callback();

        if ($serviceLocator->getServiceLocator()->get(AuthorizationServer::class)->hasGrant(GoogleGrant::GRANT_TYPE)) {
            // TODO: Move this to its own class
            $inputFilter->add([
                'name' => 'googleId',
                'required' => false,
                'filters' => [
                    [
                        'name' => StringTrim::class,
                    ],
                ],
                'validators' => [
                    [
                        'name' => NoObjectExists::class,
                        'options' => [
                            'fields'            => ['googleId'],
                            'messages'          => [
                                NoObjectExists::ERROR_OBJECT_FOUND => 'A user with this google id already exists',
                            ],
                            'object_repository' => $serviceLocator->getServiceLocator()->get('Mostad\ObjectManager')->getRepository(GoogleInterface::class),
                        ]
                    ]
                ],
            ]);
        }

        return $inputFilter;
    }
}
