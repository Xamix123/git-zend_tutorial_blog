<?php
namespace Application\Service;

use Application\Entity\Post;
use Application\Entity\Comment;
use Application\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Zend\Filter\StaticFilter;


// Сервис The PostManager, отвечающий за дополнение новых постов.
class PostManager
{
    /**
     * Doctrine entity manager
     * @var EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //Метод добавляющий новый пост

    public function addNewPost($data)
    {
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $post->setStatus($data['status']);
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateCreated($currentDate);

        //добавляем сущность в менеджер сущностей
        $this->entityManager->persist($post);
        //добавляем теги к посту
        $this->addTagsToPost($data['tags'], $post);
        //применяем изменения к БД
        $this->entityManager->flush();




    }
    private function addTagsToPost($tagsStr,$post)
    {
        // Удаляем связи тегов (если таковые есть)
        $tags = $post->getTags();
        foreach ($tags as $tag) {
            $post->removeTagAssociation($tag);
        }

        // Добавляем теги к посту
        $tags = explode(',', $tagsStr);
        foreach ($tags as $tagName) {

            $tagName = StaticFilter::execute($tagName, 'StringTrim');
            if (empty($tagName)) {
                continue;
            }

            $tag = $this->entityManager->getRepository(Tag::class)
                ->findOneByName($tagName);
            if ($tag == null)
                $tag = new Tag();
            $tag->setName($tagName);
            $tag->addPost($post);

            $this->entityManager->persist($tag);

            $post->addTag($tag);
        }
    }
}



