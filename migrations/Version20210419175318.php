<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419175318 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP CONSTRAINT fk_466f2ffc79f37ae5');
        $this->addSql('DROP INDEX uniq_466f2ffc79f37ae5');
        $this->addSql('ALTER TABLE target ADD id_mission_id INT NOT NULL');
        $this->addSql('ALTER TABLE target RENAME COLUMN id_user_id TO id_guest_id');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCCA914ACD FOREIGN KEY (id_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC1BE62E47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_466F2FFCCA914ACD ON target (id_guest_id)');
        $this->addSql('CREATE INDEX IDX_466F2FFC1BE62E47 ON target (id_mission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFCCA914ACD');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFC1BE62E47');
        $this->addSql('DROP INDEX UNIQ_466F2FFCCA914ACD');
        $this->addSql('DROP INDEX IDX_466F2FFC1BE62E47');
        $this->addSql('ALTER TABLE target ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE target DROP id_guest_id');
        $this->addSql('ALTER TABLE target DROP id_mission_id');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT fk_466f2ffc79f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_466f2ffc79f37ae5 ON target (id_user_id)');
    }
}
