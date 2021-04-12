<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BiznesFushaOperimi;
use AppBundle\Entity\Dokumenta;
use AppBundle\Entity\Oferta;
use AppBundle\Entity\Role;
use AppBundle\Form\BiznesType;
use AppBundle\Form\LoginAdminType;
use AppBundle\Form\OfertaType;
use AppBundle\Form\UserRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Biznes;
use AppBundle\Entity\FushaOperimi;

class BiznesController extends Controller
{
    /**
     * @Route("/regjistohu", name="regjistohu")
     */
    public function registerBiznesAction(Request $request)
    {
        $biznes = new Biznes();
//        $biznesFusheOp= new BiznesFushaOperimi();

        $form = $this->createForm(UserRegisterType::class, $biznes);
        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()){

           $logo = $form->get('logo')->getData();

           $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
           $newFilename = $originalFilename.'-'.uniqid().'.'.$logo->guessExtension();
           $logo->move($this->getParameter('logo_directory'), $newFilename);

           $entityManager = $this->getDoctrine()->getManager();
           $biznes->setEmerBiznesi($form->getData()->getEmerBiznesi());
           $biznes->setRoleId(3);
           $biznes->setEmail($form->getData()->getEmail());
           $biznes->setNipt($form->getData()->getNipt());
           $biznes->setAdresa($form->getData()->getAdresa());
           $biznes->setLogo($newFilename);
           $biznes->setNumerTelefoni($form->getData()->getNumerTelefoni());
           $biznes->setPassword(base64_encode($form->getData()->getPassword()));
           $biznes->setAktiv(0);
           $biznes->setIsDeleted(0);
           $biznes->setPaguar(1);
           $biznes->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());
           $biznes->setBashkia($form->get('bashkia')->getData());

           if ($this->get('session')->get('loginUserId') != null){
               $biznes->setCreatedBy($this->get('session')->get('loginUserId'));
           }

           $entityManager->persist($biznes);
           $entityManager->flush();

         return $this->redirectToRoute('identifikohu');
        }

        return $this->render('regjistrim.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('session')->clear();
        return $this->redirectToRoute('landingpage');
    }
    /**
     * @Route("/publicHomepage", name="publicHomepage")
     */
    public function indexPublic(Request $request)
    {
        return $this->renderView('login.html.twig');
    }
    /**
     * @Route("/profili", name="profili")
     */
    public function profili(Request $request,EntityManagerInterface $entityManager)
    {
        if(($this->get('session')->get('loginUserId') != null) ){

            $biznesId=$this->get('session')->get('loginUserId');
            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $logo=  $this->get('session')->get('logoPath');


            $Query="SELECT emer_biznesi , 
                    email as email, 
                    nipt as nipt, 
                    adresa, logo, numer_telefoni, 
                    fushe_operimi_id, 
                    fusha_operimi.emer_fushe_operimi 
                    From biznes 
                    Left join fusha_operimi on biznes.fushe_operimi_id=fusha_operimi.id
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);

            $statement->execute(array('biznesID'=>$biznesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            return $this->render('profili.html.twig', [
                'profili' => $profili[0],
                'logoUrl'=>$logopath,
                'logo'=>$logo,
                'biznesId'=>$biznesId,
                'biznesName'=>$biznesName
            ]);
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
    }
    /**
     * @Route("/profili/{id}/modifiko", name="modifiko_profil")
     */
    public function profiliModifiko(Request $request,EntityManagerInterface $entityManager,Biznes $biznes)
    {
        if(($this->get('session')->get('loginUserId') != null) ){

            $biznesId=$this->get('session')->get('loginUserId');
            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $logo=  $this->get('session')->get('logoPath');

            $Query="SELECT emer_biznesi 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$biznesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $biznes->setLogo('');
            $form = $this->createForm(BiznesType::class, $biznes);
            $form->handleRequest($request);
            $form->get('password')->getData();
            if($form->isSubmitted() && $form->isValid()) {

                $logo = $form->get('logo')->getData();

                $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$logo->guessExtension();
                $logo->move($this->getParameter('logo_directory'), $newFilename);

                $biznes->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());

                $entityManager = $this->getDoctrine()->getManager();
//                dump($biznes);die();
                $biznes->setEmerBiznesi($form->getData()->getEmerBiznesi());
                $biznes->setRoleId(3);
                $biznes->setEmail($form->getData()->getEmail());
                $biznes->setNipt($form->getData()->getNipt());
                $biznes->setAdresa($form->getData()->getAdresa());
                $biznes->setLogo($newFilename);
                $biznes->setNumerTelefoni($form->getData()->getNumerTelefoni());
                $biznes->setPassword(base64_encode($form->getData()->getPassword()));
                $biznes->setAktiv(0);
                $biznes->setIsDeleted(0);
                $biznes->setPaguar(1);
                $biznes->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());
//                dump($biznes);die();
                $entityManager->persist($biznes);
                $entityManager->flush();
            }


            return $this->render('profili_modifikim.html.twig', [
                'form' => $form->createView(),
                'logoUrl'=>$logopath,
                'logo'=>$logo,
                'biznesName'=>$biznesName



            ]);
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
    }

}
