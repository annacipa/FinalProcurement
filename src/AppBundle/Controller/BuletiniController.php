<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Tender;
use AppBundle\Entity\Biznes;
use AppBundle\Entity\FushaOperimi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\UserRegisterType;
use AppBundle\Form\LoginAdminType;

class BuletiniController extends controller
{
    /**
     * @Route("/buletini", name="buletini")
     */

    public function feedBuletin(EntityManagerInterface $entityManager){
      if (( $this->get('session')->get('loginUserId') != null ) && ( $this->get('session')->get('roleId') != 4 ))
      {
          
          $today=new \DateTime();
          $repository=$entityManager->getRepository(Tender::class);
          $biznesId=$this->get('session')->get('loginUserId');
          $Query="SELECT emer_biznesi, logo
                    From biznes
                    Where biznes.id=:biznesID ";
          $statement = $entityManager->getConnection()->prepare($Query);
          $statement->execute(array('biznesID'=>$biznesId));
          $profili = $statement->fetchAll();

          $biznesName= $profili[0]["emer_biznesi"];
          $logopath="/uploads/logo/".$profili[0]['logo'];
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
      }

      else{
        return $this->redirectToRoute('landingpage');
      }

        return $this->render('feed.html.twig', [
            'tenderat'=>$tenderFeed,
            'logoUrl'=>$logopath,
            'biznesName'=>$biznesName,
            'biznesId'=>$biznesId
        ]);


    }



}