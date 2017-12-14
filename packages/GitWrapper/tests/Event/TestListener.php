<?php declare(strict_types=1);

namespace Symplify\GitWrapper\Tests\Event;

use Symplify\GitWrapper\Event\GitEvent;

final class TestListener
{
    /**
     * The methods that were called.
     *
     * @var array
     */
    private $methods = [];

    /**
     * The event object passed to the onPrepare method.
     *
     * @var \Symplify\GitWrapper\Event\GitEvent
     */
    private $gitEvent;

    public function methodCalled($method)
    {
        return in_array($method, $this->methods);
    }

    public function getEvent(): GitEvent
    {
        return $this->gitEvent;
    }

    public function onPrepare(GitEvent $gitEvent): void
    {
        $this->methods[] = 'onPrepare';
        $this->gitEvent = $gitEvent;
    }

    public function onSuccess(GitEvent $gitEvent): void
    {
        $this->methods[] = 'onSuccess';
    }

    public function onError(GitEvent $gitEvent): void
    {
        $this->methods[] = 'onError';
    }
}
