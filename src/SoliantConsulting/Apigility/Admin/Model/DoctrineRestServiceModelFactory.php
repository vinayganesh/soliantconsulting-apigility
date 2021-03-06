<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2013 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace SoliantConsulting\Apigility\Admin\Model;

use ZF\Apigility\Admin\Exception;
use ZF\Apigility\Admin\Model\RpcServiceModelFactory;

class DoctrineRestServiceModelFactory extends RpcServiceModelFactory
{
    const TYPE_DEFAULT      = 'SoliantConsulting\Apigility\Admin\Model\DoctrineRestServiceModel';

    /**
     * @param  string $module
     * @return RestServiceModel
     */
    public function factory($module, $type = self::TYPE_DEFAULT)
    {
        if (isset($this->models[$type])
            && isset($this->models[$type][$module])
        ) {
            return $this->models[$type][$module];
        }

        $moduleName   = $this->normalizeModuleName($module);
        $config       = $this->configFactory->factory($module);
        $moduleEntity = $this->moduleModel->getModule($moduleName);

        $restModel = new DoctrineRestServiceModel($moduleEntity, $this->modules, $config);
        $restModel->getEventManager()->setSharedManager($this->sharedEventManager);

        switch ($type) {
            case self::TYPE_DEFAULT:
                $this->models[$type][$module] = $restModel;
                return $restModel;
            default:
                throw new Exception\InvalidArgumentException(sprintf(
                    'Model of type "%s" does not exist or cannot be handled by this factory',
                    $type
                ));
        }
    }
}
