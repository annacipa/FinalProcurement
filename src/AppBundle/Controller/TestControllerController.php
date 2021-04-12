<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Tender;
use AppBundle\Entity\Biznes;
use AppBundle\Entity\FushaOperimi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserRegisterType;
use AppBundle\Form\LoginAdminType;


class TestControllerController extends Controller
{
    /**
     * @Route("/prove", name="prove")
     */
    public function testLogin(EntityManagerInterface $entityManager,Request $request)
    {
        $biznes = new Biznes();

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

            if ($this->get('session')->get('loginUserId') != null){
                $biznes->setCreatedBy($this->get('session')->get('loginUserId'));
            }

            $entityManager->persist($biznes);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        $biznes = new Biznes();
        $form_login = $this->createForm(LoginAdminType::class);
        $form_login->handleRequest($request);
//        dump($form_login);die();
//        dump($this);die();
        if ($form_login->isValid() && $form_login->isSubmitted()){


            $repositoryBiznes = $this->getDoctrine()->getRepository(Biznes::class);
            $biznes = $repositoryBiznes->findOneBy([
                'nipt' => $form_login->getData()['username'],
                'password' => base64_encode($form_login->getData()['password'])
            ]);

            if ($biznes instanceof Biznes){


                $this->get('session')->set('loginUserId', $biznes->getId());
                $this->get('session')->set('logoPath',$biznes->getLogo());

                $biznesId=$this->get('session')->get('loginUserId');
                $role =  new Role();
                $repositoryRole = $this->getDoctrine()->getRepository(Role::class);
                $roleName = $repositoryRole->find($biznes->getRoleId());
                if($roleName instanceof Role){
                    $emerRoli = $roleName->getEmerRoli();
                    $this->get('session')->set('roleName',$emerRoli);
                    $this->get('session')->set('roleId',$roleName->getId());

                }
                return $this->redirectToRoute('buletini');
            }
            else{
                return $this->redirectToRoute('homepage');
            }
        }




        return $this->render('login.html.twig',[
            'form' => $form->createView(),
            'form_login'=>$form_login->createView()
        ]);
    }
    /**
     * @Route("/buletini_prove", name="buletini_prove")
     */

    public function feedBuletin(EntityManagerInterface $entityManager){

            $logopath=$this->get('session')->get('logoPath');
            $logopath="'uploads/logo/".$logopath."'";



            $today=new \DateTime();
            $repository=$entityManager->getRepository(Tender::class);
//        add kush qe not in this business

            $Query="SELECT emer_biznesi 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));

            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $query="SELECT tender.id, tender.titull_thirrje, tender.pershkrim,
               tender.fond_limit, tender.data_perfundimit, tender.biznes_id,
               fusha_operimi.emer_fushe_operimi, biznes.emer_biznesi 
              FROM tender
              RIGHT JOIN biznes ON tender.biznes_id=biznes.id 
              RIGHT JOIN fusha_operimi 
              ON tender.fushe_operimi_id=fusha_operimi.id 
              WHERE tender.emer_statusi='aktiv' 
              AND tender.is_deleted=0 
              AND tender.data_perfundimit>= DATE_ADD(CURDATE(), INTERVAL 1 DAY)
              ORDER by tender.id , tender.id DESC";

            $statement = $entityManager->getConnection()->prepare($query);
            $statement->execute();
            $tenderFeed = $statement->fetchAll();
            $MobileTender=$tenderFeed;



        return $this->render('feed_test.html.twig', [
            'tenderat'=>$tenderFeed,
            'logoUrl'=>$logopath,
            'biznesName'=>$biznesName,
            'mobileTender'=>$MobileTender
        ]);


    }



}
