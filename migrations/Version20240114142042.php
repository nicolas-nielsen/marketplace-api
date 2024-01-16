<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240114142042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds category table and link it with product';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, parent_category_id UUID DEFAULT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, level INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64C19C1796A8F92 ON category (parent_category_id)');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN category.parent_category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD category_id UUID DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN product.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1796A8F92');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP category_id');
    }
}
