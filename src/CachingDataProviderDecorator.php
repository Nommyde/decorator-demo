<?php

namespace Nommyde;


use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class CachingDataProviderDecorator extends AbstractDataProviderDecorator
{
    protected $cache;
    protected $logger;

    public function __construct(DataProviderInterface $dataProvider, CacheItemPoolInterface $cache, LoggerInterface $logger = null)
    {
        parent::__construct($dataProvider);
        $this->cache = $cache;
        $this->logger = $logger === null ? new NullLogger() : $logger;
    }

    /**
     * @inheritdoc
     */
    public function getData(array $params)
    {
        try {
            $cacheKey = $this->buildKey($params);
            $cacheItem = $this->cache->getItem($cacheKey);

            if ($cacheItem->isHit()) {
                $this->logger->debug('hit');
                return $cacheItem->get();
            }

            $result = $this->dataProvider->getData($params);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );

            $this->cache->save($cacheItem);

            $this->logger->debug('cache set');

            return $result;
        } catch (Exception $e) {
            $this->logger->error('CachingDataProvider exception: ' . $e->getMessage());
            throw new DataProviderException('DataProvider error', 0, $e);
        }
    }

    protected function buildKey(array $params)
    {
        return md5(json_encode($params));
    }
}
