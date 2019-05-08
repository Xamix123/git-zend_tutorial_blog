<?php
namespace Application\Service\Factory;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\PostManager;
class PostManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        // Инстанцируем сервис и внедряем зависимости.
        return new PostManager($entityManager);
    }
}

