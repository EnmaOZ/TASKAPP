<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verifica si el usuario está autenticado
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'You must be logged in to access this page.');
        }

        // Si el rol es requerido, verifica
        if ($arguments && in_array('admin', $arguments)) {
            if (session()->get('role') !== 'admin') {
                return redirect()->to('/')->with('error', 'You do not have permission to access this page.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita acción después del middleware
    }
}
