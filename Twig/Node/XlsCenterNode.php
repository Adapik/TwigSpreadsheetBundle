<?php

namespace MewesK\TwigSpreadsheetBundle\Twig\Node;

use Twig_Compiler;
use Twig_Node;

/**
 * Class XlsCenterNode
 *
 * @package MewesK\TwigSpreadsheetBundle\Twig\Node
 */
class XlsCenterNode extends Twig_Node implements SyntaxAwareNodeInterface
{
    /**
     * @param Twig_Node $body
     * @param int $line
     * @param string $tag
     */
    public function __construct(Twig_Node $body, $line = 0, $tag = 'xlscenter')
    {
        parent::__construct(['body' => $body], [], $line, $tag);
    }

    /**
     * @param Twig_Compiler $compiler
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this)
            ->write('$context[\'phpSpreadsheetWrapper\']->startAlignment(\'center\');' . PHP_EOL)
            ->write("ob_start();\n")
            ->subcompile($this->getNode('body'))
            ->write('$centerValue = trim(ob_get_clean());' . PHP_EOL)
            ->write('$context[\'phpSpreadsheetWrapper\']->endAlignment($centerValue);' . PHP_EOL)
            ->write('unset($centerValue);' . PHP_EOL);
    }

    /**
     * @return string[]
     */
    public function getAllowedParents()
    {
        return [
            XlsFooterNode::class,
            XlsHeaderNode::class
        ];
    }

    /**
     * @return bool
     */
    public function canContainText()
    {
        return true;
    }
}
