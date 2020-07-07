<li>
    <i class="livicon danger" data-name="bell" data-s="20" data-c="white" data-hc="white"></i>
    <a href="{{ url('/admin/reviews') }}">
       new review for {{ $notification->data['userreview']['courseName'] }} by {{ $notification->data['userreview']['username'] }}
    </a>

    <small class="pull-right">
        <span class="livicon paddingright_10" data-n="timer" data-s="10"></span>
        {{ \App\Setting::humanTiming(strtotime($notification->created_at)) }}
    </small>
</li>
