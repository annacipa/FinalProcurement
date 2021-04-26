<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Role;
use AppBundle\Form\LoginAdminType;
use AppBundle\Form\UserRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Biznes;
class DefaultController extends Controller
{
    /**
     * @Route("/identifikohu", name="identifikohu")
     */
    public function indexAction(Request $request)
    {
        $biznes = new Biznes();
        $form = $this->createForm(LoginAdminType::class);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()){
            $repositoryBiznes = $this->getDoctrine()->getRepository(Biznes::class);
            $biznes = $repositoryBiznes->findOneBy([
                'nipt' => $form->getData()['username'],
                'password' => base64_encode($form->getData()['password'])
            ]);
          
            if ($biznes instanceof Biznes){
                $this->get('session')->set('loginUserId', $biznes->getId());
                $biznesId=$this->get('session')->get('loginUserId');
            return $this->redirectToRoute('buletini');
            }
            else{
                $this->addFlash('error', 'Keni vendosur fjalekalimin ose NIPT gabim! Ju lutem provojeni sërish!!');
                return $this->redirectToRoute('identifikohu');

            }
        }
        return $this->render('login.html.twig', [
          "form"=>$form->createView(),

        ]);
    }
}
