<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180110175013 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE produto (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', codigo VARCHAR(255) NOT NULL, nome VARCHAR(255) NOT NULL, precoUnitario NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_5CAC49D7BF396750 (id), UNIQUE INDEX UNIQ_5CAC49D720332D99 (codigo), UNIQUE INDEX UNIQ_5CAC49D754BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pessoa (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, dataNascimento DATE NOT NULL, UNIQUE INDEX UNIQ_1CDFAB82BF396750 (id), UNIQUE INDEX UNIQ_1CDFAB8254BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', cliente_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', numero INT DEFAULT NULL, emissao DATE NOT NULL, total NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_C4EC16CEBF396750 (id), INDEX IDX_C4EC16CEDE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', produto_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', quantidade NUMERIC(10, 2) NOT NULL, precoUnitario NUMERIC(10, 2) NOT NULL, percentualDesconto NUMERIC(10, 2) NOT NULL, total NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_42156301BF396750 (id), INDEX IDX_42156301105CFD56 (produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_42156301105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES pessoa (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item_pedido DROP FOREIGN KEY FK_42156301105CFD56');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CEDE734E51');
        $this->addSql('DROP TABLE item_pedido');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE pessoa');
        $this->addSql('DROP TABLE pedido');
    }
}
