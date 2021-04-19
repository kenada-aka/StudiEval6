<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419222352 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE agent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE target_id_seq CASCADE');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT fk_268b9c9d79f37ae5');
        $this->addSql('DROP INDEX uniq_268b9c9d79f37ae5');
        $this->addSql('ALTER TABLE agent DROP id_user_id');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DBF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT fk_4c62e638ca914acd');
        $this->addSql('DROP INDEX uniq_4c62e638ca914acd');
        $this->addSql('ALTER TABLE contact DROP id_guest_id');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638BF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT fk_466f2ffcca914acd');
        $this->addSql('DROP INDEX uniq_466f2ffcca914acd');
        $this->addSql('ALTER TABLE target DROP id_guest_id');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCBF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE agent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE target_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9DBF396750');
        $this->addSql('ALTER TABLE agent ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT fk_268b9c9d79f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_268b9c9d79f37ae5 ON agent (id_user_id)');
        $this->addSql('ALTER TABLE contact DROP CONSTRAINT FK_4C62E638BF396750');
        $this->addSql('ALTER TABLE contact ADD id_guest_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT fk_4c62e638ca914acd FOREIGN KEY (id_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_4c62e638ca914acd ON contact (id_guest_id)');
        $this->addSql('ALTER TABLE target DROP CONSTRAINT FK_466F2FFCBF396750');
        $this->addSql('ALTER TABLE target ADD id_guest_id INT NOT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT fk_466f2ffcca914acd FOREIGN KEY (id_guest_id) REFERENCES guest (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_466f2ffcca914acd ON target (id_guest_id)');
    }
}
