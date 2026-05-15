{{-- -------------------- Saved Messages -------------------- --}}
@if ($get == 'saved')
    {{-- <table class="messenger-list-item" data-contact="{{ Auth::user()->id }}"> --}}
    <table class="messenger-list-item" data-contact="{{ Auth::id() ?? 0 }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="saved-messages avatar av-m">
                    <span class="far fa-bookmark"></span>
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ Auth::id() ?? 0 }}" data-type="user">Saved Messages <span>You</span></p>
                <span>Save messages secretly</span>
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Contact list -------------------- --}}
@if ($get == 'users')
    <?php
    $hasLast = !!$lastMessage;
    $lastMessageBody = $hasLast ? mb_convert_encoding($lastMessage->body, 'UTF-8', 'UTF-8') : null;
    $lastMessageBody = $hasLast && strlen($lastMessageBody) > 30 ? mb_substr($lastMessageBody, 0, 30, 'UTF-8') . '..' : $lastMessageBody;
    $displayTime = $hasLast ? $lastMessage->timeAgo : '';
    ?>
    {{-- <table class="messenger-list-item" data-contact="{{ $user->id }}"> --}}
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td style="position: relative">
                @if ($user->active_status)
                    <span class="activeStatus"></span>
                @endif
                <div class="avatar av-m"
                    style="background-image: url('{{ $user->photo ? asset('/upload/user_images/' . $user->photo) : asset('/storage/users-avatar/avatar.png') }}');">
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $user->id }}" data-type="user">
                    <?php
                    $roleName = '';
                    try {
                        $roleName = $user->getRoleNames()->first() ?? '';
                    } catch (\Throwable $e) {
                        $roleName = '';
                    }
                    $shortName = strlen($user->name) > 12 ? trim(substr($user->name, 0, 12)) . '..' : $user->name;
                    $displayLabel = $roleName ? $shortName . ' (' . $roleName . ')' : $shortName;
                    ?>
                    {{ $displayLabel }}
                    <span class="contact-item-time"
                        data-time="{{ $hasLast ? $lastMessage->created_at : '' }}">{{ $displayTime }}</span>
                </p>
                <span>
                    @if ($hasLast)
                        {!! $lastMessage->from_id == (Auth::id() ?? 0) ? '<span class="lastMessageIndicator">You :</span>' : '' !!}
                        @if ($lastMessage->attachment == null)
                            {!! $lastMessageBody !!}
                        @else
                            <span class="fas fa-file"></span> Attachment
                        @endif
                    @else
                        <span class="message-hint">Say hi and start messaging</span>
                    @endif
                </span>
                {{-- New messages counter --}}
                {!! $unseenCounter > 0 ? '<b>' . $unseenCounter . '</b>' : '' !!}
            </td>
        </tr>
    </table>
@endif

{{-- -------------------- Search Item -------------------- --}}
@if ($get == 'search_item')
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td>
                <div class="avatar av-m"
                    style="background-image: url('{{ $user->photo ? asset('/upload/user_images/' . $user->photo) : asset('/storage/users-avatar/avatar.png') }}');">
                </div>
            </td>
            {{-- center side --}}
            <td>
                <p data-id="{{ $user->id }}" data-type="user">
                    <?php
                    $roleName = '';
                    try {
                        $roleName = $user->getRoleNames()->first() ?? '';
                    } catch (\Throwable $e) {
                        $roleName = '';
                    }
                    $shortName = strlen($user->name) > 12 ? trim(substr($user->name, 0, 12)) . '..' : $user->name;
                    $displayLabel = $roleName ? $shortName . ' (' . $roleName . ')' : $shortName;
                    ?>
                    {{ $displayLabel }}
            </td>

        </tr>
    </table>
@endif

{{-- -------------------- Shared photos Item -------------------- --}}
@if ($get == 'sharedPhoto')
    <div class="shared-photo chat-image" style="background-image: url('{{ $image }}')"></div>
@endif
