<?php

namespace eLink\Payment\SlimCDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ServiceController extends Controller
{

    public function creditCardAjaxAction(Request $request)
    {
        $username = $request->get('term');

        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
            'SELECT u.username FROM ApplicationSonataUserBundle:User u WHERE u.username LIKE :username'
        )->setParameter('username', $username.'%');

        $q->useResultCache(true);

        $users = $q->getResult();
        $users = array_values($users[0]);
        // ladybug_dump($users);
        $response = new Response();
        $response->setContent(json_encode($users));

        return $response;
    }
}