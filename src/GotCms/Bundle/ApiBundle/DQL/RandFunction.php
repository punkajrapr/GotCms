<?php
/**
 * Repositories
 *
 * PHP version >= 5.5
 *
 * @category   Game
 * @package    Game\RestBundle
 * @subpackage DQL
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       https://www.prettysimplegames.com/
 */
namespace Game\RestBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Rand function
 *
 * @package Game\RestBundle
 */
class RandFunction extends FunctionNode
{
    private $arg;

    /**
     * Get Sql
     *
     * @param SqlWalker $sqlWalker Sql walker
     *
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'RAND()';
    }

    /**
     * Parse string
     *
     * @param Parser $parser Parser
     *
     * @return null
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}