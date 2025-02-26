<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226202920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, emisor_id INT NOT NULL, receptor_id INT NOT NULL, project_id INT NOT NULL, state VARCHAR(255) DEFAULT NULL, INDEX IDX_F11D61A26BDF87DF (emisor_id), INDEX IDX_F11D61A2386D8D01 (receptor_id), INDEX IDX_F11D61A2166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A26BDF87DF FOREIGN KEY (emisor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2386D8D01 FOREIGN KEY (receptor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A2166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A26BDF87DF');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2386D8D01');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A2166D1F9C');
        $this->addSql('DROP TABLE invitation');
    }
}
