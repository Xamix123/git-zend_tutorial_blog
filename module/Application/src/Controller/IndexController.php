<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Post;


class IndexController extends AbstractActionController
{


    /**
     * Менеджер сущностей.
     * @var EntityManager
     */
    private $entityManager;

    // Метод конструктора, используемый для внедрения зависимостей в контроллер.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Действие по умолчанию "index". Оно отображает страницу
    // Posts, содержащую последние посты блога.
    public function indexAction()
    {
        // Получаем недавние посты.
        $posts = $this->entityManager->getRepository(Post::class)
            ->findBy(['status'=>Post::STATUS_PUBLISHED],
                ['dateCreated'=>'DESC']);

        // Визуализируем шаблон представления.
        return new ViewModel([
            'posts' => $posts
        ]);
    }
}

