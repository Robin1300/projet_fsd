<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class LoginFormAuthenticator extends AbstractGuardAuthenticator
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->encoder = $userPasswordEncoder;
    }
    public function supports(Request $request)
    {
        return $request->isMethod('POST') && $request->attributes->get('_route') === 'security_login';
    }

    public function getCredentials(Request $request)
    {
        return $request->request->get('login');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
       $user = $userProvider->loadUserByUsername($credentials['username']);

       if (!$user) {
           throw new AuthenticationException("Ce compte n'existe pas ou alors le mot passe ne correspond pas");
       }
       return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if ($this->encoder->isPasswordValid($user, $credentials['password'])) {
            return true;
        }
        throw new AuthenticationException("Ce compte n'existe pas ou alors le mot passe ne correspond pas");

    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->attributes->set('login.error', $exception->getMessage());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $url = $request->getSession()->get('login.redirect', '/');

        return new RedirectResponse($url);
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $url = $request->getPathInfo();

        $request->getSession()->set('login.redirect', $url);

        return new RedirectResponse('/login');
    }

    public function supportsRememberMe()
    {
        // todo
    }
}
