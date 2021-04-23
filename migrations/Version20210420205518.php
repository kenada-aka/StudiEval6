<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420205518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT fk_268b9c9d1be62e47');
        $this->addSql('DROP INDEX idx_268b9c9d1be62e47');
        $this->addSql('ALTER TABLE agent DROP id_mission_id');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT fk_466f2ffc1be62e47');
        $this->addSql('DROP INDEX idx_466f2ffc1be62e47');
        $this->addSql('ALTER TABLE target DROP id_mission_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE target ADD id_mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT fk_466f2ffc1be62e47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_466f2ffc1be62e47 ON target (id_mission_id)');
        $this->addSql('ALTER TABLE agent ADD id_mission_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT fk_268b9c9d1be62e47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_268b9c9d1be62e47 ON agent (id_mission_id)');
    }
}
