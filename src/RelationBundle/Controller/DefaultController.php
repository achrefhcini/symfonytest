<?php

namespace RelationBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/relation")
     */
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $currentUser= $this->get('security.token_storage')->getToken()->getUser();
        $myFriends = $currentUser->getMyfriends();
        foreach ($users as $key => $user){
                if ($user==$currentUser){
                    unset($users[$key]);
                }
                foreach ($myFriends as $keyF => $friend){
                    if($user==$friend){
                        unset($users[$key]) ;
                    }
            }
        }

        return $this->render('RelationBundle:Default:index.html.twig',array('users' =>   $users,'friends'=>$myFriends));
    }
         /**
         * @Route("/relation/{id}", methods={"GET","HEAD"})
          */

        public function VoirAction($id)
        {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserBy(array('id'=>$id));


            return $this->render('RelationBundle:Default:profile.html.twig',array('user' =>   $user));
        }

    /**
     * @Route("/relation/{id}/add", methods={"GET","HEAD"})
     */

    public function AddFriendAction($id){

            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserBy(array('id'=>$id));

            $currentUser=$this->get('security.token_storage')->getToken()->getUser();
             $currentUser->addFriend($user);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($currentUser);
                $entityManager->flush();

        return $this->indexAction();


    }

    /**
     * @Route("/relation/{id}/remove", methods={"GET","HEAD"})
     */

    public function RemoveAction($id){

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        $currentUser=$this->get('security.token_storage')->getToken()->getUser();
        $currentUser->removeFriend($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($currentUser);
        $entityManager->flush();
        return $this->indexAction();



    }

}
