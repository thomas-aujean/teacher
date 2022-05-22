<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522085539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D61FDCE57C');
        $this->addSql('DROP INDEX IDX_5E90F6D61FDCE57C ON inscription');
        $this->addSql('ALTER TABLE inscription CHANGE workshop_id workshop_choice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D66FBCD140 FOREIGN KEY (workshop_choice_id) REFERENCES workshop_choice (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D66FBCD140 ON inscription (workshop_choice_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D66FBCD140');
        $this->addSql('DROP INDEX IDX_5E90F6D66FBCD140 ON inscription');
        $this->addSql('ALTER TABLE inscription CHANGE workshop_choice_id workshop_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D61FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D61FDCE57C ON inscription (workshop_id)');
    }
}
