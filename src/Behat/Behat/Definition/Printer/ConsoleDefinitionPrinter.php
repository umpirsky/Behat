<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Behat\Definition\Printer;

use Behat\Behat\Definition\Definition;
use Behat\Behat\Definition\Pattern\PatternTransformer;
use Behat\Testwork\Suite\Suite;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Behat console-based definition printer.
 *
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 */
abstract class ConsoleDefinitionPrinter implements DefinitionPrinter
{
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var PatternTransformer
     */
    private $patternTransformer;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Initializes printer.
     *
     * @param OutputInterface     $output
     * @param PatternTransformer  $patternTransformer
     * @param TranslatorInterface $translator
     */
    public function __construct(
        OutputInterface $output,
        PatternTransformer $patternTransformer,
        TranslatorInterface $translator
    ) {
        $this->output = $output;
        $this->patternTransformer = $patternTransformer;
        $this->translator = $translator;

        $output->getFormatter()->setStyle('def_regex', new OutputFormatterStyle('yellow'));
        $output->getFormatter()->setStyle('def_regex_capture', new OutputFormatterStyle('yellow', null, array('bold')));
        $output->getFormatter()->setStyle('def_dimmed', new OutputFormatterStyle('black', null, array('bold')));
    }

    /**
     * Writes text to the console.
     *
     * @param string $text
     */
    protected function write($text)
    {
        $this->output->writeln($text);
        $this->output->writeln('');
    }

    /**
     * Returns definition regex translated into provided language.
     *
     * @param Suite      $suite
     * @param Definition $definition
     *
     * @return string
     */
    protected function getDefinitionPattern(Suite $suite, Definition $definition)
    {
        return $this->translator->trans($definition->getPattern(), array(), $suite->getName());
    }
}
