<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180109132810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item_pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', produto_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', quantidade NUMERIC(10, 2) NOT NULL, precoUnitario NUMERIC(10, 2) NOT NULL, percentualDesconto NUMERIC(10, 2) NOT NULL, total NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_42156301BF396750 (id), INDEX IDX_42156301105CFD56 (produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_42156301105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE pedido CHANGE id id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE item_pedido');
        $this->addSql('ALTER TABLE pedido CHANGE id id CHAR(36) NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:uuid)\'');
    }
}
