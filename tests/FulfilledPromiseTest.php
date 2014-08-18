<?php

namespace React\Promise;

use React\Promise\PromiseAdapter\CallbackPromiseAdapter;

class FulfilledPromiseTest extends TestCase
{
    use PromiseTest\PromiseSettledTestTrait,
        PromiseTest\PromiseFulfilledTestTrait;

    public function getPromiseTestAdapter()
    {
        $promise = null;

        return new CallbackPromiseAdapter([
            'promise' => function () use (&$promise) {
                if (!$promise) {
                    throw new \LogicException('FulfilledPromise must be resolved before obtaining the promise');
                }

                return $promise;
            },
            'resolve' => function ($value = null) use (&$promise) {
                if (!$promise) {
                    $promise = new FulfilledPromise($value);
                }
            },
            'reject' => function () {
                throw new \LogicException('You cannot call reject() for React\Promise\FulfilledPromise');
            },
            'progress' => function () {
                throw new \LogicException('You cannot call progress() for React\Promise\FulfilledPromise');
            },
            'settle' => function ($value = null) use (&$promise) {
                if (!$promise) {
                    $promise = new FulfilledPromise($value);
                }
            },
        ]);
    }

    /** @test */
    public function shouldThrowExceptionIfConstructedWithAPromise()
    {
        $this->setExpectedException('\InvalidArgumentException');

        return new FulfilledPromise(new FulfilledPromise());
    }
}
