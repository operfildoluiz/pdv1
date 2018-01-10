<?php

namespace App\Repository;

use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PedidoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pedido::class);
    }

    public function findByTerm($term)
    {
        return $this->createQueryBuilder('p')
            ->where("p.numero LIKE :numero")->setParameter('numero', "%$term%")
            ->orWhere("p.emissao LIKE :emissao")->setParameter('emissao', "%$term%")
            ->orWhere("p.total LIKE :total")->setParameter('total', "%$term%")
            ->orderBy('p.numero', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
