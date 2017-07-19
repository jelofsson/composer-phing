<?php
namespace ComposerPhing;

require __DIR__ . '/../../vendor/autoload.php';

use Composer\Script\Event;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use \Bramus\Monolog\Formatter\ColoredLineFormatter;

class Packages
{

    public static function build(Event $event)
    {
        $isDev = $event->isDevMode();
        $composer = $event->getComposer();

        $args = $event->getArguments();

        $log = new Logger(__NAMESPACE__);
        $handler = new StreamHandler('php://stderr', Logger::INFO);
        $handler->setFormatter(new ColoredLineFormatter(null, "[%level_name%] %message%", null, true));
        $log->pushHandler($handler);

        $repositoryManager = $composer->getRepositoryManager();
        $installationManager = $composer->getInstallationManager();
        $localRepository = $repositoryManager->getLocalRepository();

        $packages = $localRepository->getPackages();
        $log->info("Found (" . count($packages) . ") packages");

        $task = '';
        if (isset($args[0])) {
          $task = $args[0];
        }

        foreach ($packages as $package) {
            $installPath = $installationManager->getInstallPath($package);
            $command = "phing -buildfile {$installPath}/build.xml {$task}";
            if (is_file("{$installPath}/build.xml")) {
                $log->info("Package; {$package} \n\t Executing;\t{$command}");
                shell_exec($command);
            } else {
                $log->notice("Package; {$package} has no build.xml");
            }
        }
    }
}
