<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180109132034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', cliente_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', numero INT NOT NULL, emissao DATE NOT NULL, total NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_C4EC16CEBF396750 (id), UNIQUE INDEX UNIQ_C4EC16CEF55AE19E (numero), INDEX IDX_C4EC16CEDE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES pessoa (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pedido');
    }
}
