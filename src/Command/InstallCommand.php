<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * Install command.
 */
class InstallCommand extends Command
{
    private const PATH = '/var/www/html/helloworld';

    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/4/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|void|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('Starting installation...');

        // Create directory with write permissions
        if (self::PATH !== null && !\file_exists(\dirname(self::PATH))) {
            if (!@\mkdir(\dirname(self::PATH), 0755, true)) {
                $io->err('Can\'t create directory ' . \dirname(self::PATH));

                return Command::CODE_ERROR;
            }
        }

        debug(\dirname(self::PATH));

        $templateDockerCompose = ROOT . DS . 'docker' . DS . 'docker-compose.yml.template';

        // @todo Make app name dynamic
        $dockerCompose = str_replace(
            '{{ app-name }}',
            'helloword',
            file_get_contents($templateDockerCompose)
        );

        copy(
            ROOT . DS . 'docker' . DS . 'nginx' . DS . 'Dockerfile.template',
            self::PATH . DS . 'docker' . DS . 'nginx' . DS . 'Dockerfile'
        );

        debug($dockerCompose);

        // @todo Generate random password for database
        if (!file_put_contents(self::PATH . '/docker-compose.yml', $dockerCompose)) {
            $io->err('Failed to save Docker Compose file');

            return Command::CODE_ERROR;
        }

        $resultCode = 0;
        $output = '';
        $command = sprintf(
            'docker compose -f %s/docker-compose.yml up -d --remove-orphans --renew-anon-volumes',
            self::PATH
        );
        exec($command, $output, $resultCode);

        if ($resultCode !== 0) {
            $io->err(sprintf('Error output: %s', json_encode($output)));
            $io->err('Failed to install the app');

            return Command::CODE_ERROR;
        }

        $io->success('Application installed successfully');

        return Command::CODE_SUCCESS;
    }
}
