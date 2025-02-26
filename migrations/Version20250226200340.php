<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250226200340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, scope VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, creator_id INT NOT NULL, assigned_id INT DEFAULT NULL, finisher_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, limit_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_527EDB25166D1F9C (project_id), INDEX IDX_527EDB2561220EA6 (creator_id), INDEX IDX_527EDB25E1501A05 (assigned_id), INDEX IDX_527EDB2595D2E802 (finisher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2561220EA6 FOREIGN KEY (creator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25E1501A05 FOREIGN KEY (assigned_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2595D2E802 FOREIGN KEY (finisher_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2561220EA6');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25E1501A05');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2595D2E802');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE task');
    }
}
