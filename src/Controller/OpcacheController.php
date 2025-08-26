<?php
declare(strict_types=1);

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

namespace OpenDxp\Bundle\SystemInfoBundle\Controller;

use OpenDxp\Controller\KernelControllerEventInterface;
use OpenDxp\Controller\UserAwareController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @internal
 */
#[Route("/opcache")]
class OpcacheController extends UserAwareController implements KernelControllerEventInterface
{
    #[Route('/index', name: 'opendxp_bundle_systeminfo_opcache_index')]
    public function indexAction(Request $request, ?Profiler $profiler): Response
    {
        if ($profiler) {
            $profiler->disable();
        }

        $path = OPENDXP_COMPOSER_PATH . '/amnuts/opcache-gui';

        ob_start();
        include($path . '/index.php');
        $content = ob_get_clean();

        return new Response($content);
    }

    public function onKernelControllerEvent(ControllerEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        // only for admins
        $this->checkPermission('opcache');
    }
}
