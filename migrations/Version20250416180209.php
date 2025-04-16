<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416180209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user_wordle_answer (id INT AUTO_INCREMENT NOT NULL, attempts INT NOT NULL, success TINYINT(1) NOT NULL, guesses JSON NOT NULL, user_id INT NOT NULL, wordle_answer_id INT NOT NULL, INDEX IDX_9E2783F8A76ED395 (user_id), INDEX IDX_9E2783F81527DBF8 (wordle_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE wordle_answer (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, wordle_id INT NOT NULL, INDEX IDX_70A92EA85AA805B4 (wordle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user_wordle_answer ADD CONSTRAINT FK_9E2783F8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_wordle_answer ADD CONSTRAINT FK_9E2783F81527DBF8 FOREIGN KEY (wordle_answer_id) REFERENCES wordle_answer (id)');
        $this->addSql('ALTER TABLE wordle_answer ADD CONSTRAINT FK_70A92EA85AA805B4 FOREIGN KEY (wordle_id) REFERENCES wordle (id)');
        $this->addSql('ALTER TABLE wordle ADD last_used_at DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_wordle_answer DROP FOREIGN KEY FK_9E2783F8A76ED395');
        $this->addSql('ALTER TABLE user_wordle_answer DROP FOREIGN KEY FK_9E2783F81527DBF8');
        $this->addSql('ALTER TABLE wordle_answer DROP FOREIGN KEY FK_70A92EA85AA805B4');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_wordle_answer');
        $this->addSql('DROP TABLE wordle_answer');
        $this->addSql('ALTER TABLE wordle DROP last_used_at');
    }
}
