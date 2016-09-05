<?php

namespace Rts;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RssToSlackCommand extends Command
{
    private $config;

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    protected function configure()
    {
        $this->setName('rss:process')
            ->setDescription('Runs RSS reader');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = new GuidDb($this->config['csvPath']);
        $db->load();
        $rssReader = new RssReader();
        $feed = $rssReader->readFeed($this->config['feed']);

        $newItems = [];
        foreach ($feed as $guid => $item) {
            if (!$db->has($guid)) {
                $db->add($guid);
                $newItems[] = $item;
            }
        }

        if (!empty($newItems)) {
            $view = new View();
            $template = $view->render('templates/default.php', ['items' => $newItems]);

            $pusher = new WebPusher($this->config['webhook']['url'], $this->config['webhook']['params']);
            $pusher->push(['text' => $template]);
        }

        $db->save();
    }
}