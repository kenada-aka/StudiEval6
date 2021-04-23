<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422180038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT fk_f3d7a08e17c042cf');
        $this->addSql('DROP INDEX idx_f3d7a08e17c042cf');
        $this->addSql('ALTER TABLE speciality RENAME COLUMN missions_id TO id_mission_id');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E1BE62E47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3D7A08E1BE62E47 ON speciality (id_mission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT FK_F3D7A08E1BE62E47');
        $this->addSql('DROP INDEX UNIQ_F3D7A08E1BE62E47');
        $this->addSql('ALTER TABLE speciality RENAME COLUMN id_mission_id TO missions_id');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT fk_f3d7a08e17c042cf FOREIGN KEY (missions_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f3d7a08e17c042cf ON speciality (missions_id)');
    }
}
