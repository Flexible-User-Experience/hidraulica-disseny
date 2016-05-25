<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160426175058 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, client_email VARCHAR(255) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, total_amount INT DEFAULT NULL, currency_code VARCHAR(255) DEFAULT NULL, details LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_token (hash VARCHAR(255) NOT NULL, details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', after_url LONGTEXT DEFAULT NULL, target_url LONGTEXT NOT NULL, gateway_name VARCHAR(255) NOT NULL, PRIMARY KEY(hash)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart ADD payment_id INT DEFAULT NULL, ADD delivery_amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL, ADD base_amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL, ADD vat_tax INT DEFAULT 0 NOT NULL, CHANGE status status INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B74C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B74C3A3BB ON cart (payment_id)');
        $this->addSql('ALTER TABLE cart_item ADD base_amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7927C74 ON customer (email)');
        $this->addSql('ALTER TABLE product ADD show_in_homepage TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE work ADD show_in_homepage TINYINT(1) DEFAULT \'1\' NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B74C3A3BB');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE payment_token');
        $this->addSql('DROP INDEX UNIQ_BA388B74C3A3BB ON cart');
        $this->addSql('ALTER TABLE cart DROP payment_id, DROP delivery_amount, DROP base_amount, DROP vat_tax, CHANGE status status INT NOT NULL');
        $this->addSql('ALTER TABLE cart_item DROP base_amount');
        $this->addSql('DROP INDEX UNIQ_81398E09E7927C74 ON customer');
        $this->addSql('ALTER TABLE product DROP show_in_homepage');
        $this->addSql('ALTER TABLE work DROP show_in_homepage');
    }
}
