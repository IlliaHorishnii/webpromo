<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209122125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_do_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE to_do_list_item (id INT AUTO_INCREMENT NOT NULL, is_done TINYINT(1) NOT NULL, text LONGTEXT DEFAULT NULL, views_count INT NOT NULL, status VARCHAR(255) NOT NULL, to_do_list_id INT NOT NULL, INDEX IDX_B3FB63A6B3AB48EB (to_do_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE to_do_list_item ADD CONSTRAINT FK_B3FB63A6B3AB48EB FOREIGN KEY (to_do_list_id) REFERENCES to_do_list (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE to_do_list_item DROP FOREIGN KEY FK_B3FB63A6B3AB48EB');
        $this->addSql('DROP TABLE to_do_list');
        $this->addSql('DROP TABLE to_do_list_item');
    }
}
