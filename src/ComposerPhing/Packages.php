<?php
namespace ComposerPhing;

use Composer\Script\Event;

class Packages
{

    public static function build(Event $event)
    {
        $isDev = $event->isDevMode();
        $composer = $event->getComposer();

        $args = $event->getArguments();

        $repositoryManager = $composer->getRepositoryManager();
        $installationManager = $composer->getInstallationManager();
        $localRepository = $repositoryManager->getLocalRepository();

        $packages = $localRepository->getPackages();

        $task = '';
        if (isset($args[0])) {
          $task = $args[0];
        }

        foreach ($packages as $package) {
            $installPath = $installationManager->getInstallPath($package);
            if (is_file("{$installPath}/build.xml")) {
                var_dump("Executing; ant -buildfile {$installPath}/build.xml {$task}");
                shell_exec("ant -buildfile {$installPath}/build.xml {$task}");
            }
        }
    }
}
