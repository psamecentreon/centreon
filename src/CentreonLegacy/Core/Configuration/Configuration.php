<?php
/**
 * Copyright 2005-2017 Centreon
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation ; either version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 *
 * Linking this program statically or dynamically with other modules is making a
 * combined work based on this program. Thus, the terms and conditions of the GNU
 * General Public License cover the whole combination.
 *
 * As a special exception, the copyright holders of this program give Centreon
 * permission to link this program with independent modules to produce an executable,
 * regardless of the license terms of these independent modules, and to copy and
 * distribute the resulting executable under terms of Centreon choice, provided that
 * Centreon also meet, for each linked independent module, the terms  and conditions
 * of the license of that module. An independent module is a module which is not
 * derived from this program. If you modify this program, you may extend this
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 *
 * For more information : contact@centreon.com
 *
 */

namespace CentreonLegacy\Core\Configuration;

use CentreonModule\Infrastructure\Source\ModuleSource;
use CentreonModule\Infrastructure\Source\WidgetSource;

/**
 * Service provide configuration data
 */
class Configuration
{
    const CENTREON_PATH = 'centreon_path';

    /**
     * @var array the global configuration
     */
    protected $configuration;

    /**
     * @var string the centreon path
     */
    protected $centreonPath;

    /**
     *
     * @param array $configuration the global configuration (mainly database)
     * @param string $centreonPath the centreon directory path
     */
    public function __construct(array $configuration, string $centreonPath)
    {
        $this->configuration = $configuration;
        $this->centreonPath = $centreonPath;
    }

    /**
     * Get configuration parameter by key
     *
     * @param string $key the key parameter to get
     * @return string the parameter value
     */
    public function get(string $key)
    {
        $value = null;

        // specific case for centreon path which is not stored in $conf_centreon
        if ($key === static::CENTREON_PATH) {
            $value = $this->centreonPath;
        } elseif (isset($this->configuration[$key])) {
            $value = $this->configuration[$key];
        }

        return $value;
    }

    public function getModulePath() : string
    {
        return $this->centreonPath . ModuleSource::PATH;
    }

    public function getWidgetPath() : string
    {
        return $this->centreonPath . WidgetSource::PATH;
    }
}
