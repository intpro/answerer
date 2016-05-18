<?php

namespace Interpro\Answerer\Concept;

interface EncryptedLinkGenerator
{
    /**
     * @param string $parent_id
     * @param array $answers
     * @return string
     *
     */
    public function generate($parent_id, $answers);

}
