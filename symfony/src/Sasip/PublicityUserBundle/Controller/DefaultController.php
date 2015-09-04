<?php

namespace Sasip\PublicityUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Sasip\PublicityUserBundle\Entity\Feedback;
use Sasip\PublicityUserBundle\Form\FeedbackForm;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->renderTemplate('PublicityUserBundle:Default:index.html.twig');
    }

    public function sasipAction() {
        return $this->renderTemplate('PublicityUserBundle:Front:Sasip.html.twig');
    }

    public function teacherAction() {
        return $this->renderTemplate('PublicityUserBundle:Front:Teachers.html.twig');
    }

    public function classAction() {
        return $this->renderTemplate('PublicityUserBundle:Front:Classes.html.twig');
    }

    public function feedbackAction(Request $request) {
        $feedback = new Feedback();
        $form = $this->createForm(new FeedbackForm(), $feedback);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($feedback);
            $em->flush();
            return $this->indexAction();
        }
        return $this->renderTemplate('PublicityUserBundle:Front:Contacts.html.twig', $form->createView());
    }

    public function renderTemplate($template, $data = null) {
        $request = $this->container->get('request');
        /* @var $request \Symfony\Component\HttpFoundation\Request */
        $session = $request->getSession();
        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);
        if ($data) {
            return $this->render($template, array(
                        'csrf_token' => $csrfToken,
                        'last_username' => $lastUsername,
                        'Data' => $data
            ));
        } else {
            return $this->render($template, array(
                        'csrf_token' => $csrfToken,
                        'last_username' => $lastUsername
            ));
        }
    }

}
