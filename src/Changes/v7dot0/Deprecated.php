<?php
namespace PhpMigration\Changes\v7dot0;

use PhpMigration\Changes\AbstractChange;
use PhpMigration\Utils\ParserHelper;
use PhpParser\Node\{Expr, Name, Scalar, Stmt};

class Deprecated extends AbstractChange
{
    protected static $version = '7.0.0';

    public function leaveNode($node)
    {
        /**
         * PHP 4 style constructors
         *
         * @see http://php.net/manual/en/migration70.deprecated.php#migration70.deprecated.php4-constructors
         */
        if ($node instanceof Stmt\ClassMethod && $this->visitor->inClass()) {
            if ($node->name == $this->visitor->getClassname()) {
                $this->addSpot('DEPRECATED', true, 'PHP 4 style constructor is deprecated');
            }

        /**
         * password_hash() salt option
         *
         * @see http://php.net/manual/en/migration70.deprecated.php#migration70.deprecated.pwshash-salt-option
         */
        } elseif ($node instanceof Expr\FuncCall && ParserHelper::isSameFunc($node->name, 'password_hash')) {
            $this->addSpot('DEPRECATED', false, 'salt option for password_hash() is deprecated');

        /**
         * LDAP deprecations
         *
         * @see http://php.net/manual/en/migration70.deprecated.php#migration70.deprecated.ldap
         */
        } elseif ($node instanceof Expr\FuncCall && ParserHelper::isSameFunc($node->name, 'ldap_sort')) {
            $this->addSpot('DEPRECATED', true, 'ldap_sort() is deprecated');
        }
    }
}
