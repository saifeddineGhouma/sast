اضغط هنا لإعادة تعيين كلمة المرور : <a href="{{ $link = url(App('urlLang').'password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
