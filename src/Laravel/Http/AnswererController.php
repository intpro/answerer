<?php

namespace Interpro\Answerer\Laravel\Http;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Interpro\Answerer\Concept\EncryptedLinkGenerator;

class AnswererController extends Controller
{
    private $link_generator;

    public function __construct(EncryptedLinkGenerator $link_generator)
    {
        $this->link_generator = $link_generator;
    }

    public function makeLink()
    {
        if(Request::has('answers') and Request::has('parent_id'))
        {
            $dataobj = Request::all();

            try {

                $parent_id = $dataobj['parent_id'];

                $answers = $dataobj['answers'];

                $encrypted_link = $this->link_generator->generate($parent_id, $answers);

                return ['status' => 'OK', 'encrypted_link' => $encrypted_link];

            } catch(\Exception $exception) {

                return ['status' => ('Что-то пошло не так. '.$exception->getMessage())];
            }
        } else {

            return ['status' => 'Не хватает параметров для сохранения (массива ответов на вопросы answers или parent_id).'];
        }
    }

}
