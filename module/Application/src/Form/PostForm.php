<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Application\Entity\Post;


class PostForm extends Form
{
    /**
     * Конструктор.
     */
    public function __construct()
    {
        // Определяем имя формы.
        parent::__construct('post-form');
       // Задает для этой формы метод POST.
        $this->setAttribute('method','post');
        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * Этот метод добавляет элементы к форме (поля ввода и кнопку отправки формы).
     */
    protected function addElements()
    {
        //"title"
        $this->add([
            'type' => 'text',
            'name' => 'title',
            'attributes'=>[
                'id'=>'title'
            ],
            'options' =>[
                'label' =>'Title',
            ],

        ]);
        //"content"
        $this->add([
            'type' => 'textarea',
            'name' => 'content',
            'attributes' => [
                'id' => 'content'
            ],
            'options' =>[
                'label'=>'Content'
            ],

        ]);
        //"tags"
        $this->add([
            'type'=>'text',
            'name'=>'tags',
            'attributes'=>[
                'id'=>'tags'
            ],
            'options'=>[
                'label'=>'Tags'
            ],

        ]);
        //"status"
        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'attributes' => [
                'id' => 'status'
            ],
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    Post::STATUS_PUBLISHED => 'Published',
                    Post::STATUS_DRAFT => 'Draft',
                ],
            ],
        ]);

        $this->add([
            'type'=>'submit',
            'name'=>'submit',
            'attributes'=>[
                'value'=>'Create',
                'id'=>'submitbutton',
            ],
        ]);
    }

    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);


        //Фильтр на ввод Заглавия
        $inputFilter->add([
            'name'     => 'title',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],       //лишние пробелы
                ['name' => 'StripTags'],        //нуль байты а так же html и php фрагменты кода
                ['name' => 'StripNewlines'],    //
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 1024
                    ],
                ],
            ],
        ]);

        //Фильтр на ввод самого текста поста
        $inputFilter->add([
            'name'     => 'content',
            'required' => true,
            'filters'  => [
                ['name' => 'StripTags'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 4096
                    ],
                ],
            ],
        ]);

        //Фильтр на ввод тегов
        $inputFilter->add([
            'name'     => 'tags',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],           //лишние пробелы
                ['name' => 'StripTags'],            //нуль байты а так же html и php фрагменты кода
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 1024
                    ],
                ],
            ],
        ]);

        //Фильтр на ввод состояния поста
        $inputFilter->add([
            'name' => 'status',
            'required' => true,
            'validators' => [
                [
                    'name' => 'InArray',
                    'options'=> [
                        'haystack' => [Post::STATUS_PUBLISHED, Post::STATUS_DRAFT],
                    ]
                ],
            ],
        ]);



    }




}