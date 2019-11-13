<?php

namespace AnthonySterling\QueryExpression\Token;

interface Token
{
    const IS = 'is';
    const NOT = 'not';
    const BETWEEN = 'between';
    const NEAR = 'near';
    const IN = 'in';
    const NOTIN = 'not-in';
    const LESSTHAN = 'less-than';
    const MORETHAN = 'more-than';
    const ISORLESSTHAN = 'is-or-less-than';
    const ISORMORETHAN = 'is-or-more-than';
    const CONTAINS = 'contains';
    const NOTCONTAINS = 'not-contains';
    const MATCHES = 'matches';
    const NOTMATCHES = 'not-matches';
    const ISEMPTY = 'is-empty';
    const AFTER = 'after';
    const BEFORE = 'before';
    const SORT = 'sort';

    public function getKey();
    public function getType();
    public function getValue();
    public function toArray();
}
