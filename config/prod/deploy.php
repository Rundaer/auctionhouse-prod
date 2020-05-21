<?php

use EasyCorp\Bundle\EasyDeployBundle\Deployer\DefaultDeployer;

return new class extends DefaultDeployer
{
    public function configure()
    {
        return $this->getConfigBuilder()
            // SSH connection string to connect to the remote server (format: user@host-or-IP:port-number)
            ->server('serwer54796@serwer54796.lh.pl:40022')
            // the absolute path of the remote server directory where the project is deployed
            ->deployDir('/home/platne/serwer54796/public_html/projekty/auctionhouse')
            // the URL of the Git repository where the project code is hosted
            ->repositoryUrl('git@github.com:rundaer/auctionhouse-prod.git')
            ->repositoryBranch('master')
            ->symfonyEnvironment('prod')
            ->remoteComposerBinaryPath('composer')
            ->composerInstallFlags('--no-dev')
            ->resetOpCacheFor('http://projekty.marcinbabiarz.pl/auctionhouse/');
    }

    // run some local or remote commands before the deployment is started
    public function beforeStartingDeploy()
    {
        
    }

    public function beforePreparing()
    {
        $this->log('<h3>Copying over the .env files</>');
        $this->runRemote('cp {{ deploy_dir }}/repo/.env {{ project_dir }}');
    }

    // run some local or remote commands after the deployment is finished
    public function beforeFinishingDeploy()
    {
        $this->runRemote(sprintf('cp -RPp {{ deploy_dir }}/repo/. {{ project_dir }}'));
    }
};

