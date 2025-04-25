<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class InactivityFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $timeout = 3600; // 1 hour = 3600 seconds
        // $timeout = 180; // 3 minutes (60 * 3)


        if ($session->get('logged_in')) {
            $lastActivity = $session->get('last_activity');

            if ($lastActivity !== null && (time() - $lastActivity) > $timeout) {
                $session->destroy();
                return redirect()->to('/login')->with('error', 'Session expired due to inactivity.');
            } else {
                $session->set('last_activity', time());
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Not needed
    }
}
