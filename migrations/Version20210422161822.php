<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422161822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_4c62e6381be62e47');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E6381BE62E47 ON contact (id_mission_id)');
        $this->addSql('ALTER TABLE target ADD id_mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC1BE62E47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_466F2FFC1BE62E47 ON target (id_mission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFC1BE62E47');
        $this->addSql('DROP INDEX UNIQ_466F2FFC1BE62E47');
        $this->addSql('ALTER TABLE target DROP id_mission_id');
        $this->addSql('DROP INDEX UNIQ_4C62E6381BE62E47');
        $this->addSql('CREATE INDEX idx_4c62e6381be62e47 ON contact (id_mission_id)');
    }
}
