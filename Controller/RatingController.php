<?php

namespace DCS\RatingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class RatingController extends Controller
{
    public function showRateAction($id)
    {
        $manager = $this->get('dcs_rating.manager.rating');

        if (null === $rating = $manager->findOneById($id)) {
            $rating = $manager->createRating($id);
            $manager->saveRating($rating);
        }

        return $this->render('DCSRatingBundle:Rating:star.html.twig', array(
            'rating' => $rating,
        ));
    }

    public function controlAction($id)
    {
        $ratingManager = $this->get('dcs_rating.manager.rating');
        $voteManager   = $this->get('dcs_rating.manager.vote');

        if (null === $rating = $ratingManager->findOneById($id)) {
            $rating = $ratingManager->createRating($id);
        }

        $ratingManager->saveRating($rating);

        if (!$this->get('security.context')->isGranted($rating->getSecurityRole())) {
            $viewName = 'star';
        } else {
            $viewName = (null === $voteManager->findOneByRatingAndVoter($rating, $this->getUser()))
            ? 'choice'
            : 'star';
        }

        return $this->render('DCSRatingBundle:Rating:'.$viewName.'.html.twig', array(
            'rating' => $rating
        ));
    }

    public function addVoteAction($id, $value)
    {
        if (null === $rating = $this->get('dcs_rating.manager.rating')->findOneById($id)) {
            throw new NotFoundHttpException('Rating not found');
        }

        if (null === $rating->getSecurityRole() || !$this->get('security.context')->isGranted($rating->getSecurityRole())) {
            throw new AccessDeniedHttpException('You can not perform the evaluation');
        }

        if (!is_numeric($value) || $value < 0 || $value > 5) {
            throw new BadRequestHttpException('You must specify a value between 0 and 5');
        }

        $user = $this->getUser();
        $voteManager = $this->get('dcs_rating.manager.vote');

        if (null !== $vote = $voteManager->findOneByRatingAndVoter($rating, $user)) {
            throw new AccessDeniedHttpException('You have already rated');
        }

        $vote = $voteManager->createVote($rating, $user);
        $vote->setValue($value);

        $voteManager->saveVote($vote);

        if ($this->get('request')->isXmlHttpRequest()) {
            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(array(
                'num_votes' => $rating->getNumVotes(),
                'rate' => $rating->getRate(),
            ));
        } else {
            $response = $this->redirect($rating->getPermalink());
        }

        return $response;
    }
}
