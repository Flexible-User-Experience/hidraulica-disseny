<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class KernelRequestEvent
 *
 * @category Listener
 * @package  Museums\AdminBundle\EventListener
 * @author   David Romaní <david@flux.cat>
 */
class KernelRequestEvent
{
    /**
     * @var TokenStorageInterface
     */
    private $ts;

    /**
     * @var string default locale
     */
    private $dl;

    /**
     * KernelRequestEvent constructor
     *
     * @param TokenStorageInterface $ts
     * @param string                $deafultLocale
     */
    public function __construct(TokenStorageInterface $ts, $deafultLocale)
    {
        $this->ts = $ts;
        $this->dl = $deafultLocale;
    }

    /**
     * Fix locale session problem on backend
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        /** @var UsernamePasswordToken $token */
        $token = $this->ts->getToken();
        // find if you are inside admin area
        if ($token && $token instanceof UsernamePasswordToken && $token->getProviderKey() == 'admin') {
            $request = $event->getRequest();
            // try to see if the locale has been set as a _locale routing parameter
            if ($request->attributes->get('_locale') != $this->dl && strpos($request->attributes->get('_route'), 'admin') !== false ) {
                $request->setLocale($this->dl);
            }
        }
    }
}
