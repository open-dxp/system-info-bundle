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
 * @copyright  Modification Copyright (c) OpenDXP (https://www.opendxp.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3 (GPLv3)
 */

namespace OpenDxp\Bundle\SystemInfoBundle\Controller;

use Exception;
use OpenDxp\Controller\UserAwareController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @internal
 */
#[Route('/settings')]
class SettingsController extends UserAwareController
{
    /**
     * @throws Exception
     */
    #[Route('/phpinfo', name: 'opendxp_bundle_systeminfo_settings_phpinfo', methods: ['GET'])]
    public function phpinfoAction(Request $request, ?Profiler $profiler): Response
    {
        if ($profiler) {
            $profiler->disable();
        }

        if (!$this->getOpenDxpUser()->isAdmin()) {
            throw new Exception('Permission denied');
        }

        ob_start();
        phpinfo();
        $content = ob_get_clean();

        return new Response($content);
    }
}
