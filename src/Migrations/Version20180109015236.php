<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180109015236 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produto (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', codigo VARCHAR(255) NOT NULL, nome VARCHAR(255) NOT NULL, precoUnitario NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_5CAC49D7BF396750 (id), UNIQUE INDEX UNIQ_5CAC49D720332D99 (codigo), UNIQUE INDEX UNIQ_5CAC49D754BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CDFAB8254BD530C ON pessoa (nome)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP INDEX UNIQ_1CDFAB8254BD530C ON pessoa');
    }
}
