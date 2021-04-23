<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422184227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT fk_f3d7a08e1be62e47');
        $this->addSql('DROP INDEX uniq_f3d7a08e1be62e47');
        $this->addSql('ALTER TABLE speciality RENAME COLUMN id_mission_id TO missions_id');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E17C042CF FOREIGN KEY (missions_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F3D7A08E17C042CF ON speciality (missions_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT FK_F3D7A08E17C042CF');
        $this->addSql('DROP INDEX IDX_F3D7A08E17C042CF');
        $this->addSql('ALTER TABLE speciality RENAME COLUMN missions_id TO id_mission_id');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT fk_f3d7a08e1be62e47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_f3d7a08e1be62e47 ON speciality (id_mission_id)');
    }
}
