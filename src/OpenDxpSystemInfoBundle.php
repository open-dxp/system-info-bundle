<?php

/**
 * OpenDXP
 *
 * This source file is licensed under the GNU General Public License version 3 (GPLv3).
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (https://pimcore.com)
 * @copyright  Modification Copyright (c) OpenDXP (https://www.opendxp.ch)
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3 (GPLv3)
 */

namespace OpenDxp\Bundle\SystemInfoBundle;

use OpenDxp\Bundle\SystemInfoBundle\DependencyInjection\OpenDxpSystemInfoExtension;
use OpenDxp\Extension\Bundle\AbstractOpenDxpBundle;
use OpenDxp\Extension\Bundle\OpenDxpBundleAdminClassicInterface;
use OpenDxp\Extension\Bundle\Traits\BundleAdminClassicTrait;
use OpenDxp\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class OpenDxpSystemInfoBundle extends AbstractOpenDxpBundle implements OpenDxpBundleAdminClassicInterface
{
    use PackageVersionTrait;
    use BundleAdminClassicTrait;

    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new OpenDxpSystemInfoExtension();
        }

        return $this->extension;
    }

    public function getComposerPackageName(): string
    {
        return 'open-dxp/system-info-bundle';
    }

    public function getCssPaths(): array
    {
        return [
            '/bundles/opendxpsysteminfo/css/icons.css',
        ];
    }

    public function getJsPaths(): array
    {
        return [
            '/bundles/opendxpsysteminfo/js/startup.js',
        ];
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
