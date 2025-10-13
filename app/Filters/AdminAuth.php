<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session()->get('user');
        if(!$session)
        {
            return redirect()->route('auth.login');
        }
        else
        {
            $user = get_user();
            if(empty($user))
            {
                session()->remove('user');
                return redirect()->route('auth.login');
            }
            else if($user->status==0)
            {
                session()->remove('user');
                return redirect()->route('auth.login');
            }
            else if($user->role!=1 && $user->role!=6)
            {
                return redirect()->route('auth.login');
            }
            else if($user->password!=$session['password'])
            {
                return redirect()->route('auth.login');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Baad me koi processing nahi
    }
}

