<?php

namespace DCS\RatingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
            'rate'   => $rating->getRate(),
            'maxValue' => $this->container->getParameter('dcs_rating.max_value'),
        ));
    }

    /**
     * @param mixed  $id
     * @param string $permalink
     * @param string $securityRole
     * @param array  $params
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function controlAction($id, $permalink = '', $securityRole = '', $params = array())
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
            $isUnique = $this->container->getParameter('dcs_rating.unique_vote');
            $viewName = (!$isUnique || ($isUnique && null === $voteManager->findOneByRatingAndVoter($rating, $this->getUser())))
                ? 'choice'
                : 'star';
        }

        return $this->render('DCSRatingBundle:Rating:'.$viewName.'.html.twig', array(
            'rating' => $rating,
            'rate'   => $rating->getRate(),
            'params' => $this->get('request')->get('params', array()),
            'maxValue' => $this->container->getParameter('dcs_rating.max_value'),
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

        $maxValue = $this->container->getParameter('dcs_rating.max_value');

        if (!is_numeric($value) || $value < 0 || $value > $maxValue) {
            throw new BadRequestHttpException(sprintf('You must specify a value between 0 and %d', $maxValue));
        }

        $user = $this->getUser();
        $voteManager = $this->get('dcs_rating.manager.vote');

        if ($this->container->getParameter('dcs_rating.unique_vote') &&
            null !== $voteManager->findOneByRatingAndVoter($rating, $user)
        ) {
            throw new AccessDeniedHttpException('You have already rated');
        }

        $vote = $voteManager->createVote($rating, $user);
        $vote->setValue($value);

        $voteManager->saveVote($vote);

        if (null === $redirect = $this->get('request')->headers->get('referer', $rating->getPermalink())) {
            $pathToRedirect = $this->container->getParameter('dcs_rating.base_path_to_redirect');
            if ($this->get('router')->getRouteCollection()->get($pathToRedirect)) {
                $redirect = $this->generateUrl($pathToRedirect);
            } else {
                $redirect = $pathToRedirect;
            }
        }

        $response = $this->redirect($redirect);

        return $response;
    }
}
