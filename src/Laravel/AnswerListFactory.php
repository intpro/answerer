<?php

namespace Interpro\Answerer\Laravel;

use Interpro\Answerer\Concept\AnswererException;
use Interpro\Answerer\Concept\AnswerListFactory as AnswerListFactoryInterface;
use Interpro\QuickStorage\Concept\QueryAgent as QueryAgentInterface;
use Interpro\QuickStorage\Concept\StorageStructure;

class AnswerListFactory implements AnswerListFactoryInterface
{
    private $queryAgent;
    private $storageStructure;

    /**
     * @param  \Interpro\QuickStorage\Concept\QueryAgent $queryAgent
     * @return void
     */
    public function __construct(QueryAgentInterface $queryAgent, StorageStructure $storageStructure){
        $this->queryAgent = $queryAgent;
        $this->storageStructure = $storageStructure;
    }

    /**
     * @param  string $encrypted_set
     * @return \Interpro\QuickStorage\Concept\Collection\GroupCollection
     *
     */
    public function create($encrypted_set)
    {
        $config = config('answerer');

        $block_name = $config['block_name'];
        $group_name = $config['group_name'];

        if(!$this->storageStructure->blockExist($block_name)){
            throw new AnswererException('Блока '.$block_name.' не существует.');
        }
        if(!$this->storageStructure->groupInBlockExist($block_name, $group_name)){
            throw new AnswererException('Группы '.$group_name.' блока '.$block_name.' не существует.');
        }

        $params = explode('q', $encrypted_set);

        $answers = [];

        //Пропустим первый элемент - остальное id вопрос-ответов
        for( $i = 1; $i < count($params); $i++) {
            $answers[] = hexdec($params[$i]);
        }

        //Пропустим первый символ (p) - остальное id элемента группы родителя
        $owner_id = (int) hexdec(substr($params[0], 1));

        //Сортировка по полю sorter (оно инкрементится автоматически)
        $sorts = [$group_name => ['sorter'=>'ASC']];

        //Условия по родителю, и id - переданным от фронта развернутом из hex вида
        $specs = [$group_name => ['owner_id' => $owner_id, 'id' => $answers]];

        $collection =  $this->queryAgent->getGroupFlat($block_name, $group_name, $sorts, $specs);

        return $collection;

    }

}
