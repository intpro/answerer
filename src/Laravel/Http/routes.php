<?php

Route::post('/answerer/generate',   ['as' => 'answerer_generate', 'uses' => 'Interpro\Answerer\Laravel\Http\AnswererController@makeLink']);
