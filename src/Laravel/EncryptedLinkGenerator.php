<?php

namespace Interpro\Answerer\Laravel;

use Interpro\Answerer\Concept\EncryptedLinkGenerator as EncryptedLinkGeneratorInterface;

class EncryptedLinkGenerator implements EncryptedLinkGeneratorInterface
{
    /**
     * @param string $parent_id
     * @param array $answers
     * @return string
     *
     */
    public function generate($parent_id, $answers)
    {
        $encrypted_link = 'p'.$parent_id;

        foreach($answers as $id){
            $encrypted_link .= 'q'.$id;
        }
    }

}
