<?php


use Yosymfony\Spress\Core\Plugin\PluginInterface;
use Yosymfony\Spress\Core\Plugin\EventSubscriber;
use Yosymfony\Spress\Core\Plugin\Event\EnvironmentEvent;
use Yosymfony\Spress\Core\Plugin\Event\ContentEvent;
use Yosymfony\Spress\Core\Plugin\Event\FinishEvent;
use Yosymfony\Spress\Core\Plugin\Event\RenderEvent;

class ChristianpAuthors implements PluginInterface
{
    private $io;
    private $author_data;

    public function initialize(EventSubscriber $subscriber)
    {
        $subscriber->addEventListener('spress.start', 'onStart');
        $subscriber->addEventListener('spress.before_convert', 'onBeforeConvert');
        $subscriber->addEventListener('spress.after_convert', 'onAfterConvert');
        $subscriber->addEventListener('spress.before_render_blocks', 'onBeforeRenderBlocks');
        $subscriber->addEventListener('spress.after_render_blocks', 'onAfterRenderBlocks');
        $subscriber->addEventListener('spress.before_render_page', 'onBeforeRenderPage');
        $subscriber->addEventListener('spress.after_render_page', 'onAfterRenderPage');
        $subscriber->addEventListener('spress.finish', 'onFinish');
    }

    public function getMetas()
    {
        return [
            'name' => 'christianp/authors',
            'description' => 'Data about authors',
            'author' => 'Christian Lawson-Perfect',
            'license' => 'Apache-2.0',
        ];
    }
    
    public function onStart(EnvironmentEvent $event)
    {
        $this->io = $event->getIO();
        $this->event = $event;

        $renderizer = $event->getRenderizer();
        $renderizer->addTwigFilter('get_author', function($username){
            $conf = $this->event->getConfigValues();
            return $conf['data']['authors'][$username];
        });
    }

    public function onBeforeConvert(ContentEvent $event)
    {

    }

    public function onAfterConvert(ContentEvent $event)
    {

    }

    public function onBeforeRenderBlocks(RenderEvent $event)
    {

    }

    public function onAfterRenderBlocks(RenderEvent $event)
    {

    }

    public function onBeforeRenderPage(RenderEvent $event)
    {

    }

    public function onAfterRenderPage(RenderEvent $event)
    {

    }

    public function onFinish(FinishEvent $event)
    {

    }
}
