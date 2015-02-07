<?php
namespace Mostad\SocialGrant\Grant;

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Http\Request;
use ZfrOAuth2\Server\Entity\AccessToken;
use ZfrOAuth2\Server\Entity\Client;
use ZfrOAuth2\Server\Entity\RefreshToken;
use ZfrOAuth2\Server\Entity\TokenOwnerInterface;
use ZfrOAuth2\Server\Exception\OAuth2Exception;
use ZfrOAuth2\Server\Grant\AbstractGrant;
use ZfrOAuth2\Server\Grant\AuthorizationServerAwareInterface;
use ZfrOAuth2\Server\Grant\AuthorizationServerAwareTrait;
use ZfrOAuth2\Server\Grant\RefreshTokenGrant;
use ZfrOAuth2\Server\Service\TokenService;

/**
 * Class AbstractSocialGrant
 *
 * @package Mostad\SocialGrant\Grant
 */
abstract class AbstractSocialGrant extends AbstractGrant implements
    AuthorizationServerAwareInterface,
    SocialGrantInterface
{
    use AuthorizationServerAwareTrait;

    const GRANT_RESPONSE_TYPE = null;

    /**
     * @var TokenService
     */
    protected $accessTokenService;

    /**
     * @var TokenService
     */
    protected $refreshTokenService;

    /**
     * @var ObjectRepository
     */
    protected $userRepository;

    /**
     * @param TokenService     $accessTokenService
     * @param TokenService     $refreshTokenService
     * @param ObjectRepository $userRepository
     */
    public function __construct(
        TokenService     $accessTokenService,
        TokenService     $refreshTokenService,
        ObjectRepository $userRepository
    ) {
        $this->accessTokenService  = $accessTokenService;
        $this->refreshTokenService = $refreshTokenService;
        $this->userRepository      = $userRepository;
    }

    /**
     * {@inheritDoc}
     * @throws OAuth2Exception
     */
    public function createAuthorizationResponse(Request $request, Client $client, TokenOwnerInterface $owner = null)
    {
        throw OAuth2Exception::invalidRequest('This grant type does not support authorization');
    }

    /**
     * {@inheritDoc}
     */
    public function createTokenResponse(Request $request, Client $client = null, TokenOwnerInterface $owner = null)
    {
        $token = $request->getPost('access_token');
        $scope = $request->getPost('scope');

        if (null === $token) {
            throw OAuth2Exception::invalidRequest('Missing parameter access_token');
        }

        $owner = $this->getOwner($token);
        if (!$owner instanceof TokenOwnerInterface) {
            throw OAuth2Exception::accessDenied('Unable to load account');
        }

        /**
         * @var AccessToken       $accessToken
         * @var null|RefreshToken $refreshToken
         * */
        $accessToken  = new AccessToken();
        $refreshToken = null;

        // Generate token
        $this->populateToken($accessToken, $client, $owner, $scope);
        $accessToken = $this->accessTokenService->createToken($accessToken);

        // Before generating a refresh token, we must make sure the authorization server supports this grant
        if ($this->authorizationServer->hasGrant(RefreshTokenGrant::GRANT_TYPE)) {
            $refreshToken = new RefreshToken();
            $this->populateToken($refreshToken, $client, $owner, $scope);
            $refreshToken = $this->refreshTokenService->createToken($refreshToken);
        }

        return $this->prepareTokenResponse($accessToken, $refreshToken);
    }

    /**
     * {@inheritDoc}
     */
    public function allowPublicClients()
    {
        return true;
    }
}
