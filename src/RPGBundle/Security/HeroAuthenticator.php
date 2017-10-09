<?php
namespace RPGBundle\Security;


use RPGBundle\Helper\PasswordHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class HeroAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @inheritdoc
     */
    public function getCredentials(Request $request)
    {
        $header = $request->headers->get('Authorization');

        return array(
            'header' => $header,
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $header = $credentials['header'];

        if (null === $header) {
            return null;
        }
        [$user, $pass] = explode(' ', $credentials['header']);

        return $userProvider->loadUserByUsername($user);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {

        [$userName, $pass] = explode(' ', $credentials['header']);

        return PasswordHelper::verify($pass, $user->getPassword());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = array(
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        );

        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required'
        );

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}