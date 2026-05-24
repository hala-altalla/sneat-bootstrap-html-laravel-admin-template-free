<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {




      // 1️⃣ جلب اللغة من session، وإذا مش موجود نستخدم الافتراضية 'en'
      $locale = session('locale', 'en');

      // 2️⃣ نتأكد إن اللغة صالحة (en أو ar)
      if (!in_array($locale, ['en', 'ar'])) {
          $locale = 'en';
      }

      // 3️⃣ نطبق اللغة على التطبيق
      app()->setLocale($locale);

      if($locale==='ar')
      {
        session(['dir'=>'rtl']);

      }
      else{
        session(['dir'=>'ltr']);


      }

      // 4️⃣ الاستمرار في تنفيذ الطلب

      return $next($request);
  }
}