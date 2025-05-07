<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430211352 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE faction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, logo CLOB DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, _scenario_id INTEGER DEFAULT NULL, CONSTRAINT FK_232B318CBEF3FB21 FOREIGN KEY (_scenario_id) REFERENCES scenario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_232B318CBEF3FB21 ON game (_scenario_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game_report (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, _game_result_id INTEGER NOT NULL, _author_id INTEGER DEFAULT NULL, phase VARCHAR(255) NOT NULL, content CLOB NOT NULL, CONSTRAINT FK_B91ADA4C9782ACE FOREIGN KEY (_game_result_id) REFERENCES game_result (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B91ADA4CBBE95206 FOREIGN KEY (_author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B91ADA4C9782ACE ON game_report (_game_result_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B91ADA4CBBE95206 ON game_report (_author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE game_result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, registered_by_id INTEGER NOT NULL, validated_by_id INTEGER DEFAULT NULL, _game_id INTEGER NOT NULL, date DATE NOT NULL, status VARCHAR(255) NOT NULL, CONSTRAINT FK_6E5F6CDB27E92E18 FOREIGN KEY (registered_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6E5F6CDBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6E5F6CDB90C73878 FOREIGN KEY (_game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6E5F6CDB27E92E18 ON game_result (registered_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6E5F6CDBC69DE5E5 ON game_result (validated_by_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6E5F6CDB90C73878 ON game_result (_game_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE player_game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, _player_id INTEGER NOT NULL, _game_id INTEGER NOT NULL, _faction_id INTEGER NOT NULL, CONSTRAINT FK_813161BFD47A54C2 FOREIGN KEY (_player_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_813161BF90C73878 FOREIGN KEY (_game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_813161BF270308A2 FOREIGN KEY (_faction_id) REFERENCES faction (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_813161BFD47A54C2 ON player_game (_player_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_813161BF90C73878 ON player_game (_game_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_813161BF270308A2 ON player_game (_faction_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE player_game_result (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, _game_result_id INTEGER NOT NULL, _player_game_id INTEGER NOT NULL, tournament_points INTEGER NOT NULL, objective_points INTEGER NOT NULL, survivor_points INTEGER NOT NULL, CONSTRAINT FK_3668854E9782ACE FOREIGN KEY (_game_result_id) REFERENCES game_result (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3668854E59027BCF FOREIGN KEY (_player_game_id) REFERENCES player_game (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3668854E9782ACE ON player_game_result (_game_result_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3668854E59027BCF ON player_game_result (_player_game_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scenario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, _pack_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, document CLOB DEFAULT NULL, CONSTRAINT FK_3E45C8D86D51536A FOREIGN KEY (_pack_id) REFERENCES scenario_pack (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3E45C8D86D51536A ON scenario (_pack_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE scenario_pack (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, document CLOB DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , discord_id VARCHAR(255) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, displayname VARCHAR(255) DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE faction
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game_report
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE game_result
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE player_game
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE player_game_result
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scenario
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE scenario_pack
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
