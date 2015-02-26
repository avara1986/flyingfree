<?php

namespace JobBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    /**
     * @Template()
     * @param Request $request
     * @return multitype:\Symfony\Component\HttpFoundation\Session\mixed Ambigous <\GuzzleHttp\Message\ResponseInterface, \Symfony\Component\HttpFoundation\mixed>
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }else{
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return array(
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error' => $error
        );

    }
}
