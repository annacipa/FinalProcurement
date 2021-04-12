<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Dokumenta;
use AppBundle\Entity\FushaOperimi;
use AppBundle\Entity\Oferta;
use AppBundle\Entity\Tender;
use AppBundle\Form\TenderAktivType;
use AppBundle\Form\TenderType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TenderController extends Controller
{
    /**
     * @Route("/tender/tenderat_e_mi", name="tender_view", methods={"GET"})
     */
    public function tenderatTotal(EntityManagerInterface $entityManager)
    {
        if(( $this->get('session')->get('loginUserId') != null ) && ( $this->get('session')->get('roleId') != 4 )){

            $biznesId = $this->get('session')->get('loginUserId');
            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;

            $statusDraft = "draft";
            $today = new \DateTime();

            $repository = $entityManager->getRepository(Tender::class);

            $tenderAll = $repository->createQueryBuilder('q')
                ->andWhere('q.biznesId=:val')
                ->setParameter('val', $biznesId)
                ->andWhere('q.dataPerfundimit LIKE  :dataSot')
                ->setParameter('dataSot', "%" . $today->format('Y-m-d') . "%")
                ->andWhere('q.isDeleted=0')
                ->getQuery()
                ->getResult();
//dump($tenderAll);die();

            foreach ($tenderAll as $tender) {
                $tender->setEmerStatusi("inaktiv");
                $entityManager->persist($tender);
                $entityManager->flush();
            }

            $tenderDraft = $repository->createQueryBuilder('q')
                ->andWhere('q.biznesId=:val')
                ->setParameter('val', $biznesId)
                ->andWhere('q.emerStatusi=:statusDraft')
                ->andWhere('q.isDeleted=0')
                ->setParameter('statusDraft', $statusDraft)
                ->getQuery()
                ->getResult();

            $tenderAktivQuery = "
                SELECT tender.id as id,
                COUNT(oferta.id)as nrAplikimesh , 
                tender.titull_thirrje as titullThirrje, 
                tender.fond_limit as fondLimit, 
                tender.emer_statusi as emerStatusi, 
                oferta.id as ofertaID, 
                tender.data_perfundimit as dataPerfundimit 
                FROM oferta right join tender on oferta.tender_id=tender.id WHERE tender.is_deleted=0 
                And tender.emer_statusi='aktiv' And tender.biznes_id=:biznesId Group by tender.id;
                ";
            $statement = $entityManager->getConnection()->prepare($tenderAktivQuery);

            $statement->execute(array('biznesId' => $biznesId));
            $tendersAktiv = $statement->fetchAll();
            $Query="SELECT emer_biznesi 
                    From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$biznesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];


//       $tendersAktiv=$repository->createQueryBuilder('q')
////            ->andWhere('q.biznesId=:val')
//            ->setParameter('val',$biznesId)
//            ->andWhere('q.emerStatusi=:statusDraft')
//            ->setParameter('statusDraft',"aktiv")
//            ->andWhere('q.isDeleted=0')
//            ->getQuery()
//            ->getResult();
////        dump($tendersAktiv);die();

            $tenderInaktivvQuery = "SELECT tender.id as id,
                COUNT(oferta.id) as nrAplikimesh,
           
                tender.titull_thirrje as titullThirrje, 
                tender.fond_limit as fondLimit,
                tender.emer_statusi as emerStatusi,
                tender.data_perfundimit as dataPerfundimit FROM oferta
                right join tender on  oferta.tender_id=tender.id
                WHERE tender.is_deleted=0 
                And tender.emer_statusi='inaktiv'
                And tender.biznes_id=:biznesId
                GROUP BY tender.id;";

            $statement = $entityManager->getConnection()->prepare($tenderInaktivvQuery);

            $statement->execute(array('biznesId' => $biznesId));
            $tenderInaktiv = $statement->fetchAll();

//        $tenderInaktiv=$repository->createQueryBuilder('q')
//            ->andWhere('q.biznesId=:val')
//            ->setParameter('val',$biznesId)
//            ->andWhere('q.emerStatusi=:inaktivValue')
//            ->setParameter('inaktivValue','inaktiv')
//            ->andWhere('q.isDeleted=0')
//            ->getQuery()
//            ->getResult();
        } 
        else{
            return $this->redirectToRoute('landingpage');
        }

        return $this->render('tender/tenderatemi.html.twig', [
            'tendersAktiv' => $tendersAktiv,
            'tendersDraft' => $tenderDraft,
            'tenderInaktiv' => $tenderInaktiv,
            'logoUrl'=>$logopath
            ,
            'biznesName'=>$biznesName
        ]);
    }

    /**
     * @Route("/tender/krijoTender", name="tender_krijo")
     */
    public function tenderKrijo(Request $request)
    {
        if(( $this->get('session')->get('loginUserId') != null ) && ( $this->get('session')->get('roleId') != 4 )){

            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $entityManager=  $this->getDoctrine()->getManager();
            $Query="SELECT emer_biznesi 
                From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));

            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $tender = new Tender();
            $dokument = new Dokumenta();
            $form = $this->createForm(TenderType::class);
            $form->handleRequest($request);

            if ($form->isValid() && $form->isSubmitted()) {

                $entityManager = $this->getDoctrine()->getManager();
                $tender->setBiznesId($this->get('session')->get('loginUserId'));
                $tender->setCreatedBy($this->get('session')->get('loginUserId'));
                $tender->setStatus(1);
                $tender->setTitullThirrje($form->get('titullThirrje')->getData());
                $tender->setPershkrim($form->get('pershkrim')->getData());
                $tender->setDataPerfundimit($form->get('dataPerfundimit')->getData());
                $tender->setAdresaDorezimit($form->get('adresaDorezimit')->getData());
                $tender->setFondLimit($form->get('fondLimit')->getData());
                $tender->setLicenca($form->get('licenca')->getData());
                $tender->setEmerStatusi("draft");
                $tender->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());
                $date = new \DateTime();
                $tender->setDataFillimit($date);
                $tender->setIsDeleted(0);
    //file upload

                $uploads_directory = $this->getParameter('uploads_directory');
                $entityManager->persist($tender);
                $entityManager->flush();

                $files = $request->files->get('tender')['document'];
                foreach ($files as $file) {

                    $dokument = new Dokumenta();
                    $filename=$file->getClientOriginalName().$file->guessExtension();
                    $dokument->setTitullDokumenti($filename);
//                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move(
                        $uploads_directory,
                        $filename
                    );
//                    $dokument->setTitullDokumenti($filename);
                    $dokument->setTenderId($tender->getId());
                    $dokument->setPath($file);
                    $dokument->setIsDeleted(0);

                    $dokument->setCreatedBy($this->get('session')->get('loginUserId'));
//                    dump($dokument);
                    $entityManager->persist($dokument);
                    $entityManager->flush();


                }

                $this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );
                return $this->redirectToRoute('tender_view');
            }
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
        return $this->render('tender/index.html.twig', [
            'form' => $form->createView(),
            'logoUrl'=>$logopath
            ,
            'biznesName'=>$biznesName
        ]);

    }


    /**
     * @Route("/tender/{id}/shiko", name="tender_shiko")
     */
    public function shikoDetajet(Request $request, Tender $tender, EntityManagerInterface $entityManager)
    {
        if(( $this->get('session')->get('loginUserId') != null ) && ( $this->get('session')->get('roleId') != 4 )){

            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;

            $dokumenta = new Dokumenta();
            $repository = $entityManager->getRepository(FushaOperimi::class);
            $repositoryDokumenta = $entityManager->getRepository(Dokumenta::class);
            $businesId = $this->get('session')->get('loginUserId');
            $Query="SELECT emer_biznesi 
            From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$businesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $dokumenta = $repositoryDokumenta->createQueryBuilder('dok')
                ->andWhere('dok.tenderId=:idTender')
                ->setParameter('idTender', $tender->getId())
                ->getQuery()
                ->getResult();

            $fusheOperimi = $repository->createQueryBuilder('fop')
                ->andWhere('fop.id=:fusheOperimiTender')
                ->setParameter('fusheOperimiTender', $tender->getFusheOperimiId())
                ->getQuery()
                ->getResult();

            $fusheOperimi = $fusheOperimi[0]->getEmerFusheOperimi();
        }
        else{
            return $this->redirectToRoute('landingpage');
        }

        return $this->render('tender/ShikoDetaje.html.twig', [
            'tender' => $tender,
            'fusheOperimi' => $fusheOperimi,
            'dokumenta' => $dokumenta,
            'logoUrl'=>$logopath,
            'biznesName'=>$biznesName


        ]);
    }

    /**
     * @Route("/tender/{id}/modifiko", name="tender_edit")
     */
    public function modifikoDraft(Request $request, Tender $tender, EntityManagerInterface $entityManager)
    {
        if( ($this->get('session')->get('loginUserId') != null ) && ($this->get('session')->get('roleId') != 4) ){

            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;

            $form = $this->createForm(TenderType::class, $tender);
            $repositoryDokumenta = $entityManager->getRepository(Dokumenta::class);
            $businesId = $this->get('session')->get('loginUserId');
            $Query="SELECT emer_biznesi 
            From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$businesId));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];

            $dokumenta = $repositoryDokumenta->createQueryBuilder('dok')
                ->andWhere('dok.tenderId=:idTender')
                ->setParameter('idTender', $tender->getId())
                ->andWhere('dok.isDeleted=0')
                ->getQuery()
                ->getResult();

            $form->get('fushe_operimi_id')->setData($tender->getFusheOperimiId());

            $fusheOperim=new FushaOperimi();
            $fusheOperim=$fusheOperim->getId($tender->getFusheOperimiId());
            $form->get('fushe_operimi_id')->setData($fusheOperim);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                $tender->setFusheOperimiId($form->get('fushe_operimi_id')->getData()->getId());
                $this->getDoctrine()->getManager()->flush();
                $files = $request->files->get('tender')['document'];
                $uploads_directory = $this->getParameter('uploads_directory');

                foreach ($files as $file) {
                    $dokument = new Dokumenta();

                    $filename=$file->getClientOriginalName().$file->guessExtension();
                    $dokument->setTitullDokumenti($filename);
//                    $filename = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move(
                        $uploads_directory,
                        $filename
                    );
                    $dokument->setTitullDokumenti($filename);
                    $dokument->setTenderId($tender->getId());
                    $dokument->setPath($file);
                    $dokument->setIsDeleted(0);

                    $dokument->setCreatedBy($this->get('session')->get('loginUserId'));
                    /*dump($dokument);*/
                    $entityManager->persist($dokument);
                    $entityManager->flush();


                }
                return $this->redirectToRoute('tender_view');
            }
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
        return $this->render('tender/edit.html.twig', [
            'tender' => $tender,
            'form' => $form->createView(),
            'dokumenta' => $dokumenta,
            'logoUrl'=>$logopath
            ,
            'biznesName'=>$biznesName
        ]);
    }

    /**
     * @Route("/tender/{id}/publiko", name="tender_publiko_draft", methods={"GET","POST"})
     */

    public function publiko(Request $request, Tender $tender)
    {
        if( ($this->get('session')->get('loginUserId') != null ) && ($this->get('session')->get('roleId') != 4) ){
            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;

//        Beje Aktive
            $tender->setDataFillimit(new \DateTime());
            $tender->setEmerStatusi('aktiv');
            $this->getDoctrine()->getManager()->flush();

//            $this->addFlash(
//                'success',
//                'Ju keni publikuar:'.$tender->getTitullThirrje().'!'
//            );
            return $this->redirectToRoute('tender_view');
        }
        else{
            return $this->redirectToRoute('landingpage');
        }

    }

    /**
     * @Route("/tender/{id}/modifikoAktiv", name="tender_modifiko_aktiv", methods={"GET","POST"})
     */

    public function modifikoAktiv(Request $request, Tender $tender)
    {
        if( ($this->get('session')->get('loginUserId') != null ) && ($this->get('session')->get('roleId') != 4) ){
            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $Query="SELECT emer_biznesi 
            From biznes
                    Where biznes.id=:biznesID ";
            $entityManager= $this->getDoctrine()->getManager();
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));
            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];


            $form = $this->createForm(  TenderAktivType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $tender->setDataPerfundimit($form->get('dataPerfundimit')->getData());
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('tender_view');
            }
        }
        else{
            return $this->redirectToRoute('landingpage');
        }

        return $this->render('tender/modifikoaktiv.html.twig', [
            'tender' => $tender,
            'form' => $form->createView(),'logoUrl'=>$logopath,
            'biznesName'=>$biznesName
//
        ]);

    }

    /**
     * @Route("/tender/{id}/fshi", name="tender_fshi")
     */

    public function fshiTender(Request $request, Tender $tender, EntityManagerInterface $entityManager)
    {   if( ($this->get('session')->get('loginUserId') != null ) && ($this->get('session')->get('roleId') != 4) ){
            $entityManager->getRepository(Tender::class);
            $tender->setIsDeleted(1);
            $tender->setEmerStatusi('fshire');
            $entityManager->persist($tender);
            $entityManager->flush();
            return $this->redirectToRoute('tender_view');
        }
        else{
            return $this->redirectToRoute('landingpage');
        }

    }

    /**
     * @Route("/tender/{id}/mbyll", name="tender_mbyll")
     */

    public function MbyllTender(Request $request, Tender $tender, EntityManagerInterface $entityManager)
    {
        if( ($this->get('session')->get('loginUserId') != null ) && ($this->get('session')->get('roleId') != 4) ){

            $entityManager->getRepository(Tender::class);
            $tender->setEmerStatusi('inaktiv');
            $entityManager->persist($tender);
            $entityManager->flush();
            return $this->redirectToRoute('tender_view');
        }
        else{
            return $this->redirectToRoute('landingpage');
        }

    }
    /**
     * @Route("/tender_aktiv/{id}/ofertat", name="shiko_ofertat_tender_aktiv")
     */

    public function OfertatTenderAktiv(Request $request, Tender $tender, EntityManagerInterface $entityManager)
    {
        if( ($this->get('session')->get('loginUserId') != null ) && ($this->get('session')->get('roleId') != 4) ){

            $logopath=$this->get('session')->get('logoPath');
            $logopath="/uploads/logo/".$logopath;
            $ofertatQuery="SELECT oferta.id as 'OfertaId',
                     oferta.pershkrimi as 'OfertaPershkrim', 
                     oferta.vlefta, 
                     oferta.adresa_dorezimit, 
                     oferta.vendimi,
                     tender.id as 'tenderId', 
                     tender.pershkrim, 
                     biznes.id as 'biznesId', 
                     biznes.emer_biznesi, 
                     biznes.email, 
                     biznes.adresa, 
                     biznes.nipt 
                     From oferta Inner join tender on oferta.tender_id=tender.id 
                     inner join biznes on oferta.created_by=biznes.id
                     WHERE oferta.tender_id=:tenderId
                     AND oferta.is_deleted=0
                     And tender.is_deleted=0
                    ";

            $statement = $entityManager->getConnection()->prepare($ofertatQuery);

            $statement->execute(array('tenderId' => $tender->getId()));
            $ofertat = $statement->fetchAll();

            $Query="SELECT emer_biznesi 
            From biznes
                    Where biznes.id=:biznesID ";
            $statement = $entityManager->getConnection()->prepare($Query);
            $statement->execute(array('biznesID'=>$this->get('session')->get('loginUserId')));

            $profili = $statement->fetchAll();
            $biznesName= $profili[0]["emer_biznesi"];


            $repository = $entityManager->getRepository(FushaOperimi::class);
            $fusheOperimi = $repository->createQueryBuilder('fop')
                ->andWhere('fop.id=:fusheOperimiTender')
                ->setParameter('fusheOperimiTender', $tender->getFusheOperimiId())
                ->getQuery()
                ->getResult();

            $fusheOperimi = $fusheOperimi[0]->getEmerFusheOperimi();
        }
        else{
            return $this->redirectToRoute('landingpage');
        }
        return $this->render('tender/shikoOfertat.html.twig', [
            'ofertat'=>$ofertat,
            'tender'=>$tender,
            'fusheOperimi'=>$fusheOperimi,
            'logoUrl'=>$logopath,
            'biznesName'=>$biznesName


        ]);

//                return $this->redirectToRoute('tender_view');


    }
    /**
     * @Route("/ajax_delete" , name="ajax_delete")
     */

    public function deleteF(Request $request,EntityManagerInterface $entityManager)
    {
        $dokumentFshi = $request->get('itemId');
        $dokument = $entityManager->getRepository(Dokumenta::class)->find($dokumentFshi);
        $dokument->setIsDeleted(1);
        $entityManager->persist($dokument);
        $entityManager->flush();
        return new JsonResponse(array('message' => true));


    }
    /**
     * @Route("/shpallfitues/{id}" , name="shpall_fitues")
     */

    public function shpallFitues (Request $request,EntityManagerInterface $entityManager)
    {
        $idOferteFituese = $request->get('id');
        $idTender=$request->get('idTender');
//        dump($idTender);die();

        $ofertaFituese = $entityManager->getRepository(Oferta::class)->find($idOferteFituese);
//        dump($ofertaFituese);die();
        $ofertaFituese->setVendimi('fitues');
        $entityManager->persist($ofertaFituese);
        $entityManager->flush();

        $updateSql="UPDATE oferta set vendimi='humbes' where tender_id=:idTender and not oferta.id=:ofertaId";
        $statement = $entityManager->getConnection()->prepare($updateSql);

        $statement->execute(array('idTender' =>$idTender,'ofertaId'=>$idOferteFituese));
//        $ofertat = $statement->fetchAll();



        return $this->redirectToRoute('shiko_ofertat_tender_aktiv',array(
            'id'=>$idTender
        ));


    }


}