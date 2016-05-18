<?php

namespace Interpro\Answerer\Concept;

interface AnswerListFactory
{
    /**
     * @param  string $encrypted_set
     * @return \Interpro\QuickStorage\Concept\Collection\GroupCollection
     *
     */
    public function create($encrypted_set);

}
