<?php

namespace App\Repository;

use App\Entity\Produto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProdutoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Produto::class);
    }

    public function findByTerm($term)
    {
        return $this->createQueryBuilder('p')
            ->where("p.nome LIKE :nome")->setParameter('nome', "%$term%")
            ->orWhere("p.codigo LIKE :codigo")->setParameter('codigo', "%$term%")
            ->orWhere("p.precoUnitario LIKE :precoUnitario")->setParameter('precoUnitario', "%$term%")
            ->orderBy('p.nome', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
