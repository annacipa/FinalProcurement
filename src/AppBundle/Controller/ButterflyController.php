<?php


namespace AppBundle\Controller;
use AppBundle\Entity\Role;
use AppBundle\Form\LoginAdminType;
use AppBundle\Form\UserRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Biznes;

class ButterflyController extends Controller
{
    /**
     * @Route("/", name="landingpage")
     */

    public function indexAction(Request $request)
{
    return $this->render('default/landingpage.html.twig');
}
}

