<?php

namespace App\Repository;

use App\Entity\Pessoa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PessoaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pessoa::class);
    }


    public function findByTerm($term)
    {
        return $this->createQueryBuilder('p')
            ->where("p.nome LIKE :nome")->setParameter('nome', "%$term%")
            ->orWhere("p.dataNascimento LIKE :dataNascimento")->setParameter('dataNascimento', "%$term%")
            ->orderBy('p.nome', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

}
