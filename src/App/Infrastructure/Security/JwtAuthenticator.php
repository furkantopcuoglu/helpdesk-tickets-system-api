<?php

namespace App\Infrastructure\Security;

use User\Domain\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;

class JwtAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly JWTEncoderInterface $JWTEncoder,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $authorization = $request->headers->get('Authorization');

        if (null === $authorization || count(explode(' ', $authorization)) < 2) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization',
        );

        $jwtToken = $extractor->extract($request);

        $payload = $this->decodeJwt($jwtToken);

        $user = $this->getUser($payload);

        return new SelfValidatingPassport(new UserBadge($user->getEmail()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => $exception->getMessage(),
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    private function decodeJwt(string $jwtToken): array
    {
        try {
            $payload = $this->JWTEncoder->decode($jwtToken);
        } catch (\Exception $e) {
            throw new AuthenticationException('Invalid authentication token');
        }

        if (!$payload) {
            throw new AuthenticationException('Invalid authentication token');
        }

        return $payload;
    }

    private function getUser(array $payload): User
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy([
            'email' => $payload['username'],
        ]);

        if (!($user instanceof User)) {
            throw new AuthenticationException('Invalid Token User');
        }

        if (!$user->isActive()) {
            throw new AuthenticationException('Banned User');
        }

        if (
            $user->getTokenValidAfter() instanceof \DateTime
            && $payload['iat'] < $user->getTokenValidAfter()->getTimestamp()
        ) {
            throw new CustomUserMessageAuthenticationException('Invalid Token User');
        }

        return $user;
    }
}
