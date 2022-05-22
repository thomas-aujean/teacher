<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522081515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop DROP FOREIGN KEY FK_9B6F02C4998666D1');
        $this->addSql('CREATE TABLE workshop_choice (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workshop_choice_workshop (workshop_choice_id INT NOT NULL, workshop_id INT NOT NULL, INDEX IDX_50308ED26FBCD140 (workshop_choice_id), INDEX IDX_50308ED21FDCE57C (workshop_id), PRIMARY KEY(workshop_choice_id, workshop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workshop_choice_workshop ADD CONSTRAINT FK_50308ED26FBCD140 FOREIGN KEY (workshop_choice_id) REFERENCES workshop_choice (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workshop_choice_workshop ADD CONSTRAINT FK_50308ED21FDCE57C FOREIGN KEY (workshop_id) REFERENCES workshop (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE choice');
        $this->addSql('DROP INDEX IDX_9B6F02C4998666D1 ON workshop');
        $this->addSql('ALTER TABLE workshop DROP choice_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workshop_choice_workshop DROP FOREIGN KEY FK_50308ED26FBCD140');
        $this->addSql('CREATE TABLE choice (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE workshop_choice');
        $this->addSql('DROP TABLE workshop_choice_workshop');
        $this->addSql('ALTER TABLE workshop ADD choice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workshop ADD CONSTRAINT FK_9B6F02C4998666D1 FOREIGN KEY (choice_id) REFERENCES choice (id)');
        $this->addSql('CREATE INDEX IDX_9B6F02C4998666D1 ON workshop (choice_id)');
    }
}
