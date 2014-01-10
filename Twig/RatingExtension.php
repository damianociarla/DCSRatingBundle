<?php

namespace DCS\RatingBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

class RatingExtension extends \Twig_Extension
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getDefaultSecurityRole', array($this, 'getDefaultSecurityRoleFunction')),
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('isHalfStar', array($this, 'isHalfStarFilter')),
        );
    }

    public function getDefaultSecurityRoleFunction()
    {
        return $this->container->getParameter('dcs_rating.base_security_role');
    }

    public function isHalfStarFilter($value, $compareValue)
    {
        if (ceil($value) == $compareValue) {
            $whole = floor($value);
            $fraction = $value - $whole;

            return $fraction >= 0.5;
        }

        return false;
    }

    public function getName()
    {
        return 'rating_extension';
    }
}
