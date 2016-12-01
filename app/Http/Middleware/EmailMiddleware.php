<?php

namespace App\Http\Middleware;

use Closure;
use Nette\Mail\Message;
Use Nette\Mail\SmtpMailer;

class EmailMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $rs = $next($request);
        if ($request->user()) {
           $mail = new Message;
           
            $mail->setFrom('zhenbei <zhenbeigg@163.com>')
                ->addTo($request->user()->email)
                ->setSubject('中间件')
                ->setBody("测试邮件发送");

            $mailer = new SmtpMailer([
            'host' => 'smtp.163.com',
            'username' => 'zhenbeigg@163.com',
            'password' => '928125nn',
            ]);

            $mailer->send($mail);
 
        }
        
        return $rs;
    }
}
