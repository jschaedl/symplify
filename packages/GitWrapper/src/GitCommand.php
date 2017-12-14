<?php declare(strict_types=1);

namespace Symplify\GitWrapper;

final class GitCommand
{
    /**
     * Path to the directory containing the working copy. If this variable is
     * set, then the process will change into this directory while the Git
     * command is being run.
     *
     * @var string|null
     */
    private $directory;

    /**
     * The command being run, e.g. "clone", "commit", etc.
     *
     * @var string
     */
    private $command;

    /**
     * An associative array of command line options and flags.
     *
     * @var mixed[]
     */
    private $options = [];

    /**
     * Command line arguments passed to the Git command.
     *
     * @var mixed[]
     */
    private $args = [];

    /**
     * @param mixed[]|mixed[][] @$argAndOptions
     */
    public function __construct(string $command = '', ...$argAndOptions)
    {
        $this->command = $command;

        foreach ($argAndOptions as $argOrOption) {
            if (is_array($argOrOption)) {
                // If item is array, set it as the options
                $this->setOptions($argOrOption);
            } else {
                // Pass all other as the Git command arguments
                $this->addArgument($argOrOption);
            }
        }
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function setDirectory(string $directory): void
    {
        $this->directory = $directory;
    }

    public function getDirectory(): ?string
    {
        return $this->directory;
    }

    /**
     * Builds the command line options for use in the Git command.
     */
    public function buildOptions(): string
    {
        $options = [];
        foreach ($this->options as $option => $values) {
            foreach ((array) $values as $value) {
                $prefix = (strlen($option) !== 1) ? '--' : '-';
                $rendered = $prefix . $option;
                if ($value !== true) {
                    $rendered .= ($prefix === '--') ? '=' : ' ';
                    $rendered .= $value;
                }

                $options[] = $rendered;
            }
        }

        return implode(' ', $options);
    }

    /**
     * Option names are passed as-is to the command line, whereas the values are escaped.
     *
     * @param string|true $value The option's value, pass true if the options is a flag.
     */
    public function setOption(string $option, $value): void
    {
        $this->options[$option] = $value;
    }

    public function setOptions(array $options): void
    {
        foreach ($options as $option => $value) {
            $this->setOption($option, $value);
        }
    }

    public function setFlag($option): void
    {
        $this->setOption($option, true);
    }

    /**
     * @param mixed $default Value that is returned if the option is not set.
     *
     * @return mixed
     */
    public function getOption(string $option, $default = null)
    {
        return $this->options[$option] ?? $default;
    }

    public function unsetOption(string $option): void
    {
        unset($this->options[$option]);
    }

    public function addArgument(string $arg): void
    {
        $this->args[] = $arg;
    }

    /**
     * Renders the arguments and options for the Git command.
     */
    public function getCommandLine(): string
    {
        $command = [
            $this->getCommand(),
            $this->buildOptions(),
            implode(' ', $this->args),
        ];
        return implode(' ', array_filter($command));
    }
}
