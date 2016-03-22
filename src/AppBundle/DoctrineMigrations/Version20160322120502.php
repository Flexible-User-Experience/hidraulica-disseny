<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160322120502 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_BA388B79395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, cart_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_F0FE25271AD5CDBF (cart_id), INDEX IDX_F0FE25274584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, description TEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message TEXT NOT NULL, checked TINYINT(1) NOT NULL, answered TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_CDEABF3F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position INT NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D34A04AD2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_image (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_1846DB70232D562B (object_id), UNIQUE INDEX lookup_product_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_category_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_99823999232D562B (object_id), UNIQUE INDEX lookup_work_category_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_ABA8A5AC232D562B (object_id), UNIQUE INDEX lookup_work_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, date_of_birth DATETIME DEFAULT NULL, firstname VARCHAR(64) DEFAULT NULL, lastname VARCHAR(64) DEFAULT NULL, website VARCHAR(64) DEFAULT NULL, biography VARCHAR(1000) DEFAULT NULL, gender VARCHAR(1) DEFAULT NULL, locale VARCHAR(8) DEFAULT NULL, timezone VARCHAR(64) DEFAULT NULL, phone VARCHAR(64) DEFAULT NULL, facebook_uid VARCHAR(255) DEFAULT NULL, facebook_name VARCHAR(255) DEFAULT NULL, facebook_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', twitter_uid VARCHAR(255) DEFAULT NULL, twitter_name VARCHAR(255) DEFAULT NULL, twitter_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', gplus_uid VARCHAR(255) DEFAULT NULL, gplus_name VARCHAR(255) DEFAULT NULL, gplus_data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', token VARCHAR(255) DEFAULT NULL, two_step_code VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_AD8A54A992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_AD8A54A9A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position INT NOT NULL, slug VARCHAR(255) NOT NULL, workCategory_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_534E68802B36786B (title), INDEX IDX_534E6880ECF24F9E (workCategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D3F9939D2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_image (id INT AUTO_INCREMENT NOT NULL, work_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, removed_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) DEFAULT NULL, position INT NOT NULL, INDEX IDX_EDC67F70BB3453DB (work_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_classes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_type VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_69DD750638A36066 (class_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_security_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(200) NOT NULL, username TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8835EE78772E836AF85E0677 (identifier, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_object_identity_id INT UNSIGNED DEFAULT NULL, class_id INT UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 (object_identifier, class_id), INDEX IDX_9407E54977FA751A (parent_object_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INT UNSIGNED NOT NULL, ancestor_id INT UNSIGNED NOT NULL, INDEX IDX_825DE2993D9AB4A6 (object_identity_id), INDEX IDX_825DE299C671CEA1 (ancestor_id), PRIMARY KEY(object_identity_id, ancestor_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_entries (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_id INT UNSIGNED NOT NULL, object_identity_id INT UNSIGNED DEFAULT NULL, security_identity_id INT UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INT NOT NULL, granting TINYINT(1) NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success TINYINT(1) NOT NULL, audit_failure TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 (class_id, object_identity_id, field_name, ace_order), INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 (class_id, object_identity_id, security_identity_id), INDEX IDX_46C8B806EA000B10 (class_id), INDEX IDX_46C8B8063D9AB4A6 (object_identity_id), INDEX IDX_46C8B806DF9183C9 (security_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B79395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25274584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB70232D562B FOREIGN KEY (object_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_category_translation ADD CONSTRAINT FK_99823999232D562B FOREIGN KEY (object_id) REFERENCES work_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_translation ADD CONSTRAINT FK_ABA8A5AC232D562B FOREIGN KEY (object_id) REFERENCES work (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E6880ECF24F9E FOREIGN KEY (workCategory_id) REFERENCES work_category (id)');
        $this->addSql('ALTER TABLE work_image ADD CONSTRAINT FK_EDC67F70BB3453DB FOREIGN KEY (work_id) REFERENCES work (id)');
        $this->addSql('ALTER TABLE acl_object_identities ADD CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id)');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B79395C3F3');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25274584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB70232D562B');
        $this->addSql('ALTER TABLE work_translation DROP FOREIGN KEY FK_ABA8A5AC232D562B');
        $this->addSql('ALTER TABLE work_image DROP FOREIGN KEY FK_EDC67F70BB3453DB');
        $this->addSql('ALTER TABLE work_category_translation DROP FOREIGN KEY FK_99823999232D562B');
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E6880ECF24F9E');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9');
        $this->addSql('ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE admin_group');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE slider_image');
        $this->addSql('DROP TABLE product_translation');
        $this->addSql('DROP TABLE work_category_translation');
        $this->addSql('DROP TABLE work_translation');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE work');
        $this->addSql('DROP TABLE work_category');
        $this->addSql('DROP TABLE work_image');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_entries');
    }
}
