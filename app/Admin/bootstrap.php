<?php

use App\Admin\Extensions\Form\CKEditor;
use Encore\Admin\Form;

Encore\Admin\Form::forget(['map', 'editor']);
Form::extend('ckeditor', CKEditor::class);


