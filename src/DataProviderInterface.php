<?php

namespace Nommyde;


interface DataProviderInterface
{
    /**
     * @param array $params   application domain parameters (independent from third-party components)
     * @return mixed
     *
     * @throws DataProviderException
     */
    public function getData(array $params);
}
