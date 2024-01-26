<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240113230842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds products table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN product.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE products');
    }
}
