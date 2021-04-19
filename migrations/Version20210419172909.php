<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419172909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT fk_4c62e63879f37ae5');
        $this->addSql('DROP INDEX uniq_4c62e63879f37ae5');
        $this->addSql('ALTER TABLE contact RENAME COLUMN id_user_id TO id_guest_id');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638CA914ACD FOREIGN KEY (id_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638CA914ACD ON contact (id_guest_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638CA914ACD');
        $this->addSql('DROP INDEX UNIQ_4C62E638CA914ACD');
        $this->addSql('ALTER TABLE contact RENAME COLUMN id_guest_id TO id_user_id');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT fk_4c62e63879f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_4c62e63879f37ae5 ON contact (id_user_id)');
    }
}
