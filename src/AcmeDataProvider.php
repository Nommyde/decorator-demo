<?php

namespace Nommyde;

/**
 * Concrete data provider
 */
class AcmeDataProvider implements DataProviderInterface
{
    private $host;
    private $user;
    private $password;

    /**
     * AcmeDataProvider constructor with third-party arguments.
     * @param $host
     * @param $user
     * @param $password
     */
    public function __construct($host, $user, $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @inheritdoc
     */
    public function getData(array $params)
    {
        /*
         * adapt params to concrete implementation and get data from third party
         */
        return ['some' => 'data'];
    }
}
