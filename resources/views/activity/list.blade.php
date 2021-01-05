<table class="login-history row justify-content-center">
    @if(sizeof($activities) == 0)
        <tr>
            <div class="row justify-content-center">
                <span>You have no registered activity.</span>
            </div>
        </tr>
    @else
        <tr class="login-history-title">
            <td class="login-history-element">
                <p>Date and Hour of Activity</p>
            </td>
            <td class="login-history-element">
                <p>Function</p>
            </td>
            <td class="login-history-element">
                <p>User Login</p>
            </td>
        </tr>
        @foreach($activities as $activity)
            @if($activity->user_id == Auth::user()->id)
                <tr>
                    <td class="login-history-element">
                        {{ $activity->created_at }}
                    </td>
                    <td class="login-history-element">
                        {{ $activity->functions->description }}
                    </td>
                    <td class="login-history-element">
                        {{ $activity->user_id }}
                    </td>
                </tr>
            @endif
        @endforeach
    @endif
</table>
