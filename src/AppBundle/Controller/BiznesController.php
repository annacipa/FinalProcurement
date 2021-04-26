<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BiznesFushaOperimi;
use AppBundle\Entity\Dokumenta;
use AppBundle\Entity\Oferta;
use AppBundle\Entity\Role;
use AppBundle\Form\BiznesType;
use AppBundle\Form\LoginAdminType;
use AppBundle\Form\OfertaType;
use AppBundle\Form\BiznesModifikoType;
use AppBundle\Form\UserRegisterType;
use AppBundle\Form\NdryshoPasswordType;
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
     * @Route("/profili", name="profili")
     */
    public function profili(Request $request,EntityManagerInterface $entityManager)
    {
        if(($this->get('session')->get('loginUserId') != null) ){

            $biznesId=$this->get('session')->get('loginUserId');
            $Query="SELECT emer_biznesi ,
                    biznes.id as idBiznesi,
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
            $logopath="/uploads/logo/".$profili[0]['logo'];
            return $this->render('profili.html.twig', [
                'profili' => $profili[0],
                'logoUrl'=>$logopath,
                'logo'=>$profili[0]['logo'],
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
      
            $Query="SELECT emer_biznesi, logo 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$biznesId));

            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];
            $logo = $profili[0]['logo'];
            $logopath="/uploads/logo/".$logo;
            $logoNew = $profili[0]['logo'];
            $biznes->setLogo('');
            $form = $this->createForm(BiznesModifikoType::class, $biznes);

            $form->handleRequest($request);
           
            if($form->isSubmitted() && $form->isValid()) {
              
                        
                $biznes->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());
                $entityManager = $this->getDoctrine()->getManager();
                $biznes->setEmerBiznesi($form->getData()->getEmerBiznesi());
                $biznes->setRoleId(3);
                $biznes->setEmail($form->getData()->getEmail());
                $biznes->setAdresa($form->getData()->getAdresa());
                $logo = $form->get('logo')->getData();  
                
                 if($logo != null){
                   
                    $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename.'-'.uniqid().'.'.$logo->guessExtension();
                    $logo->move($this->getParameter('logo_directory'), $newFilename);
                    $logoNew = $newFilename;
                    $biznes->setLogo($newFilename);
                    
                    
                }
                else{
                   $logo = $logopath;
                   $biznes->setLogo($profili[0]['logo']);
                  
                }
                $biznes->setNumerTelefoni($form->getData()->getNumerTelefoni());
                $biznes->setAktiv(1);
                $biznes->setIsDeleted(0);
                $biznes->setPaguar(1);
                $biznes->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());
                $entityManager->persist($biznes);
                $entityManager->flush();
            }
            $Query="SELECT emer_biznesi, logo 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$biznesId));
          
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];
            $logo = $profili[0]['logo'];
            $logopath="/uploads/logo/".$logo;
            $logoNew = $profili[0]['logo'];

            return $this->render('profili_modifikim.html.twig', [
                'form' => $form->createView(),
                'logoUrl'=>$logopath,
                'logo'=>$logoNew,
                'biznesId' => $biznesId,
                'biznesName'=>$biznesName

            ]);
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
    }
 /**
     * @Route("/ndryshoPassword/{id}", name="ndryshoPassword")
     */
    public function ndryshoPassword(Request $request,EntityManagerInterface $entityManager,Biznes $biznes)
    {
        if(($this->get('session')->get('loginUserId') != null) ){

            $biznesId=$this->get('session')->get('loginUserId');
            $Query="SELECT emer_biznesi,logo
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$biznesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];
            $logopath="/uploads/logo/".$profili[0]['logo'];

            
            $form = $this->createForm(NdryshoPasswordType::class, $biznes);
            $form->handleRequest($request);
           
            if($form->isSubmitted() && $form->isValid()) {
              
               
                $entityManager = $this->getDoctrine()->getManager();

                $biznes->setPassword(base64_encode($form->getData()->getPassword()));
            
                $entityManager->persist($biznes);
                $entityManager->flush();
                $this->get('session')->clear();
                return $this->redirectToRoute('identifikohu');
            }


            return $this->render('ndrysho_password.html.twig', [
                'form' => $form->createView(),
                'logoUrl'=>$logopath,
                'biznesId' => $biznesId,
                'biznesName'=>$biznesName
            ]);
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
    }
}
