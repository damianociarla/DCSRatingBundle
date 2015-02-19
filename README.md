DCSRatingBundle
===============

The DCSRatingBundle adds support for a rating system in Symfony2. Features include:

* You can add your vote to any page with a single line of code.
* You can integrate it with any user management system (eg FOSUserBundle)
* You can set different roles for access to the vote
* The bundle using one stylesheet file without javascript file

## 1) Installation

### A) Download and install DCSRatingBundle

To install DCSRatingBundle run the following command

	bash $ php composer.phar require damianociarla/rating-bundle

### B) Enable the bundle

Enable the required bundles in the kernel:

	<?php
	// app/AppKernel.php

	public function registerBundles()
	{
	    $bundles = array(
        	// ...
        	new DCS\RatingBundle\DCSRatingBundle(),
    	);
	}

## 2) Create your Vote and Rating classes

In this first release DCSRatingBundle supports only Doctrine ORM. However, you must provide a concrete Vote and Rating class.
You must extend the abstract entities provided by the bundle and creating the appropriate mappings.

### Rating

    <?php
    // src/MyProject/MyBundle/Entity/Rating.php

    namespace MyProject\MyBundle\Entity;

    use DCS\RatingBundle\Entity\Rating as BaseRating;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
     */
    class Rating extends BaseRating
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="string")
         */
        protected $id;

        /**
         * @ORM\OneToMany(targetEntity="MyProject\MyBundle\Entity\Vote", mappedBy="rating")
         */
        protected $votes;
    }

### Vote

    <?php
    // src/MyProject/MyBundle/Entity/Vote.php

    namespace MyProject\MyBundle\Entity;

    use DCS\RatingBundle\Entity\Vote as BaseVote;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
     */
    class Vote extends BaseVote
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\ManyToOne(targetEntity="MyProject\MyBundle\Entity\Rating", inversedBy="votes")
         * @ORM\JoinColumn(name="rating_id", referencedColumnName="id")
         */
        protected $rating;

        /**
         * @ORM\ManyToOne(targetEntity="MyProject\UserBundle\Entity\User")
         */
        protected $voter;
    }

## 3) Configure your application

	# app/config/config.yml

	dcs_rating:
        db_driver: orm
        base_path_to_redirect: / # when the permalink is not configured
        max_value: 5 # maximum value for the vote (stars displayed)
        model:
            rating: MyProject\MyBundle\Entity\Rating
            vote: MyProject\MyBundle\Entity\Vote

## 4) Import DCSRatingBundle routing

Import the bundle routing:

	dcs_rating:
	    resource: "@DCSRatingBundle/Resources/config/routing.xml"
    	prefix:   /

## 5) Import stylesheet in your template

To import the stylesheet run the following command:

	bash $ php app/console assets:install

and include the stylesheet in your template:

	<link rel="stylesheet" href="{{ asset('bundles/dcsrating/css/rating.css') }}" />
	
### 5.1) Enable vote via ajax

To vote via ajax you have to include the script below after loading the jQuery library:

    <script src="{{ asset('bundles/dcsrating/js/rating.js') }}"></script>

## 6) Showing rating and enabling vote

**You can only vote the page you are in. You can not vote a page while you are on a different one. But you can show the rating of a page (read-only mode) in any page**

### Showing rating

You can show rating using stars without enabling voting:

	{% include 'DCSRatingBundle:Rating:rating.html.twig' with {'id' : 'YOUR_UNIQUE_ID'} %}

This is useful if you have a list of items and want to show the rating of each item.

### Enabling vote

To enable voting on a page use the following twig code:

	{% include 'DCSRatingBundle:Rating:control.html.twig' with {'id' : 'YOUR_UNIQUE_ID'} %}

If you need to change the default user role for a specific page, add the `role` parameter:

	{% include 'DCSRatingBundle:Rating:control.html.twig' with {'id' : 'YOUR_UNIQUE_ID', 'role' : 'ROLE_USER'} %}

If you need to change the permalink, add the `permalink` parameter, otherwise it will be stored the current route:

	{% include 'DCSRatingBundle:Rating:control.html.twig' with {'id' : 'YOUR_UNIQUE_ID', 'permalink' : url('YOUR_ROUTE_ID')} %}