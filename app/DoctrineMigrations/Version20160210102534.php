<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160210102534 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE script (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1C81873A772E836A (identifier), INDEX fk_script_identifier (identifier), INDEX fk_script_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_FEFDAB8E772E836A (identifier), INDEX fk_view_identifier (identifier), INDEX fk_view_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_3A3A6BE2772E836A (identifier), INDEX fk_layout_identifier (identifier), INDEX fk_layout_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE script');
        $this->addSql('DROP TABLE view');
        $this->addSql('DROP TABLE layout');
    }
}
