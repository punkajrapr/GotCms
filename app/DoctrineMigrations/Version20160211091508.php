<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160211091508 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE datatype (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, prevalue_value VARCHAR(255) DEFAULT NULL, INDEX fk_user_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE script (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_1C81873A772E836A (identifier), INDEX fk_script_identifier (identifier), INDEX fk_script_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE view (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_FEFDAB8E772E836A (identifier), INDEX fk_view_identifier (identifier), INDEX fk_view_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_acl_role (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX fk_user_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_acl (user_acl_role_id INT NOT NULL, user_acl_permission_id INT NOT NULL, INDEX IDX_57960C991428E0FA (user_acl_role_id), INDEX IDX_57960C9952C3368A (user_acl_permission_id), PRIMARY KEY(user_acl_role_id, user_acl_permission_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, view_id INT NOT NULL, layout_id INT NOT NULL, user_id INT NOT NULL, document_type_id INT NOT NULL, parent_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, url_key VARCHAR(255) NOT NULL, status INT DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, show_in_nav TINYINT(1) DEFAULT \'0\' NOT NULL, can_be_cached TINYINT(1) DEFAULT \'0\' NOT NULL, locale VARCHAR(255) DEFAULT NULL, INDEX IDX_D8698A7631518C7 (view_id), INDEX IDX_D8698A768C22AA1A (layout_id), INDEX IDX_D8698A76A76ED395 (user_id), INDEX IDX_D8698A7661232A4F (document_type_id), INDEX IDX_D8698A76727ACA70 (parent_id), INDEX fk_document_name (name), INDEX fk_document_url_key (url_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_acl_resource (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, resource VARCHAR(255) NOT NULL, INDEX fk_user_acl_resource_resource (resource), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, login VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, retrieve_password_key VARCHAR(255) DEFAULT NULL, retrieve_password_date DATETIME DEFAULT NULL, INDEX fk_user_login (login), INDEX fk_user_email (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, INDEX fk_module_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tab (id INT AUTO_INCREMENT NOT NULL, document_type_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, `order` INT DEFAULT 0 NOT NULL, INDEX IDX_73E3430C61232A4F (document_type_id), INDEX fk_document_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, tab_id INT NOT NULL, datatype_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, required TINYINT(1) NOT NULL, `order` INT NOT NULL, UNIQUE INDEX UNIQ_8BF21CDE772E836A (identifier), INDEX IDX_8BF21CDE8D0C9323 (tab_id), INDEX IDX_8BF21CDE5C815A09 (datatype_id), INDEX fk_property_identifier (identifier), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_acl_permission (id INT AUTO_INCREMENT NOT NULL, user_acl_resource_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, permission VARCHAR(255) NOT NULL, INDEX IDX_DD088CE6F665D180 (user_acl_resource_id), INDEX fk_user_acl_permission_permission (permission), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_type (id INT AUTO_INCREMENT NOT NULL, default_view_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_2B6ADBBAF1904982 (default_view_id), INDEX IDX_2B6ADBBAA76ED395 (user_id), INDEX fk_user_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_value (id INT AUTO_INCREMENT NOT NULL, document_id INT NOT NULL, property_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, value LONGBLOB NOT NULL, INDEX IDX_DB649939C33F7837 (document_id), INDEX IDX_DB649939549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE layout (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_3A3A6BE2772E836A (identifier), INDEX fk_layout_identifier (identifier), INDEX fk_layout_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_acl ADD CONSTRAINT FK_57960C991428E0FA FOREIGN KEY (user_acl_role_id) REFERENCES user_acl_role (id)');
        $this->addSql('ALTER TABLE user_acl ADD CONSTRAINT FK_57960C9952C3368A FOREIGN KEY (user_acl_permission_id) REFERENCES user_acl_permission (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7631518C7 FOREIGN KEY (view_id) REFERENCES view (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A768C22AA1A FOREIGN KEY (layout_id) REFERENCES layout (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7661232A4F FOREIGN KEY (document_type_id) REFERENCES document_type (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76727ACA70 FOREIGN KEY (parent_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE tab ADD CONSTRAINT FK_73E3430C61232A4F FOREIGN KEY (document_type_id) REFERENCES document_type (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE8D0C9323 FOREIGN KEY (tab_id) REFERENCES tab (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE5C815A09 FOREIGN KEY (datatype_id) REFERENCES datatype (id)');
        $this->addSql('ALTER TABLE user_acl_permission ADD CONSTRAINT FK_DD088CE6F665D180 FOREIGN KEY (user_acl_resource_id) REFERENCES user_acl_resource (id)');
        $this->addSql('ALTER TABLE document_type ADD CONSTRAINT FK_2B6ADBBAF1904982 FOREIGN KEY (default_view_id) REFERENCES view (id)');
        $this->addSql('ALTER TABLE document_type ADD CONSTRAINT FK_2B6ADBBAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property_value ADD CONSTRAINT FK_DB649939C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE property_value ADD CONSTRAINT FK_DB649939549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE5C815A09');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7631518C7');
        $this->addSql('ALTER TABLE document_type DROP FOREIGN KEY FK_2B6ADBBAF1904982');
        $this->addSql('ALTER TABLE user_acl DROP FOREIGN KEY FK_57960C991428E0FA');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76727ACA70');
        $this->addSql('ALTER TABLE property_value DROP FOREIGN KEY FK_DB649939C33F7837');
        $this->addSql('ALTER TABLE user_acl_permission DROP FOREIGN KEY FK_DD088CE6F665D180');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A76ED395');
        $this->addSql('ALTER TABLE document_type DROP FOREIGN KEY FK_2B6ADBBAA76ED395');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE8D0C9323');
        $this->addSql('ALTER TABLE property_value DROP FOREIGN KEY FK_DB649939549213EC');
        $this->addSql('ALTER TABLE user_acl DROP FOREIGN KEY FK_57960C9952C3368A');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A7661232A4F');
        $this->addSql('ALTER TABLE tab DROP FOREIGN KEY FK_73E3430C61232A4F');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A768C22AA1A');
        $this->addSql('DROP TABLE datatype');
        $this->addSql('DROP TABLE script');
        $this->addSql('DROP TABLE view');
        $this->addSql('DROP TABLE user_acl_role');
        $this->addSql('DROP TABLE user_acl');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE user_acl_resource');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE tab');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE user_acl_permission');
        $this->addSql('DROP TABLE document_type');
        $this->addSql('DROP TABLE property_value');
        $this->addSql('DROP TABLE layout');
    }
}
