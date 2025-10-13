<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;

class UserAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Agar user login nahi hai to login page pe bhejo
        $session = session()->get('user');
        if(!$session)
        {
            return redirect()->to(base_url('login'));
        }
        else
        {
            $user = get_user();
            if(empty($user))
            {
                session()->remove('user');
                return redirect()->to(base_url('login'));
            }
            else if($user->status==0)
            {
                session()->remove('user');
                return redirect()->to(base_url('login'));
            }
            else if($user->role!=2)
            {
                return redirect()->to(base_url('login'));
            }
            else if($user->password!=$session['password'])
            {
                return redirect()->to(base_url('login'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Baad me koi processing nahi
    }
}

