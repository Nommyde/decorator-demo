<?php

namespace Nommyde;


abstract class AbstractDataProviderDecorator implements DataProviderInterface
{
    protected $dataProvider;

    public function __construct(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    /**
     * @inheritdoc
     */
    abstract public function getData(array $params);
}
