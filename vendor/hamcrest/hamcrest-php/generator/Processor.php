<?php

namespace Faker\Provider\en_ZA;

class Person extends \Faker\Provider\Person
{
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
    );

    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}}',
        '{{titleFemale}} {{$firstNameFemale}} {{lastName}}',
    );

    protected static $firstNameMale = array(
        'Abraham', 'Adriaan', 'Adrian', 'Ahmed', 'Alan', 'Albert', 'Alex'