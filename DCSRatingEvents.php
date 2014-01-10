<?php

namespace DCS\RatingBundle;

class DCSRatingEvents
{
    const RATING_CREATE = 'dcs_rating.event.rating.create';
    const RATING_PRE_PERSIST = 'dcs_rating.event.rating.pre_persist';
    const RATING_POST_PERSIST = 'dcs_rating.event.rating.post_persist';

    const VOTE_CREATE = 'dcs_rating.event.vote.create';
    const VOTE_PRE_PERSIST = 'dcs_rating.event.vote.pre_persist';
    const VOTE_POST_PERSIST = 'dcs_rating.event.vote.post_persist';
}
