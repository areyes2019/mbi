<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class NoLoggin implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
    {
        
        if (session('is_logged')) {
            return redirect()->route('inicio');
        }
        /*if (!session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }*/
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No need to do anything here
    }
}